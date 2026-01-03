<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Services\HodShortCourseParticipantService;
use Illuminate\Http\Request;

class HodShortCourseParticipantController extends Controller
{
    public function index(
        Training $training,
        HodShortCourseParticipantService $service
    ) {
        $participants = $service->getParticipants(
            $training,
            auth()->user()
        );

        return view(
            'hod.short_courses.participants.index',
            compact('training', 'participants')
        );
    }
}

