<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\StudentCycleRegistration;
use App\Models\Invoice;

class StudentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Load Student With Relationships
        |--------------------------------------------------------------------------
        */
        $student = Student::with([
            'course.stages',
            'campus',
            'enrollments'
        ])->where('user_id', $user->id)->first();

        // If student record does not exist
        if (!$student) {
            return view('student.dashboard.no_admission', [
                'user' => $user
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Latest Enrollment
        |--------------------------------------------------------------------------
        */
        $enrollment = $student->enrollments()
            ->latest()
            ->first();

        $cycleYear = $enrollment?->year ?? now()->year;
        $cycleTerm = $enrollment?->term ?? 'Term 1';

        $cycle = [
            'year' => $cycleYear,
            'term' => $cycleTerm,
        ];

        /*
        |--------------------------------------------------------------------------
        | Cycle Registration
        |--------------------------------------------------------------------------
        */
        $cycleRegistration = StudentCycleRegistration::where('student_id', $student->id)
            ->where('cycle_year', $cycleYear)
            ->where('cycle_term', $cycleTerm)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Course Timeline (Ordered Stages)
        |--------------------------------------------------------------------------
        */
        $timeline = collect();

        if ($student->course) {
            $timeline = $student->course->stages()
                ->orderBy('course_stage_mappings.sequence_number', 'asc')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Determine Current Stage
        |--------------------------------------------------------------------------
        */
        $currentStage = null;

        if ($enrollment && $enrollment->current_stage_id) {
            $currentStage = $timeline->firstWhere(
                'id',
                $enrollment->current_stage_id
            );
        }

        // Fallback to first stage if not matched
        if (!$currentStage && $timeline->isNotEmpty()) {
            $currentStage = $timeline->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Pending Tuition Invoice
        |--------------------------------------------------------------------------
        */
        $pendingInvoice = null;

        if ($cycleRegistration) {
            $pendingInvoice = Invoice::where([
                'user_id'       => $user->id,
                'category'      => 'tuition_fee',
                'status'        => 'pending',
                'billable_type' => StudentCycleRegistration::class,
                'billable_id'   => $cycleRegistration->id,
            ])->latest()->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Return Dashboard View
        |--------------------------------------------------------------------------
        */
        return view('student.student_dashboard', [
            'user'               => $user,
            'student'            => $student,
            'enrollment'         => $enrollment,
            'cycle'              => $cycle,
            'cycle_registration' => $cycleRegistration,
            'timeline'           => $timeline,
            'current_stage'      => $currentStage,
            'pendingInvoice'     => $pendingInvoice,
        ]);
    }
}