<?php

namespace App\Http\Controllers\HOD;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\HodQualityCheckService;
use App\Services\NominalRollService;
use Illuminate\Http\Request;

use App\Services\HodDashboardService;


class HodDashboardController extends Controller
{
    public function index(HodDashboardService $service)
    {
        $dashboardData = $service->getDashboardData(auth()->user());

        return view('hod.dashboard.index', compact('dashboardData'));
    }


    public function nominalRoll(
        Course $course,
        string $cohort,
        NominalRollService $service
    ) {
        // Authorization: ensure HOD owns this course
        $hod = auth()->user();

        $authorized = $hod->departments()
            ->whereHas('courses', function ($q) use ($course) {
                $q->where('courses.id', $course->id);
            })->exists();

        abort_unless($authorized, 403);

        $roll = $service->getNominalRoll($course, $cohort);

        return view('hod.nominal_roll.index', [
            'course' => $course,
            'cohort' => $cohort,
            'roll'   => $roll,
        ]);
    }

    public function qualityCheck0(
        Course $course,
        string $cohort,
        HodQualityCheckService $service
    ) {
        // Authorization: HOD must own this course
        $hod = auth()->user();

        $authorized = $hod->departments()
            ->whereHas('courses', fn ($q) => $q->where('courses.id', $course->id))
            ->exists();

        abort_unless($authorized, 403);

        $data = $service->getQualityData($course, $cohort);

        return view('hod.quality_check.index', [
            'course' => $course,
            'cohort' => $cohort,
            'data'   => $data,
        ]);
    }

    public function qualityCheck(
        Course $course,
        string $cohort,
        HodQualityCheckService $service
    ) {
        $hod = auth()->user();

        $authorized = $hod->departments()
            ->whereHas('courses', fn ($q) => $q->where('courses.id', $course->id))
            ->exists();

        abort_unless($authorized, 403);

        return view('hod.quality_check.index_new', [
            'course' => $course,
            'cohort' => $cohort,
            'rows'   => $service->getQualityMatrix($course, $cohort),
        ]);
    }

}
