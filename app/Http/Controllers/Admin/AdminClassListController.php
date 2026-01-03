<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\AcademicDepartment;
use App\Models\Course;
use App\Models\CourseCohort;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminClassListController extends Controller
{
    //

    public function indexMaster()
    {
        $user = Auth::user();

        $departments = AcademicDepartment::with([
            'college',
            'courses.courseCohorts'
        ])
//            ->where('hod_user_id', $user->id)
            ->get();

        // Attach student counts per cohort
        foreach ($departments as $department) {
            foreach ($department->courses as $course) {
                foreach ($course->courseCohorts as $cohort) {
                    $cohort->students_count = DB::table('masterdata')
                        ->where('cohort_id_provisional', $cohort->id)
                        ->count();
                }
            }
        }

        return view('admin.class_lists.master_index', compact('departments'));
    }

    public function index()
    {
        $campuses = College::orderBy('name')->get();

        return view('admin.class_lists.index', compact('campuses'));
    }

    public function departmentsByCampus($campusId)
    {
        return AcademicDepartment::where('college_id', $campusId)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function coursesByDepartment($departmentId)
    {
        return Course::where('academic_department_id', $departmentId)
            ->orderBy('course_name')
            ->get(['id', 'course_name', 'course_code']);
    }

    public function cohortsByCourse($courseId)
    {
        return CourseCohort::where('course_id', $courseId)
            ->orderBy('intake_year', 'desc')
            ->orderBy('intake_month', 'desc')
            ->get();
    }

    public function show($course, $cohort)
    {
        $course = Course::findOrFail($course);

        $cohort = CourseCohort::where('course_id', $course->id)
            ->findOrFail($cohort);

        // ✅ Class participants come from masterdata
        $participants = DB::table('masterdata')
            ->where('course_id', $course->id)
            ->where('cohort_id_provisional', $cohort->id)
            ->orderBy('admissionNo')
            ->get();

        return view('admin.class_lists.show', compact(
            'course',
            'cohort',
            'participants'
        ));
    }

    protected function baseQuery($courseId, $cohortId)
    {
        return DB::table('masterdata as m')
            ->join('courses as c', 'm.course_id', '=', 'c.id')
            ->join('course_cohorts as cc', 'm.cohort_id_provisional', '=', 'cc.id')
            ->where('m.course_id', $courseId)
            ->where('m.cohort_id_provisional', $cohortId)
            ->select([
                'm.full_name',
                'm.admissionNo',
                'm.phone',
                'm.email',
                'c.course_name',
                'c.course_code',
                'cc.intake_year',
                'cc.intake_month',
            ])
            ->orderBy('m.full_name');
    }
    public function print($courseId, $cohortId)
    {
        $participants = $this->baseQuery($courseId, $cohortId)->get();

        $pdf = Pdf::loadView(
            'hod.participants.print',
            compact('participants')
        )->setPaper('A4', 'landscape');

        return $pdf->download('KIHBT-Participant-List.pdf');

    }
}
