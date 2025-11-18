<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search        = $request->input('search');
        $category      = $request->input('category');
        $mode          = $request->input('mode');
        $sortField     = $request->input('sortField', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc');

        // Allowed sorting fields
        $allowedSortFields = [
            'course_name',
            'course_category',
            'course_code',
            'course_mode',
            'course_duration',
            'created_at',
        ];

        if (! in_array($sortField, $allowedSortFields, true)) {
            $sortField = 'created_at';
        }

        // Allowed directions
        if (! in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = Course::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%")
                        ->orWhere('course_category', 'like', "%{$search}%")
                        ->orWhere('course_mode', 'like', "%{$search}%");
                });
            })
            ->when($category, function ($q) use ($category) {
                $q->where('course_category', $category);
            })
            ->when($mode, function ($q) use ($mode) {
                $q->where('course_mode', $mode);
            })
            ->orderBy($sortField, $sortDirection);

        $courses = $query->paginate(10)->appends($request->query());

        $categories = ['Diploma', 'Craft', 'Higher Diploma', 'Proficiency'];
        $modes      = ['Long Term', 'Short Term'];

        return view('admin.courses.index', compact(
            'courses',
            'search',
            'category',
            'mode',
            'sortField',
            'sortDirection',
            'categories',
            'modes'
        ));
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
        ]);


        $data['user_id'] = auth()->id();

        Course::create($data);

        return redirect()->route('all.courses')
            ->with('success', 'Course created successfully.');
    }


    public function show(Course $course)
    {
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
