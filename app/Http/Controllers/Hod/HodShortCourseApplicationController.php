<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Services\HodShortCourseApplicationService;
use Illuminate\Http\Request;

class HodShortCourseApplicationController extends Controller
{
    public function index(
        Training $training,
        HodShortCourseApplicationService $service
    ) {
        $applications = $service->getApplicationsForTraining(
            $training,
            auth()->user()
        );

        return view(
            'hod.short_courses.applications.index',
            compact('training', 'applications')
        );
    }

    public function revenue(
        Training $training,
        HodShortCourseApplicationService $service
    ) {
        $stats = $service->getRevenueStats(
            $training,
            auth()->user()
        );

        return view(
            'hod.short_courses.applications.revenue',
            compact('training', 'stats')
        );
    }
}

