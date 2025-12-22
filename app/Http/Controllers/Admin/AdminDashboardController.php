<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request, AdminDashboardService $service)
    {
        $campusId = $request->get('campus_id');

        return view('admin.dashboard.master', [
            'global' => $service->getGlobalStats(),
            'campusStats' => $service->getCampusStats($campusId),
            'courseBreakdown' => $campusId
                ? $service->getCourseBreakdown($campusId)
                : collect(),
            'campuses' => \App\Models\College::all(),
            'selectedCampus' => $campusId,
        ]);
    }
}

