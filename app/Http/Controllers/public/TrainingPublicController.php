<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;

class TrainingPublicController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $campusId   = $request->input('college_id');

        $trainings = Training::with(['course', 'college'])
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

        // You probably already have a College model
        $colleges = \App\Models\College::orderBy('name')->get();

        return view('training', compact('trainings', 'colleges', 'search', 'campusId'));
    }

}
