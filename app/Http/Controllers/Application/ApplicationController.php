<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Course;
use App\Models\County;
use App\Models\PostalCode;
use App\Services\ApplicationService;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    protected ApplicationService $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;

        // PUBLIC CONTROLLER — no auth needed
        // But we will throttle routes to prevent spam
        $this->middleware('throttle:10,1')->only(['store']); // 10 attempts per minute
    }

    public function showForm(Course $course)
    {
        return view('public.apply', [
            'course'      => $course,
            'counties'    => County::orderBy('name')->get(),
            'postalCodes' => PostalCode::orderBy('code')->get(),
        ]);
    }

    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        // Disk to store on (make sure 'public' exists in config/filesystems.php)
        $uploadDisk = 'public';

        // 1. FIXED UPLOAD DOCUMENTS
        $kcseCertificatePath = null;
        if ($request->hasFile('kcse_certificate')) {
            $kcseCertificatePath = $request->file('kcse_certificate')
                ->store('applications/documents', $uploadDisk);
        }

        $schoolLeavingPath = null;
        if ($request->hasFile('school_leaving_certificate')) {
            $schoolLeavingPath = $request->file('school_leaving_certificate')
                ->store('applications/documents', $uploadDisk);
        }

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
            'kcse_certificate_path'            => $kcseCertificatePath,
            'school_leaving_certificate_path'  => $schoolLeavingPath,
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

    public function payment($id)
    {
        $application = \App\Models\Application::findOrFail($id);

        return view('public.payment', compact('application'));
    }

    public function requirements(Course $course)
    {
        return $course->requirements()
            ->select('id','course_requirement','type','required')
            ->get();
    }
}
