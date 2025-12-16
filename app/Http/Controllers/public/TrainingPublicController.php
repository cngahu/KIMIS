<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\College;

class TrainingPublicController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $campusId = $request->input('college_id');

        $trainings = Training::with([
            'course.requirements',  // 👈 load requirements via course
            'college',
        ])
            ->where('status', 'Approved')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            ->when($campusId, function ($q) use ($campusId) {
                $q->where('college_id', $campusId);
            })
            ->orderBy('start_date', 'asc')
            ->paginate(9)
            ->appends($request->query());

        $colleges = \App\Models\College::orderBy('name')->get();

        return view('training', compact('trainings', 'colleges', 'search', 'campusId'));
    }

    private function baseQuery(Request $request, string $mode)
    {
        $search   = $request->input('search');
        $campusId = $request->input('college_id');

        $trainings = Training::with(['course.requirements', 'college'])
            ->where('status', 'Approved')
            ->whereHas('course', fn($q) => $q->where('course_mode', $mode))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($cq) use ($search) {
                    $cq->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            ->when($campusId, fn($q) => $q->where('college_id', $campusId))
            ->orderBy('start_date', 'asc')
            ->paginate(9)
            ->appends($request->query());

        $colleges = College::orderBy('name')->get();

        return [$trainings, $colleges, $search, $campusId];
    }

    public function longTerm(Request $request)
    {
        [$trainings, $colleges, $search, $campusId] = $this->baseQuery($request, 'Long Term');

        return view('public.trainings_long_term', compact('trainings', 'colleges', 'search', 'campusId'));
    }

    public function shortTerm(Request $request)
    {
        [$trainings, $colleges, $search, $campusId] = $this->baseQuery($request, 'Short Term');

        return view('public.trainings_short_term', compact('trainings', 'colleges', 'search', 'campusId'));
    }


}
