<?php

namespace App\Services;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\StudentCycleRegistration;

class NominalRollService
{
    public function getNominalRoll(Course $course, string $cohort)
    {
        // 1. Get enrollments for this course + cohort
        $enrollments = Enrollment::with([
            'student.profile',
            'student.user',
        ])
            ->where('course_id', $course->id)
            ->where('cohort', $cohort)
            ->get();

        if ($enrollments->isEmpty()) {
            return collect();
        }

        // 2. Only confirmed registrations
        $confirmedEnrollmentIds = StudentCycleRegistration::whereIn(
            'enrollment_id',
            $enrollments->pluck('id')
        )
            ->where('status', 'confirmed')
            ->pluck('enrollment_id');

        // 3. Build the roll

        return $enrollments
            ->whereIn('id', $confirmedEnrollmentIds)
            ->values()
            ->map(function ($enrollment, $index) {

                $student = $enrollment->student;
                $profile = $student->profile;

                return [
                    'sn'           => $index + 1,
                    'admission_no' => $student->student_number,
                    'name'         => $student->user->firstname,
                    'gender'       => $profile->gender ?? '-',
                    'id_number'    => $profile->id_number ?? '-',
                    'phone'        => $student->user->phone ?? '-',
                    'email'        => $student->user->email ?? '-',
//                    'stage'        => $enrollment->stage
//                        ? $enrollment->stage->code . ' – ' . $enrollment->stage->name
//                        : '-',
                    'stage' => $enrollment->stage?->label() ?? '-',

                ];
            });

    }
}
