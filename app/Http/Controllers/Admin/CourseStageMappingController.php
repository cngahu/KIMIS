<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\CourseStageMappingService;
use App\Services\Audit\AuditLogService;
class CourseStageMappingController extends Controller
{
    //
    public function __construct(
        private CourseStageMappingService $mappingService,
        private AuditLogService $auditLog
    ) {}

    /**
     * Home – list courses
     */
    public function home()
    {
        $courses = Course::withCount('stageMappings')
            ->orderBy('course_name')
            ->get();

        return view(
            'admin.course_structure.home',
            compact('courses')
        );
    }


    /**
     * Show mapper for a course
     */
    public function index(Course $course)
    {
        $structure = $this->mappingService->getCourseStructure($course);
        $stages    = $this->mappingService->allStages();

        return view(
            'admin.course_structure.index',
            compact('course', 'structure', 'stages')
        );
    }

    /**
     * Save structure
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'stage_ids' => 'required|array|min:1',
            'stage_ids.*' => 'exists:course_stages,id',
        ]);

        $this->mappingService->saveStructure(
            $course,
            $validated['stage_ids']
        );

        $this->auditLog->log(
            'Updated course structure',
            $course,
            ['new' => $validated['stage_ids']]
        );

        return back()->with('success', 'Course structure saved successfully.');
    }
}
