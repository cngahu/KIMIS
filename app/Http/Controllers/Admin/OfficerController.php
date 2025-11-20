<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\Admin\ApplicationReviewService;

use Illuminate\Support\Facades\Auth;
class OfficerController extends Controller
{
    //

    protected ApplicationReviewService $review;

    public function __construct(ApplicationReviewService $review)
    {
        $this->review = $review;
    }

    public function pending()
    {
        $apps = Application::where('reviewer_id', Auth::id())
            ->where('status', 'under_review')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('officer.applications.pending', compact('apps'));
    }

    public function completed()
    {
        $apps = Application::where('reviewer_id', Auth::id())
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('officer.applications.completed', compact('apps'));
    }

    public function reviewPage(Application $application)
    {
        // Ensure only assigned officer can view
        abort_if($application->reviewer_id !== Auth::id(), 403);

        // Log “viewed”
        $this->review->markViewed($application);

        $application->load(['course','invoice','answers.requirement']);

        return view('officer.applications.review', compact('application'));
    }

    public function approve(Request $request, Application $application)
    {
        abort_if($application->reviewer_id !== Auth::id(), 403);

        $this->review->approve($application, $request->comments);

        return redirect()->route('officer.applications.completed')
            ->with('success', 'Application approved successfully!');
    }

    public function reject(Request $request, Application $application)
    {
        abort_if($application->reviewer_id !== Auth::id(), 403);

        $request->validate(['comments' => 'required']);

        $this->review->reject($application, $request->comments);

        return redirect()->route('officer.applications.completed')
            ->with('success', 'Application rejected.');
    }
}
