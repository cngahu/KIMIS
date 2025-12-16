<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Course;

use App\Models\County;
use App\Models\PostalCode;
use App\Models\Training;
use App\Models\Application;
use App\Models\ShortTraining;
use App\Services\ApplicationService;
use Illuminate\Support\Facades\Http;
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
    public function show0(Invoice $invoice)
    {

        if ($invoice->category !== 'short_course') {
            abort(404, "Invalid invoice type.");
        }

        $meta = $invoice->metadata ?? [];
        $appId = $meta['short_training_application_id'] ?? null;

        $application = \App\Models\ShortTrainingApplication::with('participants')
            ->findOrFail($appId);

        $participants = $application->participants;

        // Determine who is paying
        if ($application->financier === 'employer') {
            $payer = [
                'type' => 'employer',
                'name' => $application->employer_name,
                'contact_person' => $application->employer_contact_person,
                'email' => $application->employer_email,
                'phone' => $application->employer_phone,
                'address' => $application->employer_postal_address,
                'town' => $application->employer_town,
                'county' => optional($application->employerCounty)->name,
            ];
        } else {
            // Self-sponsored → use first participant as payer
            $first = $participants->first();
            $payer = [
                'type' => 'self',
                'name' => $first->full_name,
                'email' => $first->email,
                'phone' => $first->phone,
                'address' => $first->postal_address,
                'town' => $first->town,
                'county' => optional($first->currentCounty)->name,
            ];
        }

        return view('public.payments.payment', compact(
            'invoice',
            'application',
            'participants',
            'payer'
        ));
    }
    public function show(Invoice $invoice)
    {
        // Resolve the billable model (Application, ShortTrainingApplication, etc.)
        $billable = $invoice->billable;

        if (! $billable) {
            abort(404, "Invoice is not linked to a valid billable record.");
        }

        // Check invoice category
        if ($invoice->category !== 'short_course') {
            abort(404, "Invalid invoice type.");
        }

        // billable is ShortTrainingApplication model
        /** @var \App\Models\ShortTrainingApplication $application */
        $application = $billable->load('participants');
        $participants = $application->participants;

        // Determine who is paying
        if ($application->financier === 'employer') {
            $payer = [
                'type'           => 'employer',
                'name'           => $application->employer_name,
                'contact_person' => $application->employer_contact_person,
                'email'          => $application->employer_email,
                'phone'          => $application->employer_phone,
                'address'        => $application->employer_postal_address,
                'town'           => $application->employer_town,
                'county'         => optional($application->employerCounty)->name,
            ];
        } else {
            // Self-sponsored → use first participant
            $first = $participants->first();

            $payer = [
                'type'    => 'self',
                'name'    => $first->full_name,
                'email'   => $first->email,
                'phone'   => $first->phone,
                'address' => $first->postal_address,
                'town'    => $first->town,
                'county'  => optional($first->currentCounty)->name,
            ];
        }

        return view('public.payments.payment', compact(
            'invoice',
            'application',
            'participants',
            'payer'
        ));
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
        $course->load('requirements', 'college');

        // Check mode: 'Long Term' vs 'Short Term'
        $mode = $course->course_mode;

        if (strcasecmp($mode, 'Short Term') === 0) {
            // SHORT TERM FLOW (unchanged)
            $counties    = County::orderBy('name')->get();
            $postalCodes = PostalCode::orderBy('code')->get();

            $training = Training::with('college')
                ->where('course_id', $course->id)
                ->where('status', 'Approved')
                ->when($request->query('training_id'), function ($q, $tid) {
                    $q->where('id', $tid);
                })
                ->orderBy('start_date')
                ->firstOrFail();

            return view('public.apply_shorttraining', compact('course', 'postalCodes','counties','training'));
        }

        // ---- LONG TERM FLOW ----
        $counties    = County::orderBy('name')->get();
        $postalCodes = PostalCode::orderBy('code')->get();

        $training = Training::with('college')
            ->where('course_id', $course->id)
            ->where('status', 'Approved')
            ->when($request->query('training_id'), function ($q, $tid) {
                $q->where('id', $tid);
            })
            ->orderBy('start_date')
            ->first();

        // 🔹 Alternative courses: only Long Term, exclude current
        $alternativeCourses = Course::with('college')
            ->where('course_mode', 'Long Term')
            ->where('id', '<>', $course->id)
            ->orderBy('course_name')
            ->get();

        return view('public.apply', [
            'course'             => $course,
            'counties'           => $counties,
            'postalCodes'        => $postalCodes,
            'training'           => $training,
            'alternativeCourses' => $alternativeCourses,
        ]);
    }

    /**
     * Store SHORT-TERM applications (multiple applicants, same course/training),
     * using the same ApplicationService logic as long-term.
     */

    public function storeShort1(Request $request, Training $training)
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
    public function storeShort2(Request $request, Training $training)
    {
        $validated = $request->validate([
            'financier' => 'required|in:self,employer',

            // Employer fields


            'employer_name' => 'nullable|required_if:financier,employer|string|max:255',
            'employer_contact_person' => 'nullable|required_if:financier,employer|string|max:255',
            'employer_phone' => 'nullable|required_if:financier,employer|string|max:50',
            'employer_email' => 'nullable|required_if:financier,employer|email|max:255',
            'employer_postal_address' => 'nullable|required_if:financier,employer|string|max:255',
            'employer_postal_code_id' => 'nullable|required_if:financier,employer|exists:postal_codes,id',
            'employer_town' => 'nullable|required_if:financier,employer|string|max:255',
            'employer_county_id' => 'nullable|required_if:financier,employer|exists:counties,id',


            // Participants
            'applicants' => 'required|array|min:1',
            'applicants.*.full_name' => 'required|string|max:255',
            'applicants.*.id_no' => 'nullable|string|max:50',
            'applicants.*.phone' => 'required|string|max:50',
            'applicants.*.email' => 'nullable|email|max:255',
            'applicants.*.national_id' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Location fields
            'applicants.*.home_county_id' => 'required|exists:counties,id',
            'applicants.*.current_county_id' => 'required|exists:counties,id',
            'applicants.*.current_subcounty_id' => 'required|exists:subcounties,id',
            'applicants.*.postal_address' => 'required|string|max:255',
            'applicants.*.postal_code_id' => 'required|exists:postal_codes,id',
            'applicants.*.co' => 'nullable|string|max:255',
            'applicants.*.town' => 'nullable|string|max:255',
        ]);

        // Pass to service
        $service = app(\App\Services\ShortTrainingApplicationService::class);

        $application = $service->createShortApplication($training, $validated, $request);
        $invoice = $service->createShortApplication($training, $validated, $request);

        return redirect()
            ->route('short_training.payment', $invoice->id)
            ->with('success', 'Application captured successfully. Proceed to payment.')
            ->with('total_amount', $invoice->amount)
            ->with('applicant_count', $invoice->metadata['total_participants']);
    }
    public function storeShort(Request $request, Training $training)
    {
        // --------------------------------------
        // 1) VALIDATION
        // --------------------------------------
        $validated = $request->validate([
            'financier' => 'required|in:self,employer',

            // Employer fields
            'employer_name'             => 'nullable|required_if:financier,employer|string|max:255',
            'employer_contact_person'   => 'nullable|required_if:financier,employer|string|max:255',
            'employer_phone'            => 'nullable|required_if:financier,employer|string|max:50',
            'employer_email'            => 'nullable|required_if:financier,employer|email|max:255',
            'employer_postal_address'   => 'nullable|required_if:financier,employer|string|max:255',
            'employer_postal_code_id'   => 'nullable|required_if:financier,employer|exists:postal_codes,id',
            'employer_town'             => 'nullable|required_if:financier,employer|string|max:255',
            'employer_county_id'        => 'nullable|required_if:financier,employer|exists:counties,id',

            // Participants
            'applicants' => 'required|array|min:1',

            'applicants.*.full_name'      => 'required|string|max:255',
            'applicants.*.id_no'          => 'nullable|string|max:50',
            'applicants.*.phone'          => 'required|string|max:50',
            'applicants.*.email'          => 'nullable|email|max:255',
            'applicants.*.national_id'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Location fields
            'applicants.*.home_county_id'        => 'required|exists:counties,id',
            'applicants.*.current_county_id'     => 'required|exists:counties,id',
            'applicants.*.current_subcounty_id'  => 'required|exists:subcounties,id',
            'applicants.*.postal_address'        => 'required|string|max:255',
            'applicants.*.postal_code_id'        => 'required|exists:postal_codes,id',
            'applicants.*.co'                    => 'nullable|string|max:255',
            'applicants.*.town'                  => 'nullable|string|max:255',
        ]);

        // --------------------------------------
        // 2) DELEGATE TO SERVICE FOR SAVING
        // --------------------------------------
        $service = app(\App\Services\ShortTrainingApplicationService::class);

        // This now returns the generated invoice
        $invoice = $service->createShortApplication($training, $validated, $request);

        // --------------------------------------
        // 3) REDIRECT TO PAYMENT PAGE
        // --------------------------------------
        return redirect()
            ->route('short_training.payment', $invoice->id)
            ->with('success', 'Application captured successfully. Proceed to payment.')
            ->with('total_amount', $invoice->amount)
            ->with('applicant_count', $invoice->metadata['total_participants']);
    }

        // Redirect to invoice/payment
//        return redirect()
//            ->route('applications.payment', $application->id)
//            ->with('success', 'Application captured successfully. Proceed to payment.')
//            ->with('total_amount', $application->metadata['total_amount'])
//            ->with('applicant_count', $application->total_participants);
//    }


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

        $uploadDisk = 'public';

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

        $payload = [
            'salutation' => $validated['salutation'],
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

            'birth_certificate_path' => $birthCertificatePath,
            'national_id_path'       => $nationalIdPath,

            'requirements'          => $this->mergeRequirements($request),

            // 🔹 store alternative choices in metadata
            'metadata'              => [
                'alt_course_1_id' => $validated['alt_course_1_id'] ?? null,
                'alt_course_2_id' => $validated['alt_course_2_id'] ?? null,
            ],
        ];

        $application = $this->service->create($payload);

        return redirect()
            ->route('applications.payment', $application->id)
            ->with('success', 'Proceed to payment to complete your application.');
    }

    public function store1(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        $uploadDisk = 'public';

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

            'birth_certificate_path' => $birthCertificatePath,
            'national_id_path'       => $nationalIdPath,

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
    public function payment0($id)
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
    public function paymentbk($id)
    {

        // Load application + invoice + course
        $application = Application::with(['invoice', 'course'])->findOrFail($id);

        // existing short-term logic...
        $shortApplicants = collect();

        $meta    = $application->metadata ?? [];
        $isShort = !empty($meta['short_term']) && !empty($meta['training_id']);

        if ($isShort) {
            // ... your short applicants logic unchanged ...
            $training = Training::find($meta['training_id']);
            $unitFee  = $training?->cost;
            $invoice        = $application->invoice;
            $applicantCount = null;

            if ($invoice && $unitFee && $unitFee > 0) {
                $applicantCount = (int) floor($invoice->amount / $unitFee);
                if ($applicantCount < 1) {
                    $applicantCount = 1;
                }
            }

            $query = ShortTraining::where('training_id', $meta['training_id'])
                ->where('financier', $application->financier)
                ->when(
                    $application->financier === 'employer' && !empty($meta['employer_name']),
                    function ($q) use ($meta) {
                        $q->where('employer_name', $meta['employer_name']);
                    }
                )
                ->orderByDesc('id');

            if ($applicantCount) {
                $query->take($applicantCount);
            }

            $shortApplicants = $query->get()->sortBy('id')->values();
        }

        // ----------------- Pesaflow/eCitizen data -----------------
        // only prepare payment payload if invoice exists and status != paid
        $pesaflow = null;

        if ($application->invoice && $application->invoice->status !== 'paid') {
            // load config from env (put these in .env)
//            $apiClientID = env('PF_CLIENT_ID', '35');
//            $secret      = env('PF_SECRET', '7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw');
//            $key         = env('PF_KEY', 'Fhtuo4tuMATrqmtL');
//            $serviceID   = env('PF_SERVICE_ID', '234330');

            $apiClientID = "35";
            $serviceID   = "234330";

            $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";   // appended in string
            $key    = "Fhtuo4tuMATrqmtL";
            // choose amount expected (cents? Pesaflow expects integer amounts as in your integration)
            // Use the invoice->amount (assume stored as numeric (e.g. 50000.00) — cast to integer or string as appropriate)
            $amountExpected = (int) round($application->invoice->amount); // ensure integer

            $billRefNumber = $application->invoice->invoice_number ?? 'INV-' . $application->id;
            $billDesc      = $application->course->course_name ?? 'Training Payment';
            $clientName    = $application->full_name ?? ($application->applicant_name ?? 'Client');
            $clientEmail   = $application->email ?? ($application->client_email ?? '');
            $clientMSISDN  = $application->phone ?? ($application->client_phone ?? '');
            $clientIDNumber = $application->id_number ?? 'A12345678';
            $currency = "KES";

            // Build the data string exactly as Pesaflow expects
//            $dataString = $apiClientID
//                . $amountExpected
//                . $serviceID
//                . $clientIDNumber
//                . $currency
//                . $billRefNumber
//                . $billDesc
//                . $clientName
//                . $secret;
//
//            $hash = hash_hmac('sha256', $dataString, $key);
//            $secureHash = base64_encode($hash);

            $dataString =
                $apiClientID .
                $serviceID .
                $billRefNumber .
                $amountExpected .
                $currency .
                $clientIDNumber .
                $secret;

            $hash = hash_hmac('sha256', $dataString, $key);
            $secureHash = base64_encode($hash);


            $data_string = "$apiClientID"."$amountExpected"."$serviceID"."$clientIDNumber"."$currency"."$billRefNumber"."$billDesc"     . "$clientName"."$secret";
            // Step 2 hash the values
            $hash = hash_hmac('sha256', $data_string, $key);
            // Step 3 encode
            $my_secureHash = base64_encode($hash);

//            dd($secureHash, $my_secureHash);
            // callback/notification URLs — change to real routes
//            $callBackURLOnSuccess = route('payments.success');    // define route
//            $notificationURL = route('payments.notify');         // define route
            $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
            $notificationURL = "https://portal.pck.go.ke/api/pesaflow/confirm";
            $pesaflow = [
//                'secureHash' => $secureHash,
                'secureHash' => $my_secureHash,
                'apiClientID' => $apiClientID,
                'serviceID' => $serviceID,
                'billDesc' => $billDesc,
                'billRefNumber' => $billRefNumber,
                'currency' => $currency,
                'clientMSISDN' => $clientMSISDN,
                'clientName' => $clientName,
                'clientIDNumber' => $clientIDNumber,
                'clientEmail' => $clientEmail,
                'callBackURLOnSuccess' => $callBackURLOnSuccess,
                'notificationURL' => $notificationURL,
                'amountExpected' => $amountExpected,
            ];
        }


        if (!empty($pesaflow)) {

            // Prepare the POST payload
            $payload = [
                'secureHash'            => $my_secureHash,
                'apiClientID'           => $pesaflow['apiClientID'],
                'sendSTK'               => 'True',
                'format'                => 'iframe',
                'billDesc'              => $pesaflow['billDesc'],
                'billRefNumber'         => $pesaflow['billRefNumber'],
                'currency'              => $pesaflow['currency'],
                'serviceID'             => $pesaflow['serviceID'],
                'clientMSISDN'          => $pesaflow['clientMSISDN'],
                'clientName'            => $pesaflow['clientName'],
                'clientIDNumber'        => $pesaflow['clientIDNumber'],
                'clientEmail'           => $pesaflow['clientEmail'],
                'callBackURLOnSuccess'  => $pesaflow['callBackURLOnSuccess'],
                'notificationURL'       => $pesaflow['notificationURL'],
                'amountExpected'        => $pesaflow['amountExpected'],
            ];

            // 🧪 Hit Pesaflow test endpoint directly
            $response = Http::asForm()->post(
                'https://test.pesaflow.com/PaymentAPI/iframev2.1.php',
                $payload
            );

            // 🔍 Dump the status + body (this is what the iframe is hiding!)
            dd($response->status(), $response->body(), $response->json());

        }

        return view('public.payment', [
            'application' => $application,
            'shortApplicants' => $shortApplicants,
            // pass pesaflow (can be null if already paid or invoice missing)
            'pesaflow' => $pesaflow,
            'isShort' => $isShort,
            'meta' => $meta,
        ]);
    }
    public function payment($id)
    {

        // Load application + invoice + course
        $application = Application::with(['invoice', 'course'])->findOrFail($id);

        // existing short-term logic...
        $shortApplicants = collect();

        $meta    = $application->metadata ?? [];
        $isShort = !empty($meta['short_term']) && !empty($meta['training_id']);

        if ($isShort) {
            // ... your short applicants logic unchanged ...
            $training = Training::find($meta['training_id']);
            $unitFee  = $training?->cost;
            $invoice        = $application->invoice;
            $applicantCount = null;

            if ($invoice && $unitFee && $unitFee > 0) {
                $applicantCount = (int) floor($invoice->amount / $unitFee);
                if ($applicantCount < 1) {
                    $applicantCount = 1;
                }
            }

            $query = ShortTraining::where('training_id', $meta['training_id'])
                ->where('financier', $application->financier)
                ->when(
                    $application->financier === 'employer' && !empty($meta['employer_name']),
                    function ($q) use ($meta) {
                        $q->where('employer_name', $meta['employer_name']);
                    }
                )
                ->orderByDesc('id');

            if ($applicantCount) {
                $query->take($applicantCount);
            }

            $shortApplicants = $query->get()->sortBy('id')->values();
        }

        // ----------------- Pesaflow/eCitizen data -----------------
        // only prepare payment payload if invoice exists and status != paid
        $pesaflow = null;

        if ($application->invoice && $application->invoice->status !== 'paid') {
            // load config from env (put these in .env)
//            $apiClientID = env('PF_CLIENT_ID', '35');
//            $secret      = env('PF_SECRET', '7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw');
//            $key         = env('PF_KEY', 'Fhtuo4tuMATrqmtL');
//            $serviceID   = env('PF_SERVICE_ID', '234330');

            $apiClientID = "35";
            $serviceID   = "234330";

            $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";   // appended in string
            $key    = "Fhtuo4tuMATrqmtL";
            // choose amount expected (cents? Pesaflow expects integer amounts as in your integration)
            // Use the invoice->amount (assume stored as numeric (e.g. 50000.00) — cast to integer or string as appropriate)
            $amountExpected = (int) round($application->invoice->amount); // ensure integer

            $billRefNumber = $application->invoice->invoice_number ?? 'INV-' . $application->id;
            $billDesc      = $application->course->course_name ?? 'Training Payment';
            $clientName    = $application->full_name ?? ($application->applicant_name ?? 'Client');
            $clientEmail   = $application->email ?? ($application->client_email ?? '');
            $clientMSISDN  = $application->phone ?? ($application->client_phone ?? '');
            $clientIDNumber = $application->id_number ?? 'A12345678';
            $currency = "KES";

            // Build the data string exactly as Pesaflow expects
//            $dataString = $apiClientID
//                . $amountExpected
//                . $serviceID
//                . $clientIDNumber
//                . $currency
//                . $billRefNumber
//                . $billDesc
//                . $clientName
//                . $secret;
//
//            $hash = hash_hmac('sha256', $dataString, $key);
//            $secureHash = base64_encode($hash);

            $dataString =
                $apiClientID .
                $serviceID .
                $billRefNumber .
                $amountExpected .
                $currency .
                $clientIDNumber .
                $secret;

            $hash = hash_hmac('sha256', $dataString, $key);
            $secureHash = base64_encode($hash);


            $data_string = "$apiClientID"."$amountExpected"."$serviceID"."$clientIDNumber"."$currency"."$billRefNumber"."$billDesc"     . "$clientName"."$secret";
            // Step 2 hash the values
            $hash = hash_hmac('sha256', $data_string, $key);
            // Step 3 encode
            $my_secureHash = base64_encode($hash);

//            dd($secureHash, $my_secureHash);
            // callback/notification URLs — change to real routes
//            $callBackURLOnSuccess = route('payments.success');    // define route
//            $notificationURL = route('payments.notify');         // define route
            $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
            $notificationURL = "https://portal.pck.go.ke/api/pesaflow/confirm";
            $pesaflow = [
//                'secureHash' => $secureHash,
                'secureHash' => $my_secureHash,
                'apiClientID' => $apiClientID,
                'serviceID' => $serviceID,
                'billDesc' => $billDesc,
                'billRefNumber' => $billRefNumber,
                'currency' => $currency,
                'clientMSISDN' => $clientMSISDN,
                'clientName' => $clientName,
                'clientIDNumber' => $clientIDNumber,
                'clientEmail' => $clientEmail,
                'callBackURLOnSuccess' => $callBackURLOnSuccess,
                'notificationURL' => $notificationURL,
                'amountExpected' => $amountExpected,
            ];
        }

        $convenience = 50;
        $serviceID = 234330;

        $total = 50000 + $convenience;

        // Test values you provided in Blade:
        $clientMSISDN = '0700123456';
        $clientEmail  = 'canjetan.ngahu@icta.go.ke';

        $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
        $notificationURL      = 'https://portal.pck.go.ke/api/pesaflow/confirm';

        $apiClientID      = '35';
        $amountExpected   = 190; // SAME as Blade
        $clientIDNumber   = 'A123456783';
        $currency         = 'KES';
        $billRefNumber    = 'PCK20240011';
        $billDesc         = 'KIBI TEST PAYMENT';
        $clientName       = 'Canjetan Ngahu';

        $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";
        $key    = "Fhtuo4tuMATrqmtL";

        // ----------------------------------------------------------
        // 2. BUILD THE DATA STRING EXACTLY LIKE YOUR BLADE SNIPPET
        // ----------------------------------------------------------
        $dataString =
            $apiClientID .
            $amountExpected .
            $serviceID .
            $clientIDNumber .
            $currency .
            $billRefNumber .
            $billDesc .
            $clientName .
            $secret;

        // Hash and encode:
        $hash = hash_hmac('sha256', $dataString, $key);
        $secureHash = base64_encode($hash);

        // ----------------------------------------------------------
        // 3. BUILD PAYLOAD EXACTLY LIKE THE IFRAME SUBMISSION
        // ----------------------------------------------------------
        $payload = [
            'secureHash'            => $secureHash,
            'apiClientID'           => $apiClientID,
            'sendSTK'               => 'True',
            'format'                => 'iframe',
            'billDesc'              => $billDesc,
            'billRefNumber'         => $billRefNumber,
            'currency'              => $currency,
            'serviceID'             => $serviceID,
            'clientMSISDN'          => $clientMSISDN,
            'clientName'            => $clientName,
            'clientIDNumber'        => $clientIDNumber,
            'clientEmail'           => $clientEmail,
            'callBackURLOnSuccess'  => $callBackURLOnSuccess,
            'notificationURL'       => $notificationURL,
            'amountExpected'        => $amountExpected,
        ];

        // ----------------------------------------------------------
        // 4. TEST CALL TO PESAFLOW (backend)
        // ----------------------------------------------------------
        $response = Http::asForm()->timeout(40)->post(
            'https://test.pesaflow.com/PaymentAPI/iframev2.1.php',
            $payload
        );

        // Return raw response for debugging

//        if (!empty($pesaflow)) {
//
//            // Prepare the POST payload
//            $payload = [
//                'secureHash'            => $my_secureHash,
//                'apiClientID'           => $apiClientID,
//                'sendSTK'               => 'True',
//                'format'                => 'iframe',
//                'billDesc'              => $billDesc,
//                'billRefNumber'         => $billRefNumber,
//                'currency'              => $currency,
//                'serviceID'             => $serviceID,
//                'clientMSISDN'          => '0700924662',
//                'clientName'            => $pesaflow['clientName'],
//                'clientIDNumber'        => $pesaflow['clientIDNumber'],
//                'clientEmail'           => $pesaflow['clientEmail'],
//                'callBackURLOnSuccess'  => $pesaflow['callBackURLOnSuccess'],
//                'notificationURL'       => $pesaflow['notificationURL'],
//                'amountExpected'        => $pesaflow['amountExpected'],
//            ];
//
//            // 🧪 Hit Pesaflow test endpoint directly
//            $response = Http::asForm()->post(
//                'https://test.pesaflow.com/PaymentAPI/iframev2.1.php',
//                $payload
//            );
//
//            // 🔍 Dump the status + body (this is what the iframe is hiding!)
//            dd($response->status(),$payload, $response->body(), $response->json());
//
//        }

        return view('public.payment', [
            'application' => $application,
            'shortApplicants' => $shortApplicants,
            // pass pesaflow (can be null if already paid or invoice missing)
            'pesaflow' => $payload,
            'isShort' => $isShort,
            'meta' => $meta,
        ]);
    }

    public function requirements(Course $course)
    {
        return $course->requirements()
            ->select('id','course_requirement','type','required')
            ->get();
    }
}
