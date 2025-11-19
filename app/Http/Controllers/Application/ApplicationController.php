<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Course;
use App\Models\County;
use App\Models\PostalCode;
use App\Models\Requirement;
use App\Services\ApplicationService;

class ApplicationController extends Controller
{
    //

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
//        dd('here');
        return view('public.apply', [
            'course' => $course,
            'counties' => County::orderBy('name')->get(),
            'postalCodes' => PostalCode::orderBy('code')->get(),
        ]);
    }

    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        // Build payload for service
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

            // requirement answers
            'requirements'          => $this->mergeRequirements($request),
        ];

        $application = $this->service->create($payload);

        return redirect()->route('applications.payment', $application->id)
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
            if ($file) $answers[$key] = $file;
        }

        return $answers;
    }

    /**
     * Public payment page.
     */
    public function payment($id)
    {
        $application = \App\Models\Application::findOrFail($id);

        return view('public.payment', compact('application'));
    }

    /**
     * AJAX: fetch requirements for a course.
     */
    public function requirements(Course $course)
    {
        return $course->requirements()
            ->select('id','course_requirement','type','required')
            ->get();
    }
}
