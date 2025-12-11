<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\User;
use App\Services\Audit\AuditLogService;
use App\Services\Admin\ApplicationReviewService;
use App\Models\Course;

class RegistrarApplicationController extends Controller
{
    //
    protected ApplicationReviewService $reviewService;

    public function __construct(AuditLogService $audit, ApplicationReviewService $reviewService)
    {
        $this->audit = $audit;
        $this->reviewService = $reviewService;
    }


    /**
     * List all submitted applications
     */

    public function awaiting(Request $request)
    {
        $search = $request->get('search');

        $query = Application::where('status', 'submitted')
            ->with(['course']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('course_name', 'like', "%{$search}%");
                    });
            });
        }

        $apps = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Officers list
        $officers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['hod', 'campus_registrar']);
        })->get();

        return view('admin.registrar.applications.awaiting', compact('apps', 'officers'));
    }

    public function assigned()
    {
        $apps = Application::where('status', 'under_review')
            ->with(['course', 'reviewer'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.registrar.applications.assigned', compact('apps'));
    }

    public function completed()
    {
        $apps = Application::whereIn('status', ['approved', 'rejected'])
            ->with(['course', 'reviewer'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.registrar.applications.completed', compact('apps'));
    }

    public function index(Request $request)
    {
//        dd('here');
        $apps = Application::with(['course', 'reviewer'])
            ->where('status', 'submitted')
            ->orWhere('status', 'under_review')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $officers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['hod', 'campus_registrar']);
        })->get();



        return view('admin.registrar.applications.index', compact('apps', 'officers'));
    }

    /**
     * Assign reviewer
     */
    public function assignReviewer(Request $request, Application $application)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id'
        ]);

        $this->reviewService->assignReviewer($application, $request->reviewer_id);

        return back()->with('success', 'Application assigned successfully!');
    }
    public function view(Application $application)
    {
        $application->load([
            'course',
            'invoice',
            'answers.requirement',
            'homeCounty',
            'currentCounty',
            'currentSubcounty',
            'postalCode',
        ]);

        $meta = $application->metadata ?? [];

        $altIds = collect([
            $meta['alt_course_1_id'] ?? null,
            $meta['alt_course_2_id'] ?? null,
        ])->filter()->unique()->values();

        $alternativeCourses = collect();

        if ($altIds->isNotEmpty()) {
            $alternativeCourses = \App\Models\Course::with('college')
                ->whereIn('id', $altIds)
                ->get()
                ->values();
        }

        return view('admin.registrar.applications.view', compact('application', 'alternativeCourses'));
    }





}
