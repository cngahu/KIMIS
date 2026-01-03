<?php

namespace App\Services;

use App\Models\AcademicDepartment;
use App\Models\Course;
use App\Models\Training;
use App\Models\User;

class HodShortCourseService
{
    public function getHodShortCourses(User $hod)
    {
        return Course::withCount(['trainings'])
            ->where('course_mode', 'Short Term')
            ->whereIn(
                'academic_department_id',
                AcademicDepartment::where('hod_user_id', $hod->id)->pluck('id')
            )
            ->with(['academicDepartment', 'college'])
            ->get();
    }

    public function getCourseSchedules(Course $course, User $hod)
    {
        // Safety: ensure HOD owns this course
        if (! $this->hodOwnsCourse($course, $hod)) {
            abort(403);
        }

        return Training::with(['college'])
            ->where('course_id', $course->id)
            ->orderByDesc('start_date')
            ->get();
    }

    protected function hodOwnsCourse(Course $course, User $hod): bool
    {
        return AcademicDepartment::where('id', $course->academic_department_id)
            ->where('hod_user_id', $hod->id)
            ->exists();
    }
}

