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
        // Validate base + type-specific fields
        $request->validate([
            'type' => 'required|in:text,upload',
        ]);

        $type = $request->input('type');

        if ($type === 'text') {
            $data = $request->validate([
                'course_requirement' => 'required|string|max:5000',
            ]);
        } else { // upload
            $data = $request->validate([
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB
            ]);
        }

        $requirement = new Requirement();
        $requirement->course_id = $course->id;
        $requirement->type      = $type;
        $requirement->user_id   = auth()->id();

        if ($type === 'text') {
            $requirement->course_requirement = $data['course_requirement'];
            $requirement->file_path = null;
        } else {
            // Store file in "public/requirements"
            $path = $request->file('file')->store('requirements', 'public');
            $requirement->file_path = $path;
            $requirement->course_requirement = null;
        }

        $requirement->save();

        return redirect()
            ->route('all.courses')
            ->with('success', 'Course requirement saved successfully.');
    }

    public function destroy(Course $course, Requirement $requirement)
    {
        // Ensure the requirement belongs to this course
        if ($requirement->course_id !== $course->id) {
            abort(404);
        }

        // Delete file if it's an upload requirement
        if ($requirement->type === 'upload' && $requirement->file_path) {
            Storage::disk('public')->delete($requirement->file_path);
        }

        $requirement->delete();

        return back()->with('success', 'Requirement deleted successfully.');
    }
}
