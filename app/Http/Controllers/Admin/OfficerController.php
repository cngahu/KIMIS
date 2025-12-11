<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Services\Admin\ApplicationReviewService;
use Illuminate\Support\Facades\Auth;

class OfficerController extends Controller
{
    protected ApplicationReviewService $review;

    public function __construct(ApplicationReviewService $review)
    {
        $this->review = $review;
    }

    /**
     * PENDING (under_review) applications for this officer
     */
    public function pending(Request $request)
    {
        $officerId = Auth::id();
        $search    = $request->get('search');

        // Base query for this officer's pending apps
        $query = Application::where('reviewer_id', $officerId)
            ->where('status', 'under_review')
            ->with('course');

        // Apply search (by ref, name, course)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('course_name', 'like', "%{$search}%");
                    });
            });
        }

        // Total pending for this officer (ignoring search)
        $totalAll = Application::where('reviewer_id', $officerId)
            ->where('status', 'under_review')
            ->count();

        // Paginated results (respect search)
        $apps = $query
            ->orderBy('updated_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('officer.applications.pending', compact('apps', 'totalAll', 'search'));
    }

    /**
     * COMPLETED (approved/rejected) applications for this officer
     */
    public function completed(Request $request)
    {
        $officerId = Auth::id();
        $search    = $request->get('search');

        $query = Application::where('reviewer_id', $officerId)
            ->whereIn('status', ['approved', 'rejected'])
            ->with('course');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('course_name', 'like', "%{$search}%");
                    });
            });
        }

        // Total completed for this officer (no search filter)
        $totalAll = Application::where('reviewer_id', $officerId)
            ->whereIn('status', ['approved', 'rejected'])
            ->count();

        $apps = $query
            ->orderBy('updated_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('officer.applications.completed', compact('apps', 'totalAll', 'search'));
    }

    public function reviewPage(Application $application)
    {
        // Ensure only assigned officer can view
        abort_if($application->reviewer_id !== Auth::id(), 403);

        // Log “viewed”
        $this->review->markViewed($application);

        $application->load([
            'course',
            'invoice',
            'answers.requirement',
            'homeCounty',
            'currentCounty',
            'currentSubcounty',
            'postalCode',
            'altCourse1',
            'altCourse2',
        ]);

        return view('officer.applications.review', compact('application'));
    }

    public function approve(Request $request, Application $application)
    {
        abort_if($application->reviewer_id !== Auth::id(), 403);

        $data = $request->validate([
            'comments'           => 'required|string',
            'approved_course_id' => 'required|exists:courses,id',
        ]);

        $this->review->approve(
            $application,
            $data['comments'],
            (int) $data['approved_course_id']
        );

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
