<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;  
use App\Models\Course; // assuming you have a Course model

class StudentCourseController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student; // relationship: User hasOne Student
        $courses = $student->course ? [$student->course] : []; // or if many: $student->courses

        return view('student.courses.index', compact('courses'));
    }
}