<?php

namespace App\Services;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\StudentCycleRegistration;

class HodDashboardService
{
    public function getDashboardData(User $hod): array
    {
        // Departments this HOD belongs to
        $departments = $hod->departments()->with('courses')->get();

        $rows = [];

        foreach ($departments as $department) {
            foreach ($department->courses as $course) {

                // Get cohorts via enrollments
                $cohorts = Enrollment::where('course_id', $course->id)
                    ->select('cohort')
                    ->distinct()
                    ->get();

                foreach ($cohorts as $cohortRow) {

                    $enrollments = Enrollment::where([
                        'course_id' => $course->id,
                        'cohort'    => $cohortRow->cohort,
                    ]);

                    $enrollmentIds = $enrollments->pluck('id');

                    $registered = StudentCycleRegistration::whereIn(
                        'enrollment_id',
                        $enrollmentIds
                    )->where('status', 'confirmed')->count();

                    $rows[] = [
                        'department' => $department->name,
                        'course_id'  => $course->id,
                        'course'     => $course->course_name,
                        'cohort'     => $cohortRow->cohort,
                        'expected'   => $enrollments->count(),
                        'registered' => $registered,
                        'pending'    => max($enrollments->count() - $registered, 0),
                    ];
                }
            }
        }

        return $rows;
    }



}
