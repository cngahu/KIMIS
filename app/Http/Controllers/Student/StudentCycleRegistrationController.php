<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Services\CycleRegistrationService;

class StudentCycleRegistrationController extends Controller
{
    protected CycleRegistrationService $service;

    public function __construct(CycleRegistrationService $service)
    {
        $this->service = $service;
    }

    /**
     * Register student for current cycle
     */
    public function register0(Request $request)
    {
        $student = Student::with('enrollments')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $enrollment = $student->enrollments()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'No active enrollment found.');
        }

        // Resolve current cycle
        $month = now()->month;
        $cycleTerm = match (true) {
            $month <= 4 => 'Jan',
            $month <= 8 => 'May',
            default     => 'Sep',
        };
        $cycleYear = now()->year;

        try {
            $this->service->registerForCycle(
                $student,
                $enrollment,
                $cycleYear,
                $cycleTerm
            );

            // 🔥 REDIRECT TO PAYMENT
            return redirect()->route(
                'student.payments.iframe',
                $registration->invoice_id
            );

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function register(Request $request)
    {
        $student = Student::with('enrollments')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $enrollment = $student->enrollments()
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'No active enrollment found.');
        }

        // Resolve cycle
        $month = now()->month;
        $cycleTerm = match (true) {
            $month <= 4 => 'Jan',
            $month <= 8 => 'May',
            default     => 'Sep',
        };
        $cycleYear = now()->year;

        try {
            $registration = $this->service->registerForCycle(
                $student,
                $enrollment,
                $cycleYear,
                $cycleTerm
            );

            // 🔥 REDIRECT TO PAYMENT
            return redirect()->route(
                'student.payments.iframe',
                $registration->invoice_id
            );

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
