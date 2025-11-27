<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Course;

use App\Models\county;
use App\Models\PostalCode;
use App\Models\Training;
use App\Models\Application;
use App\Models\ShortTraining;
use App\Services\ApplicationService;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    protected ApplicationService $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;

        // Throttle both long-term and short-term submissions
        $this->middleware('throttle:10,1')->only(['store', 'storeShort']);
    }


//    public function showForm(Course $course)
//    {
//        return view('public.apply', [
//            'course'      => $course,
//            'counties'    => County::orderBy('name')->get(),
//            'postalCodes' => PostalCode::orderBy('code')->get(),
//        ]);
//    }


    public function showForm(Request $request, Course $course)
    {
        // Load related data you might need
        $course->load('requirements');

        // Check mode: 'Long Term' vs 'Short Term'
        $mode = $course->course_mode;   // assuming this column exists on courses table

        if (strcasecmp($mode, 'Short Term') === 0) {
            // ---- SHORT TERM FLOW ----
            $counties    = \App\Models\county::orderBy('name')->get();
            $postalCodes = \App\Models\PostalCode::orderBy('code')->get();
            // Find the specific training (by query param), or the first approved one for that course
            $training = Training::with('college')
                ->where('course_id', $course->id)
                ->where('status', 'Approved')
                ->when($request->query('training_id'), function ($q, $tid) {
                    $q->where('id', $tid);
                })
                ->orderBy('start_date')
                ->firstOrFail();

            // Show the short-course multi-applicant form
            return view('public.apply_shorttraining', compact('course', 'postalCodes','counties','training'));
        }

        // ---- LONG TERM FLOW (existing) ----

        // Whatever you previously had here:
        // e.g. load counties, postal codes, dynamic requirements etc.
        $counties    = \App\Models\county::orderBy('name')->get();
        $postalCodes = \App\Models\PostalCode::orderBy('code')->get();

        // You may or may not care about training here for long courses
        $training = Training::with('college')
            ->where('course_id', $course->id)
            ->where('status', 'Approved')
            ->when($request->query('training_id'), function ($q, $tid) {
                $q->where('id', $tid);
            })
            ->orderBy('start_date')
            ->first();

        return view('public.apply', [
            'course'      => $course,
            'counties'    => $counties,
            'postalCodes' => $postalCodes,
            'training'    => $training,
        ]);
    }

    /**
     * Store SHORT-TERM applications (multiple applicants, same course/training),
     * using the same ApplicationService logic as long-term.
     */

    public function storeShort(Request $request, Training $training)
    {
        // 1) Validate input
        $validated = $request->validate([
            'financier'      => 'required|in:self,employer',
            'employer_name'  => 'nullable|string|max:255',

            'applicants'                  => 'required|array|min:1',
            'applicants.*.full_name'      => 'required|string|max:255',
            'applicants.*.id_no'          => 'nullable|string|max:50',
            'applicants.*.phone'          => 'required|string|max:50',
            'applicants.*.email'          => 'nullable|email|max:255',
            'applicants.*.national_id'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Location fields for each applicant
            'applicants.*.home_county_id'        => 'required|exists:counties,id',
            'applicants.*.current_county_id'     => 'required|exists:counties,id',
            'applicants.*.current_subcounty_id'  => 'required|exists:subcounties,id',
            'applicants.*.postal_address'        => 'required|string|max:255',
            'applicants.*.postal_code_id'        => 'required|exists:postal_codes,id',
            'applicants.*.co'                    => 'nullable|string|max:255',
            'applicants.*.town'                  => 'nullable|string|max:255',
        ]);

        // If financier is employer, name is required
        if ($validated['financier'] === 'employer' && empty($validated['employer_name'])) {
            return back()
                ->withErrors(['employer_name' => 'Employer / Institution name is required when financier is employer.'])
                ->withInput();
        }

        $uploadDisk = 'public';
        $shortRecords = [];

        // 2) Save each applicant in short_trainings with their individual location data
        foreach ($validated['applicants'] as $index => $applicant) {

            // Handle National ID upload
            $nationalIdPath = null;
            $nationalIdOriginal = null;

            if ($request->hasFile("applicants.$index.national_id")) {
                $file = $request->file("applicants.$index.national_id");
                $nationalIdOriginal = $file->getClientOriginalName();

                $nationalIdPath = $file->store(
                    'short_trainings/national_ids',
                    $uploadDisk
                );
            }

            $shortRecords[] = ShortTraining::create([
                'training_id'              => $training->id,
                'financier'                => $validated['financier'],
                'employer_name'            => $validated['financier'] === 'employer'
                    ? $validated['employer_name']
                    : null,
                'full_name'                => $applicant['full_name'],
                'id_no'                    => $applicant['id_no'] ?? null,
                'phone'                    => $applicant['phone'] ?? null,
                'email'                    => $applicant['email'] ?? null,
                'national_id_path'         => $nationalIdPath,
                'national_id_original_name'=> $nationalIdOriginal,

                // Individual location fields for each applicant
                'home_county_id'           => $applicant['home_county_id'],
                'current_county_id'        => $applicant['current_county_id'],
                'current_subcounty_id'     => $applicant['current_subcounty_id'],
                'postal_address'           => $applicant['postal_address'],
                'postal_code_id'           => $applicant['postal_code_id'],
                'co'                       => $applicant['co'] ?? null,
                'town'                     => $applicant['town'] ?? null,
            ]);
        }

        // 3) Compute total amount to pay
        $applicantCount = count($validated['applicants']);
        $amountPerApplicant = $training->cost ?? 0;
        $totalAmount = $amountPerApplicant * $applicantCount;

        // 4) Create a "group" Application so we can reuse the existing payment flow
        $firstApplicant = $validated['applicants'][0];

        $groupFullName = $validated['financier'] === 'employer'
            ? $validated['employer_name'].' ('.$applicantCount.' trainee(s))'
            : $firstApplicant['full_name'];

        // Build payload in the same style as the long-term ApplicationController@store()
        // Use first applicant's location for the group application
        $payload = [
            'course_id'             => $training->course_id,
            'full_name'             => $groupFullName,
            'id_number'             => $firstApplicant['id_no'] ?? null,
            'phone'                 => $firstApplicant['phone'],
            'email'                 => $firstApplicant['email'] ?? null,
            'date_of_birth'         => null,

            // Use first applicant's location for the group application record
            'home_county_id'        => $firstApplicant['home_county_id'],
            'current_county_id'     => $firstApplicant['current_county_id'],
            'current_subcounty_id'  => $firstApplicant['current_subcounty_id'],
            'postal_address'        => $firstApplicant['postal_address'],
            'postal_code_id'        => $firstApplicant['postal_code_id'],
            'co'                    => $validated['financier'] === 'employer'
                ? $validated['employer_name']
                : ($firstApplicant['co'] ?? null),
            'town'                  => $firstApplicant['town'] ?? null,

            'financier'             => $validated['financier'],
            'kcse_mean_grade'       => null,
            'declaration'           => true,

            'birth_certificate_path' => null,
            'national_id_path'       => null,

            // No dynamic requirements for short courses
            'requirements'          => [],

            // Extra info in metadata
            'metadata'              => [
                'short_term'         => true,
                'training_id'        => $training->id,
                'applicant_count'    => $applicantCount,
                'amount_per_applicant' => $amountPerApplicant,
                'employer_name'      => $validated['financier'] === 'employer'
                    ? $validated['employer_name']
                    : null,
                'individual_locations' => true, // Flag to indicate locations are stored per applicant
            ],

            // 👇 we'll use this to override the invoice amount in ApplicationService
            'invoice_amount'        => $totalAmount,
        ];

        // 5) Create the Application + Invoice using the same service as long-term
        $groupApplication = $this->service->create($payload);

        // 6) Redirect to the normal payment page, like long-term applications
        return redirect()
            ->route('applications.payment', $groupApplication->id)
            ->with('success', 'Application(s) captured successfully. Proceed to payment.')
            ->with('total_amount', $totalAmount)
            ->with('applicant_count', $applicantCount);
    }


//    public function storeShort(Request $request, Training $training)
//    {
//        // 1) Validate input
//        $validated = $request->validate([
//            'financier'      => 'required|in:self,employer',
//            'employer_name'  => 'nullable|string|max:255',
//
//            'applicants'                         => 'required|array|min:1',
//            'applicants.*.full_name'            => 'required|string|max:255',
//            'applicants.*.id_no'            => 'nullable|string|max:50',
//            'applicants.*.phone'                => 'required|string|max:50',
//            'applicants.*.email'                => 'nullable|email|max:255',
//            'applicants.*.national_id'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
//        ]);
//
//        // If financier is employer, name is required
//        if ($validated['financier'] === 'employer' && empty($validated['employer_name'])) {
//            return back()
//                ->withErrors(['employer_name' => 'Employer / Institution name is required when financier is employer.'])
//                ->withInput();
//        }
//
//        $uploadDisk = 'public';
//
//        // 2) Loop through each applicant and save into short_trainings
//        foreach ($validated['applicants'] as $index => $applicant) {
//
//            $nationalIdPath = null;
//            $nationalIdOriginal = null;
//
//            if ($request->hasFile("applicants.$index.national_id")) {
//                $file = $request->file("applicants.$index.national_id");
//                $nationalIdOriginal = $file->getClientOriginalName();
//
//                $nationalIdPath = $file->store('short_trainings/national_ids', $uploadDisk);
//            }
//
//            ShortTraining::create([
//                'training_id'               => $training->id,
//                'financier'                 => $validated['financier'],
//                'employer_name'             => $validated['financier'] === 'employer'
//                    ? $validated['employer_name']
//                    : null,
//
//                'full_name'                 => $applicant['full_name'],
//                'id_no'                     => $applicant['id_no'] ?? null,
//                'phone'                     => $applicant['phone'],
//                'email'                     => $applicant['email'] ?? null,
//
//                'national_id_path'          => $nationalIdPath,
//                'national_id_original_name' => $nationalIdOriginal,
//            ]);
//        }
//
//        return redirect()
//            ->route('applications.payment', $training)
//            ->with('success', 'Short course application(s) submitted successfully.');
//    }


    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        // Disk to store on (make sure 'public' exists in config/filesystems.php)
        $uploadDisk = 'public';

        // 1. FIXED UPLOAD DOCUMENTS
//        $kcseCertificatePath = null;
//        if ($request->hasFile('kcse_certificate')) {
//            $kcseCertificatePath = $request->file('kcse_certificate')
//                ->store('applications/documents', $uploadDisk);
//        }
//
//        $schoolLeavingPath = null;
//        if ($request->hasFile('school_leaving_certificate')) {
//            $schoolLeavingPath = $request->file('school_leaving_certificate')
//                ->store('applications/documents', $uploadDisk);
//        }

        $birthCertificatePath = null;
        if ($request->hasFile('birth_certificate')) {
            $birthCertificatePath = $request->file('birth_certificate')
                ->store('applications/documents', $uploadDisk);
        }

        $nationalIdPath = null;
        if ($request->hasFile('national_id')) {
            $nationalIdPath = $request->file('national_id')
                ->store('applications/documents', $uploadDisk);
        }

        // 2. BUILD PAYLOAD FOR SERVICE
        $payload = [
            'course_id'             => $validated['course_id'],
            'full_name'             => $validated['full_name'],
            'id_number'             => $validated['id_number'] ?? null,
            'phone'                 => $validated['phone'],
            'email'                 => $validated['email'] ?? null,
            'date_of_birth'         => $validated['date_of_birth'] ?? null,
            'home_county_id'        => $validated['home_county_id'],
            'current_county_id'     => $validated['current_county_id'],
            'current_subcounty_id'  => $validated['current_subcounty_id'],
            'postal_address'        => $validated['postal_address'],
            'postal_code_id'        => $validated['postal_code_id'],
            'co'                    => $validated['co'] ?? null,
            'town'                  => $validated['town'] ?? null,
            'financier'             => $validated['financier'],
            'kcse_mean_grade'       => $validated['kcse_mean_grade'],
            'declaration'           => true,

            // NEW: fixed upload paths
            //'kcse_certificate_path'            => $kcseCertificatePath,
           // 'school_leaving_certificate_path'  => $schoolLeavingPath,
            'birth_certificate_path'           => $birthCertificatePath,
            'national_id_path'                 => $nationalIdPath,

            // REQUIREMENT ANSWERS (dynamic)
            'requirements'          => $this->mergeRequirements($request),
        ];


        $application = $this->service->create($payload);

        return redirect()
            ->route('applications.payment', $application->id)
            ->with('success', 'Proceed to payment to complete your application.');
    }


    protected function mergeRequirements(Request $request): array
    {
        $answers = [];

        $textInputs = $request->input('requirements', []);
        $fileInputs = $request->file('requirements', []);

        foreach ($textInputs as $key => $value) {
            $answers[$key] = $value;
        }

        foreach ($fileInputs as $key => $file) {
            if ($file) {
                // You can either:
                // (a) Store here like we did above, OR
                // (b) Pass the UploadedFile to the service and let it handle storage.
                $answers[$key] = $file;
            }
        }

        return $answers;
    }

//    public function payment($id)
//    {
//        $application = \App\Models\Application::findOrFail($id);
//
//        return view('public.payment', compact('application'));
//    }
    public function payment($id)
    {
        // Load application + invoice + course
        $application = Application::with(['invoice', 'course'])->findOrFail($id);

        $shortApplicants = collect();

        $meta    = $application->metadata ?? [];
        $isShort = !empty($meta['short_term']) && !empty($meta['training_id']);

        if ($isShort) {
            // 1) Get the training so we know the unit cost
            $training = Training::find($meta['training_id']);
            $unitFee  = $training?->cost;

            // 2) Work out how many applicants belong to THIS invoice
            $invoice        = $application->invoice;
            $applicantCount = null;

            if ($invoice && $unitFee && $unitFee > 0) {
                // e.g. invoice amount = unitFee * number_of_applicants
                $applicantCount = (int) floor($invoice->amount / $unitFee);

                if ($applicantCount < 1) {
                    $applicantCount = 1;
                }
            }

            // 3) Fetch short applicants for this training + financier (+ employer)
            //    and only keep the MOST RECENT N (the current batch)
            $query = ShortTraining::where('training_id', $meta['training_id'])
                ->where('financier', $application->financier)
                ->when(
                    $application->financier === 'employer' && !empty($meta['employer_name']),
                    function ($q) use ($meta) {
                        $q->where('employer_name', $meta['employer_name']);
                    }
                )
                ->orderByDesc('id'); // newest first

            if ($applicantCount) {
                $query->take($applicantCount);
            }

            // Re-sort ascending for nicer display
            $shortApplicants = $query->get()->sortBy('id')->values();
        }

        return view('public.payment', [
            'application'     => $application,
            'shortApplicants' => $shortApplicants,
        ]);
    }

    public function requirements(Course $course)
    {
        return $course->requirements()
            ->select('id','course_requirement','type','required')
            ->get();
    }
}
