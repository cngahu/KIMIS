<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Masterdata;
use App\Models\Student;
use App\Models\User;
use App\Services\Student\StudentDashboardService;
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



    public function dashboard()
    {

        $student = Student::where('user_id', auth()->id())->first();

        if (!$student) {
            return view('student.dashboard.no_admission');
        }

        $data = app(StudentDashboardService::class)->build($student);

        return view('student.dashboard.full_student', $data);
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
