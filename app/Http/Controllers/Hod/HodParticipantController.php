<?php

namespace App\Http\Controllers\Hod;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCohort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class HodParticipantController extends Controller
{
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

    public function index($courseId, $cohortId)
    {
        $participants = $this->baseQuery($courseId, $cohortId)->get();

        return view(
            'hod.participants.index',
            compact('participants')
        );
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
