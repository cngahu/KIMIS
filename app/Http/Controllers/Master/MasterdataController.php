<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Masterdata;
use Illuminate\Http\Request;
use App\Models\College;
use App\Models\AcademicDepartment;
use App\Models\CourseStage;
use Illuminate\Support\Facades\Log;

class MasterdataController extends Controller
{
    public function index()
    {
        $masterdata = Masterdata::latest()->get();

        $totalStudents   = Masterdata::count();
        $activeStudents  = Masterdata::where('is_activated', 1)->count();
        $inactiveStudents = Masterdata::where('is_activated', 0)->count();

        return view('admin.masterdata.main_index', compact(
            'masterdata',
            'totalStudents',
            'activeStudents',
            'inactiveStudents'
        ));
    }


    public function create()
    {
        $colleges = College::orderBy('name')->get();
        $courseStages = CourseStage::orderBy('code')->get();

        return view('admin.masterdata.create', compact(
            'colleges',
            'courseStages'
        ));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'admissionNo' => 'required|unique:masterdata,admissionNo',
            'full_name'   => 'required|string|max:255',
            'gender'      => 'required|in:M,F',

            'campus_id'     => 'required|exists:colleges,id',
            'department_id' => 'required|exists:academic_departments,id',
            'course_id'     => 'required|exists:courses,id',

            'current' => 'required|exists:course_stages,code',

            'resolved_intake_month' => 'required|in:JAN,MAY,SEP',
            'resolved_intake_year'  => 'required|integer|min:2021|max:2027',
            'cohort_id_provisional' => 'required|exists:course_cohorts,id',

            'phone'   => 'nullable|string',
            'email'   => 'nullable|email',
            'balance' => 'nullable|numeric',
            'idno' => 'nullable|string|max:13',

        ]);


        // Fetch related records

        $college    = College::findOrFail($validated['campus_id']);
        $department = AcademicDepartment::findOrFail($validated['department_id']);
        $course     = Course::findOrFail($validated['course_id']);
        $intake = $validated['resolved_intake_month'] . ' ' . $validated['resolved_intake_year'];

        $master =  Masterdata::create([
            'admissionNo' => $validated['admissionNo'],
            'full_name'   => $validated['full_name'],
            'gender'      => $validated['gender'],

            // Campus
            'campus_id' => $college->id,
            'campus'    => $college->name,

            // Department
            'department_id' => $department->id,
            'department'    => $department->name,

            // Course
            'course_id'   => $course->id,
            'course_name' => $course->course_name,
            'course_code' => $course->course_code,

            // Stage
            'current' => $validated['current'],

            // Intake
            'resolved_intake_month' => $validated['resolved_intake_month'],
            'resolved_intake_year'  => $validated['resolved_intake_year'],
            'intake'                => $intake,
            'cohort_id_provisional' => $validated['cohort_id_provisional'],
            'idno' => $validated['idno'] ?? null,

            'phone'   => $validated['phone'] ?? null,
            'email'   => $validated['email'] ?? null,
            'balance' => $validated['balance'] ?? 0,
        ]);

//        app(\App\Services\MasterdataLedgerService::class)
//            ->initialize($master);
//


// ...

        Log::info('Masterdata created', [
            'masterdata_id' => $master->id,
            'admissionNo'   => $master->admissionNo,
        ]);

        try {
            app(\App\Services\MasterdataLedgerService::class)
                ->initialize($master);

            Log::info('MasterdataLedgerService.initialize called successfully', [
                'masterdata_id' => $master->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('MasterdataLedgerService.initialize FAILED', [
                'masterdata_id' => $master->id,
                'message'       => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
            ]);
        }


        return redirect()
            ->route('masterdata.index')
            ->with('success', 'Student added successfully');
    }



}
