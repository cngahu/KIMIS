<?php

namespace App\Services;

use App\Models\CourseCohort;
use Carbon\Carbon;

class TimelineMatrixService
{
    protected function generateCycles(int $startYear, int $endYear): array
    {
        $cycles = [];

        for ($year = $startYear; $year <= $endYear; $year++) {
            foreach ([1, 5, 9] as $month) {
                $cycles[] = sprintf('%04d-%02d', $year, $month);
            }
        }

        return $cycles;
    }

    protected function cycleKeyFromDate(Carbon $date): string
    {
        if ($date->month <= 4) {
            $month = 1;
        } elseif ($date->month <= 8) {
            $month = 5;
        } else {
            $month = 9;
        }

        return sprintf('%04d-%02d', $date->year, $month);
    }

    public function buildForCohort(CourseCohort $cohort): array
    {
        $timelines = $cohort->timelines()->with('stage')->get();

        if ($timelines->isEmpty()) {
            return [
                'has_timeline' => false,
                'columns' => [],
                'rows' => [],
            ];
        }

        $startYear = $timelines->min(fn ($t) => $t->start_date->year);
        $endYear   = $timelines->max(fn ($t) => $t->end_date->year);

        $columns = $this->generateCycles($startYear, $endYear);

        $cells = [];

        foreach ($timelines as $timeline) {
            $key = $this->cycleKeyFromDate($timeline->start_date);

            $cells[$key] = [
                'code' => $timeline->stage->code,
                'type' => $timeline->stage->stage_type,
            ];
        }

        return [
            'has_timeline' => true,
            'columns' => $columns,
            'rows' => [
                [
                    'label' => $cohort->course->course_name .
                        ' (' . Carbon::create(
                            $cohort->intake_year,
                            $cohort->intake_month
                        )->format('M Y') . ')',
                    'cells' => $cells,
                ]
            ],
        ];
    }
    public function buildGlobal(): array
    {
        $cohorts = CourseCohort::with([
            'course.college',
            'timelines.stage'
        ])->get();

        $years = $cohorts->flatMap(fn ($c) =>
        $c->timelines->flatMap(fn ($t) => [
            $t->start_date->year,
            $t->end_date->year
        ])
        );

        if ($years->isEmpty()) {
            return [
                'columns' => [],
                'groups' => [],
            ];
        }

        $columns = $this->generateCycles($years->min(), $years->max());

        $groups = $cohorts
            ->groupBy(fn ($c) => $c->course->college->name)
            ->map(function ($items) {

                return $items->map(function ($cohort) {

                    if ($cohort->timelines->isEmpty()) {
                        return [
                            'label' => $cohort->course->course_name .
                                ' (' . $cohort->intake_year . '-' . $cohort->intake_month . ')',
                            'cells' => [],
                            'has_timeline' => false,
                        ];
                    }

                    $cells = [];

                    foreach ($cohort->timelines as $timeline) {
                        $key = $this->cycleKeyFromDate($timeline->start_date);

                        $cells[$key] = [
                            'code' => $timeline->stage->code,
                            'type' => $timeline->stage->stage_type,
                        ];
                    }

                    return [
                        'label' => $cohort->course->course_name .
                            ' (' . $cohort->intake_year . '-' . $cohort->intake_month . ')',
                        'cells' => $cells,
                        'has_timeline' => true,
                    ];
                });
            });

        return [
            'columns' => $columns,
            'groups' => $groups,
        ];
    }


}
