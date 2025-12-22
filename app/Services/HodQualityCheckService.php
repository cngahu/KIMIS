<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Masterdata;
use App\Models\StudentCycleRegistration;

class HodQualityCheckService
{
    public function getQualityData0(Course $course, string $cohort): array
    {
        /**
         * 1. Expected students (from masterdata)
         */
        $expected = Masterdata::where('course_id', $course->id)
            ->where('intake', $cohort)
            ->get()
            ->map(function ($row) {
                return [
                    'admission_no' => $row->admissionNo,
                    'name'         => $row->full_name,
                    'phone'        => $row->phone,
                    'email'        => $row->email,
                ];
            });

        /**
         * 2. Activated students (from enrollments)
         */
        $enrollments = Enrollment::with('student.user')
            ->where('course_id', $course->id)
            ->where('cohort', $cohort)
            ->get();

        $activated = $enrollments->map(function ($enrollment) {
            $student = $enrollment->student;
            return [
                'admission_no' => $student->student_number,
                'name'         => $student->user->firstname,
                'phone'        => $student->user->phone,
                'email'        => $student->user->email,
            ];
        });

        /**
         * 3. Registered students (confirmed)
         */
        $registeredIds = StudentCycleRegistration::whereIn(
            'enrollment_id',
            $enrollments->pluck('id')
        )
            ->where('status', 'confirmed')
            ->pluck('enrollment_id');

        $registered = $enrollments
            ->whereIn('id', $registeredIds)
            ->map(function ($enrollment) {
                $student = $enrollment->student;
                return [
                    'admission_no' => $student->student_number,
                    'name'         => $student->user->firstname,
                    'phone'        => $student->user->phone,
                    'email'        => $student->user->email,
                ];
            });

        return [
            'expected'   => $expected,
            'activated'  => $activated,
            'registered' => $registered,
        ];
    }
    public function getQualityMatrix(Course $course, string $cohort)
    {
        /**
         * -----------------------------------------
         * 1. MASTER LIST (BASELINE)
         * -----------------------------------------
         */
        $master = Masterdata::where('course_id', $course->id)
            ->where('intake', $cohort)
            ->get()
            ->keyBy('admissionNo');

        /**
         * -----------------------------------------
         * 2. ENROLLMENTS (ACTUAL)
         * -----------------------------------------
         */
        $enrollments = Enrollment::with([
            'student.user',
            'student.profile',
        ])
            ->where('course_id', $course->id)
            ->where('cohort', $cohort)
            ->get()
            ->keyBy(fn ($e) => $e->student->student_number);

        /**
         * -----------------------------------------
         * 3. CONFIRMED REGISTRATIONS
         * -----------------------------------------
         */
        $registeredEnrollmentIds = StudentCycleRegistration::whereIn(
            'enrollment_id',
            $enrollments->pluck('id')
        )
            ->where('status', 'confirmed')
            ->pluck('enrollment_id')
            ->toArray();

        /**
         * -----------------------------------------
         * 4. MERGE LOGIC
         * -----------------------------------------
         */
        $rows = collect();

        // A. Start with MASTER students
        foreach ($master as $admissionNo => $m) {

            $enrollment = $enrollments->get($admissionNo);

            $rows->push([
                'admission_no' => $admissionNo,
                'name'         => $m->full_name,
                'source'       => 'Masterdata',
                'activated'    => (bool) $enrollment,
                'registered'   => $enrollment
                    ? in_array($enrollment->id, $registeredEnrollmentIds)
                    : false,
                'notes'        => $enrollment
                    ? null
                    : 'Not activated',
            ]);
        }

        // B. Add ENROLLMENTS NOT IN MASTER
        foreach ($enrollments as $admissionNo => $e) {

            if ($master->has($admissionNo)) {
                continue;
            }

            $rows->push([
                'admission_no' => $admissionNo,
                'name'         => $e->student->user->firstname,
                'source'       => 'New Admission',
                'activated'    => true,
                'registered'   => in_array($e->id, $registeredEnrollmentIds),
                'notes'        => 'Not in master list',
            ]);
        }

        return $rows->sortBy('admission_no')->values();
    }
}
