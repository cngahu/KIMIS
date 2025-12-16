<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseStage;
use App\Services\Audit\AuditLogService;
use Illuminate\Http\Request;

class CourseStageController extends Controller
{
    public function __construct(
        private AuditLogService $auditLog
    ) {}

    public function index()
    {
        $stages = CourseStage::orderBy('stage_type')
            ->orderBy('code')
            ->paginate(15);

        return view('admin.course_stages.index', compact('stages'));
    }

    public function create()
    {
        return view('admin.course_stages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => 'required|string|max:20|unique:course_stages,code',
            'name'        => 'required|string|max:255',
            'stage_type'  => 'required|in:academic,vacation,attachment,internship',
            'is_billable' => 'nullable|boolean',
        ]);

        $stage = CourseStage::create([
            'code'        => strtoupper($validated['code']),
            'name'        => $validated['name'],
            'stage_type'  => $validated['stage_type'],
            'is_billable' => $request->boolean('is_billable'),
        ]);

        $this->auditLog->logModelChange('Created course stage', $stage);

        return redirect()
            ->route('course_stages.index')
            ->with('success', 'Course stage created successfully.');
    }

    public function show(CourseStage $stage)
    {
        return view('admin.course_stages.show', compact('stage'));
    }
}

