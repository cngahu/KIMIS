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
        // Validate: type is optional (or you can keep it required), and text is required
        $data = $request->validate([
            'type'               => 'nullable|in:text,upload',
            'course_requirement' => 'required|string|max:5000',
        ]);

        $requirement = new Requirement();
        $requirement->course_id          = $course->id;
        $requirement->type               = $data['type'] ?? 'text'; // we still store the type, but treat all as text
        $requirement->course_requirement = $data['course_requirement'];
        $requirement->file_path          = null;                    // no upload anymore
        $requirement->user_id            = auth()->id();

        $requirement->save();

        return redirect()
            ->route('all.courses')
            ->with('success', 'Course requirement saved successfully.');
    }

    public function destroy(Course $course, Requirement $requirement)
    {
        // Make sure the requirement belongs to this course
        if ($requirement->course_id !== $course->id) {
            abort(404);
        }

        // For legacy data: delete file if it exists and was previously uploaded
        if ($requirement->type === 'upload' && $requirement->file_path) {
            Storage::disk('public')->delete($requirement->file_path);
        }

        $requirement->delete();

        return back()->with('success', 'Requirement deleted successfully.');
    }
}
