<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCohort;
use App\Services\TimelineMatrixService;
use Illuminate\Http\Request;

class AcademicTimelineController extends Controller
{
    public function __construct(
        private TimelineMatrixService $timelineService
    ) {}

    /**
     * INDIVIDUAL COHORT – Horizontal timeline
     */
    public function cohort(CourseCohort $cohort)
    {
        $matrix = $this->timelineService->buildForCohort($cohort);

        return view(
            'admin.academic_timeline.cohort',
            compact('cohort', 'matrix')
        );
    }

    /**
     * GLOBAL – All cohorts, grouped by campus
     */
    public function global()
    {
        $matrix = $this->timelineService->buildGlobal();

        return view(
            'admin.academic_timeline.global',
            compact('matrix')
        );
    }
}

