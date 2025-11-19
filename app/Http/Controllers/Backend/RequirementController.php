<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Requirement;

class RequirementController extends Controller
{
    public function create(Course $course)
    {
        // You can load existing requirements if needed
        $requirements = $course->requirements()->latest()->get();

        return view('admin.requirements.create', compact('course', 'requirements'));
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'course_requirement' => 'required|string|max:5000',
        ]);

        Requirement::create([
            'course_id'          => $course->id,
            'course_requirement' => $data['course_requirement'],
            'user_id'            => auth()->id(),
        ]);

        // After saving requirement, go back to courses index
        return redirect()
            ->route('all.courses')
            ->with('success', 'Course requirement saved successfully.');
    }
}
