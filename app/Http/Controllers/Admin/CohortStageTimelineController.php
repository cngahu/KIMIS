<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CohortStageTimeline;
use App\Models\CourseCohort;
use App\Models\CourseStage;
use App\Services\Audit\AuditLogService;
use App\Services\CohortStageTimelineService;
use Illuminate\Http\Request;

class CohortStageTimelineController extends Controller
{
    public function __construct(
        private CohortStageTimelineService $service,
        private AuditLogService $auditLog
    ) {}

    /**
     * OVERVIEW page (Excel-like, read-first)
     */
    public function index(CourseCohort $cohort)
    {
        $overview = $this->service->overview($cohort);

        return view(
            'admin.cohort_timelines.index',
            compact('cohort', 'overview')
        );
    }

    /**
     * Show form to add a stage to timeline
     */
    public function create(CourseCohort $cohort)
    {
        $stages = CourseStage::orderBy('code')->get();

        return view(
            'admin.cohort_timelines.create',
            compact('cohort', 'stages')
        );
    }

    /**
     * Store timeline entry
     */
    public function store(Request $request, CourseCohort $cohort)
    {
//        $validated = $request->validate([
//            'course_stage_id' => 'required|exists:course_stages,id',
//            'start_date'      => 'required|date',
//            'end_date'        => 'required|date|after_or_equal:start_date',
//        ]);
//
//        $timeline = $this->service->create([
//            ...$validated,
//            'course_cohort_id' => $cohort->id,
//        ]);
//
//        $this->auditLog->logModelChange('Added cohort stage timeline', $timeline);
        $validated = $request->validate([
            'course_stage_id' => 'required|exists:course_stages,id',
            'cycle_month'     => 'required|in:1,5,9',
            'cycle_year'      => 'required|digits:4',
        ]);

        $timeline = $this->service->createFromCycle([
            'course_cohort_id' => $cohort->id,
            'course_stage_id'  => $validated['course_stage_id'],
            'cycle_month'      => (int) $validated['cycle_month'],
            'cycle_year'       => (int) $validated['cycle_year'],
        ]);

        $this->auditLog->logModelChange('Added cohort stage timeline', $timeline);


        return redirect()
            ->route('cohort_timelines.index', $cohort)
            ->with('success', 'Stage added to cohort timeline.');
    }

    public function edit(CourseCohort $cohort, CohortStageTimeline $timeline)
    {
        $stages = CourseStage::orderBy('code')->get();

        return view(
            'admin.cohort_timelines.edit',
            compact('cohort', 'timeline', 'stages')
        );
    }
    public function update(Request $request, CourseCohort $cohort, CohortStageTimeline $timeline)
    {
        $validated = $request->validate([
            'course_stage_id' => 'required|exists:course_stages,id',
            'cycle_month'     => 'required|in:1,5,9',
            'cycle_year'      => 'required|digits:4',
        ]);

        $updated = $this->service->updateFromCycle(
            $timeline,
            $validated
        );

        $this->auditLog->logModelChange('Updated cohort stage timeline', $updated);

        return redirect()
            ->route('cohort_timelines.index', $cohort)
            ->with('success', 'Stage timeline updated.');
    }

}

