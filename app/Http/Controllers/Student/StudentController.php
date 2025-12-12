<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //

    public function StudentDashboard()
    {
        $user=User::find(Auth::user()->id);
        return view('student.index',compact('user'));
    }

    public function dashboard1()
    {

        $admission = Admission::with(['application.course'])
            ->where('user_id', auth()->id())
            ->first();

        // If student has never applied / never admitted
        if (!$admission) {

            // For future: direct continuing students
            return view('student.dashboard.no_admission');
        }

        $status = $admission->status;

        if ($status === 'offer_sent') {
            return view('student.dashboard.pre_admission', compact('admission'));
        }

        if (in_array($status, [
            'offer_accepted',
            'form_submitted',
            'documents_uploaded',
            'fee_paid',
            'docs_verified',
            'awaiting_sponsor_verification',
            'awaiting_fee_decision'
        ])) {
            return view('student.dashboard.in_admission', compact('admission'));
        }

        if (in_array($status, [
            'admission_number_assigned',
            'admitted'
        ])) {
            return view('student.dashboard.full_student', compact('admission'));
        }
    }
    public function dashboard()
    {
        $admission = Admission::with(['application.course'])
            ->where('user_id', auth()->id())
            ->first();

        // Always return the partial with $admission (even if null)
        if (!$admission) {
            return view('student.dashboard.no_admission', compact('admission'));
        }

        $status = $admission->status;

        if ($status === 'offer_sent') {
            return view('student.dashboard.pre_admission', compact('admission'));
        }

        if (in_array($status, [
            'offer_accepted',
            'form_submitted',
            'documents_uploaded',
            'fee_paid',
            'docs_verified',
            'awaiting_sponsor_verification',
            'awaiting_fee_decision'
        ])) {
            return view('student.dashboard.in_admission', compact('admission'));
        }

        if (in_array($status, [
            'admission_number_assigned',
            'admitted'
        ])) {
            return view('student.dashboard.full_student', compact('admission'));
        }
    }

    public function index()
    {
        $admission = Admission::where('user_id', auth()->id())->first();

        if (!$admission) {
            return view('student.dashboard.full_student', compact('admission'));
        }

        return match ($admission->status) {
            'offer_sent' => view('student.dashboard.pre_admission', compact('admission')),
            'offer_accepted',
            'form_submitted',
            'documents_uploaded',
            'fee_paid',
            'docs_verified' =>
            view('student.dashboard.in_admission', compact('admission')),
            default =>
            view('student.dashboard.full_student', compact('admission')),
        };
    }


}
