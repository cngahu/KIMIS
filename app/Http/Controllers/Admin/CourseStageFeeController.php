<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\CourseStageFeeService;
use App\Services\Audit\AuditLogService;

class CourseStageFeeController extends Controller
{
    //
    public function __construct(
        private CourseStageFeeService $feeService,
        private AuditLogService $auditLog
    ) {}

    public function home()
    {
        $courses = Course::where('course_mode', 'Long Term')
            ->orderBy('course_name')
            ->get();

        return view(
            'admin.course_fees.home',
            compact('courses')
        );
    }
    /**
     * Show fee structure for a course
     */
    public function index(Course $course)
    {
        $stages = $this->feeService->getCourseStageFees($course);

        return view(
            'admin.course_fees.index',
            compact('course', 'stages')
        );
    }

    /**
     * Store / change a fee
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_stage_id' => 'required|exists:course_stages,id',
            'amount'          => 'required|numeric|min:0',
            'is_billable'     => 'required|boolean',
            'effective_from'  => 'required|date',
        ]);

        $fee = $this->feeService->changeFee([
            ...$validated,
            'course_id' => $course->id,
        ]);

        $this->auditLog->logModelChange('Changed course stage fee', $fee);

        return back()->with('success', 'Fee updated successfully.');
    }
}
