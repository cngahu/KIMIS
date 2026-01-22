<?php

namespace App\Services\Student;

use App\Models\CohortStageTimeline;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentCycleRegistration;

class StudentDashboardService
{
    public function build(Student $student): array
    {
        $enrollment = $student->enrollments()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$enrollment) {
            throw new \Exception('No active enrollment found.');
        }

        // Determine current cycle
        $currentCycle = $this->currentCycle();

        // Check existing cycle registration
        $cycleRegistration = StudentCycleRegistration::where(
            'student_id', $student->id
        )
            ->where('cycle_year', $currentCycle['year'])
            ->where('cycle_term', $currentCycle['term'])
            ->first();


        return [
            'student'           => $student,
            'enrollment'        => $enrollment,
            'current_stage'     => $enrollment->stage,
            'timeline'          => $this->timelineForEnrollment($enrollment),
            'cycle'             => $currentCycle,
            'cycle_registration'=> $cycleRegistration,
            'financials'        => $this->financialSnapshot($student),
        ];
    }

    protected function currentCycle(): array
    {
        $month = now()->month;

        return match (true) {
            $month <= 4  => ['term' => 'Jan', 'year' => now()->year],
            $month <= 8  => ['term' => 'May', 'year' => now()->year],
            default      => ['term' => 'Sep', 'year' => now()->year],
        };
    }

    protected function timelineForEnrollment(Enrollment $enrollment)
    {
        return CohortStageTimeline::where(
            'course_cohort_id', $enrollment->course_cohort_id
        )->orderBy('start_date')->get();
    }

    protected function financialSnapshot(Student $student): array
    {
        return [
//            'opening_balance' => $student->openingBalance?->amount ?? 0,
            'outstanding'     => $student->outstandingBalance(), // computed
        ];
    }
}

