<?php

namespace App\Services\Admin;
use App\Models\College;
use App\Models\Course;
use App\Models\Masterdata;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\StudentCycleRegistration;

class AdminDashboardService
{
    public function getGlobalStats(): array
    {
        return [
            'campuses' => College::count(),
            'courses'  => Course::count(),

            'expected_students' => Masterdata::count(),

            'activated_students' => Student::count(),

            'registered_students' => StudentCycleRegistration::where('status', 'confirmed')->count(),
        ];
    }

    public function getCampusStats(?int $campusId = null): array
    {
        if (!$campusId) {
            return [];
        }

        return [
            'campus' => College::findOrFail($campusId),

            'courses' => Course::where('college_id', $campusId)->count(),

            'expected_students' => Masterdata::where('campus_id', $campusId)->count(),

            'activated_students' => Student::where('campus_id', $campusId)->count(),

            'registered_students' => StudentCycleRegistration::whereHas(
                'enrollment',
                fn ($q) => $q->where('campus_id', $campusId)
            )->where('status', 'confirmed')->count(),
        ];
    }

    public function getCourseBreakdown(int $campusId)
    {
        return Course::where('college_id', $campusId)
            ->get()
            ->map(function ($course) {

                $enrollments = Enrollment::where('course_id', $course->id);

                return [
                    'course_name' => $course->course_name,

                    'expected_students' =>
                        $course->masterdata()->count(),

                    'activated_students' =>
                        $enrollments->count(),

                    'registered_students' =>
                        StudentCycleRegistration::whereIn(
                            'enrollment_id',
                            $enrollments->pluck('id')
                        )->where('status', 'confirmed')->count(),
                ];
            });
    }

}
