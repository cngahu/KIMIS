<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 50, 100], true) ? $perPage : 10;

        $courses = Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%")
                        ->orWhere('course_category', 'like', "%{$search}%");
                });
            })
            ->orderBy('course_name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.courses.index', compact('courses', 'search'));
    }

    public function create()
    {
        abort_unless(auth()->user()?->hasRole('superadmin'), 403);

        $categories = ['Diploma', 'Craft', 'Higher Diploma', 'Proficiency'];
        $modes      = ['Long Term', 'Short Term'];

        return view('admin.courses.create', compact('categories', 'modes'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()?->hasRole('superadmin'), 403);

        $data = $request->validate([
            'course_name'     => 'required|string|max:255',
            'course_category' => 'required|in:Diploma,Craft,Higher Diploma,Proficiency',
            'course_code'     => 'required|string|max:255|unique:courses,course_code',
            'course_mode'     => 'required|in:Long Term,Short Term',
            'course_duration' => 'required|integer|min:1',
            'cost'            => 'nullable|numeric|min:0',
            'target_group'    => 'nullable|string|max:255',
            'requirement'     => 'required|boolean',
        ]);

        $data['user_id'] = auth()->id();

        $course = Course::create($data);

        // If requirement is "Yes" (1), go to requirement capture page
        if ((int)$course->requirement === 1) {
            return redirect()
                ->route('courses.requirements.create', $course->id)
                ->with('success', 'Course created. Please add the course requirements.');
        }

        return redirect()
            ->route('all.courses')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load('requirements');

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        abort_unless(auth()->user()?->hasRole('superadmin'), 403);

        $categories = ['Diploma', 'Craft', 'Higher Diploma', 'Proficiency'];
        $modes      = ['Long Term', 'Short Term'];

        return view('admin.courses.edit', compact('course', 'categories', 'modes'));
    }

    public function update(Request $request, Course $course)
    {
        abort_unless(auth()->user()?->hasRole('superadmin'), 403);

        $data = $request->validate([
            'course_name'     => 'required|string|max:255',
            'course_category' => 'required|in:Diploma,Craft,Higher Diploma,Proficiency',
            'course_code'     => 'required|string|max:255|unique:courses,course_code,' . $course->id,
            'course_mode'     => 'required|in:Long Term,Short Term',
            'course_duration' => 'required|integer|min:1',
            'cost'            => 'nullable|numeric|min:0',
            'target_group'    => 'nullable|string|max:255',
            'requirement'     => 'required|boolean',
        ]);

        $course->update($data);

        return redirect()
            ->route('all.courses')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        abort_unless(auth()->user()?->hasRole('superadmin'), 403);

        $course->delete();

        return redirect()
            ->route('all.courses')
            ->with('success', 'Course deleted successfully.');
    }
}
