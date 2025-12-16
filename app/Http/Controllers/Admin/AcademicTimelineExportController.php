<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCohort;
use App\Services\TimelineMatrixService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AcademicTimelineExportController extends Controller
{
    public function __construct(
        private TimelineMatrixService $timelineService
    )
    {
    }

    public function cohortPdf(CourseCohort $cohort)
    {
        $matrix = $this->timelineService->buildForCohort($cohort);

        $pdf = Pdf::loadView(
            'exports.timeline.cohort_pdf',
            compact('cohort', 'matrix')
        )->setPaper('a3', 'landscape');

        return $pdf->download('Cohort_Timeline.pdf');
    }

    public function globalPdf()
    {
        $matrix = $this->timelineService->buildGlobal();

        $pdf = Pdf::loadView(
            'exports.timeline.global_pdf',
            compact('matrix')
        )->setPaper('a3', 'landscape');

        return $pdf->download('Academic_Timeline.pdf');
    }

    public function cohortExcel(CourseCohort $cohort)
    {
        $matrix = $this->timelineService->buildForCohort($cohort);

        return Excel::download(
            new TimelineMatrixExport($matrix),
            'Cohort_Timeline.xlsx'
        );
    }

    public function globalExcel()
    {
        $matrix = $this->timelineService->buildGlobal();

        return Excel::download(
            new TimelineMatrixExport($matrix),
            'Academic_Timeline.xlsx'
        );
    }
}


