<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\User;
use App\Services\Audit\AuditLogService;
use App\Services\Admin\ApplicationReviewService;

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

    public function awaiting()
    {
        $apps = Application::where('status', 'submitted')
            ->with(['course', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $officers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['hod', 'campus_registrar']);
        })->get();
        $counts = [
            'awaiting' => Application::where('status','submitted')->count(),
            'assigned' => Application::where('status','under_review')->count(),
            'completed' => Application::whereIn('status',['approved','rejected'])->count(),
        ];
        return view('admin.registrar.applications.awaiting', compact('apps','officers','counts'));

//        return view('admin.registrar.applications.awaiting', compact('apps', 'officers'));
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
        $application->load(['course', 'invoice', 'answers.requirement']);

        return view('admin.registrar.applications.view', compact('application'));
    }

}
