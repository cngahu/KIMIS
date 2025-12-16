<?php

namespace App\Services;

use App\Models\CohortStageTimeline;
use App\Models\CourseCohort;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CohortStageTimelineService
{
    public function listForCohort(CourseCohort $cohort)
    {
        return CohortStageTimeline::with('stage')
            ->where('course_cohort_id', $cohort->id)
            ->orderBy('sequence_number')
            ->get();
    }

    public function create(array $data): CohortStageTimeline
    {
        return DB::transaction(function () use ($data) {

            // Determine next sequence number automatically
            $nextSequence = CohortStageTimeline::where('course_cohort_id', $data['course_cohort_id'])
                    ->max('sequence_number') + 1;

            return CohortStageTimeline::create([
                'course_cohort_id' => $data['course_cohort_id'],
                'course_stage_id'  => $data['course_stage_id'],
                'sequence_number'  => $nextSequence,
                'start_date'       => $data['start_date'],
                'end_date'         => $data['end_date'],
            ]);
        });
    }

    /**
     * Builds an overview status (past / current / future)
     */
    public function overview(CourseCohort $cohort): array
    {
        $today = now()->toDateString();

        return $this->listForCohort($cohort)->map(function ($timeline) use ($today) {

            if ($today < $timeline->start_date) {
                $status = 'upcoming';
            } elseif ($today > $timeline->end_date) {
                $status = 'completed';
            } else {
                $status = 'current';
            }

            return [
                'timeline' => $timeline,
                'status'   => $status,
            ];
        })->toArray();
    }

    protected function resolveDates(int $year, int $month): array
    {
        return match ($month) {
            1 => [
                'start' => Carbon::create($year, 1, 1),
                'end'   => Carbon::create($year, 4, 30),
            ],
            5 => [
                'start' => Carbon::create($year, 5, 1),
                'end'   => Carbon::create($year, 8, 31),
            ],
            9 => [
                'start' => Carbon::create($year, 9, 1),
                'end'   => Carbon::create($year, 12, 31),
            ],
            default => throw new \InvalidArgumentException('Invalid cycle month'),
        };
    }

    public function createFromCycle(array $data): CohortStageTimeline
    {
        return DB::transaction(function () use ($data) {

            $dates = $this->resolveDates(
                $data['cycle_year'],
                $data['cycle_month']
            );

            $nextSequence = CohortStageTimeline::where(
                    'course_cohort_id',
                    $data['course_cohort_id']
                )->max('sequence_number') + 1;

            return CohortStageTimeline::create([
                'course_cohort_id' => $data['course_cohort_id'],
                'course_stage_id'  => $data['course_stage_id'],
                'sequence_number'  => $nextSequence,
                'start_date'       => $dates['start'],
                'end_date'         => $dates['end'],
            ]);
        });
    }
}

