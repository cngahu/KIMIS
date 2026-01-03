<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\HodShortCourseService;
use Illuminate\Http\Request;

class HodShortCourseController extends Controller
{
    public function index(HodShortCourseService $service)
    {
        $hod = auth()->user();

        $courses = $service->getHodShortCourses($hod);

        return view('hod.short_courses.index', compact('courses'));
    }

    public function schedules(
        Course $course,
        HodShortCourseService $service
    ) {
        $hod = auth()->user();

        $trainings = $service->getCourseSchedules($course, $hod);

        return view(
            'hod.short_courses.schedules',
            compact('course', 'trainings')
        );
    }
}
