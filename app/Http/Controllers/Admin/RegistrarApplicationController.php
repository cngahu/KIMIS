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
    public function index(Request $request)
    {
//        dd('here');
        $apps = Application::with(['course', 'reviewer'])
            ->where('status', 'submitted')
            ->orWhere('status', 'under_review')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $officers = User::role('hod')->get(); // Spatie role

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


}
