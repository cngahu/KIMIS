<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCohort;
use App\Services\Audit\AuditLogService;
use App\Services\CourseCohortService;
use Illuminate\Http\Request;

class CourseCohortController extends Controller
{
    public function __construct(
        private CourseCohortService $service,
        private AuditLogService $auditLog
    ) {}

    public function index(Request $request)
    {
        $cohorts = $this->service->list($request->all());

        return view('admin.course_cohorts.index', compact('cohorts'));
    }

    public function create()
    {
        $courses = Course::orderBy('course_name')->get();

        return view('admin.course_cohorts.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'intake_year'  => 'required|digits:4',
            'intake_month' => 'required|in:1,5,9',
        ]);

        $cohort = $this->service->create($validated);

        $this->auditLog->logModelChange('Created course cohort', $cohort);

        return redirect()
            ->route('course_cohorts.index')
            ->with('success', 'Course intake created successfully.');
    }

    public function show(CourseCohort $cohort)
    {
        $cohort->load('course.college');

        return view('admin.course_cohorts.show', compact('cohort'));
    }
}
