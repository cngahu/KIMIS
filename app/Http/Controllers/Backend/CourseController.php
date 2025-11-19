<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $search = $request->search;

        $courses = Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where('course_name', 'like', "%$search%")
                    ->orWhere('course_code', 'like', "%$search%")
                    ->orWhere('course_category', 'like', "%$search%");
            })
            ->orderBy('course_name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.courses.index', compact('courses', 'search'));
    }
    public function create()
    {
        $categories = ['Diploma', 'Craft', 'Higher Diploma', 'Proficiency'];
        $modes      = ['Long Term', 'Short Term'];

        return view('admin.courses.create', compact('categories', 'modes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_name'     => 'required|string|max:255',
            'course_category' => 'required|in:Diploma,Craft,Higher Diploma,Proficiency',
            'course_code'     => 'required|string|max:255|unique:courses,course_code',
            'course_mode'     => 'required|in:Long Term,Short Term',
            'course_duration' => 'required|integer|min:1',
            'cost'            => 'nullable|numeric|min:0',
            'target_group'    => 'nullable|string',
            'requirement'     => 'required|boolean',
        ]);

        $data['user_id'] = auth()->id();

        $course = Course::create($data);

        // If requirement is "Yes" (1), go to requirement capture page
        if ($course->requirement) {
            return redirect()
                ->route('courses.requirements.create', $course->id)
                ->with('success', 'Course created. Please add the course requirements.');
        }

        // If requirement is "No" (0), go back to index as usual
        return redirect()->route('all.courses')
            ->with('success', 'Course created successfully.');
    }


    public function show(Course $course)
    {
        $course->load('requirements'); // eager load related requirements

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = ['Diploma', 'Craft', 'Higher Diploma', 'Proficiency'];
        $modes      = ['Long Term', 'Short Term'];

        return view('admin.courses.edit', compact('course', 'categories', 'modes'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'course_name'     => 'required|string|max:255',
            'course_category' => 'required|in:Diploma,Craft,Higher Diploma,Proficiency',
            'course_code'     => 'required|string|max:255|unique:courses,course_code,' . $course->id,
            'course_mode'     => 'required|in:Long Term,Short Term',
            'course_duration' => 'required|integer|min:1',
            'user_id'         => 'nullable|string',
            'cost'            => 'nullable|numeric|min:0',
            'target_group'    => 'nullable|string',
            'requirement'     => 'required|boolean',
        ]);

        $course->update($data);

        return redirect()->route('all.courses')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('all.courses')
            ->with('success', 'Course deleted successfully.');
    }
}
