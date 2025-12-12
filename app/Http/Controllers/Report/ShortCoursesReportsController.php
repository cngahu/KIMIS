<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Training;
use App\Services\ShortCourseReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ShortCoursesReportsController extends Controller
{
    //

    public function shortApplicationsIndex(Request $request)
    {
        $trainings = \App\Models\Training::with('course')->orderBy('id', 'desc')->get();

        // Default load all (or paginated in future)
        $data = app(\App\Services\ShortCourseReportService::class)
            ->applications($request->all());

        return view('admin.reports.short.applications.index', compact('data', 'trainings'));
    }
    public function shortApplicationsPdf(Request $request)
    {
        $service = app(\App\Services\ShortCourseReportService::class);

        $apps = $service->applications($request->all());

        return $service->generatePdf(
            'admin.reports.short.applications.pdf',
            ['data' => $apps],
            'Short-Course-Applications.pdf'
        );
    }
    public function shortTrainingSummaryIndex(Request $request)
    {
        $courses = \App\Models\Course::orderBy('course_name')->get();

        $service = app(\App\Services\ShortCourseReportService::class);
        $summary = $service->trainingSummary($request->all());

        return view('admin.reports.short.training_summary.index', compact('summary', 'courses'));
    }
    public function shortTrainingSummaryPdf(Request $request)
    {
        $service = app(\App\Services\ShortCourseReportService::class);

        $summary = $service->trainingSummary($request->all());

        return $service->generatePdf(
            'admin.reports.short.training_summary.pdf',
            ['summary' => $summary],
            'Short-Course-Training-Summary.pdf'
        );
    }
    public function shortParticipantsIndex(Request $request)
    {
        $courses = \App\Models\Course::orderBy('course_name')->get();
        $trainings = \App\Models\Training::orderBy('start_date', 'desc')->get();

        $service = app(\App\Services\ShortCourseReportService::class);
        $participants = $service->participantsReport($request->all());

        return view('admin.reports.short.participants.index', compact(
            'participants', 'courses', 'trainings'
        ));
    }

    public function shortParticipantsPdf(Request $request)
    {
        $service = app(\App\Services\ShortCourseReportService::class);
        $participants = $service->participantsReport($request->all());

        return $service->generatePdf(
            'admin.reports.short.participants.pdf',
            ['participants' => $participants],
            'Short-Course-Participants-Master.pdf'
        );
    }
    public function employerReportIndex(Request $request)
    {
        $courses = Course::orderBy('course_name')->get();
        $trainings = Training::with('course')->orderBy('start_date', 'desc')->get();

        $service = app(ShortCourseReportService::class);
        $employers = $service->employerReport($request->all());

        return view('admin.reports.short.employers.index', compact('employers', 'courses', 'trainings'));
    }

    public function employerReportPdf(Request $request)
    {
        $service = app(ShortCourseReportService::class);
        $employers = $service->employerReport($request->all());

        return Pdf::loadView(
            'admin.reports.short.employers.pdf',
            compact('employers')
        )->setPaper('A4', 'landscape')
            ->download('Short-Course-Employer-Report.pdf');
    }
    public function employerStatement($employer)
    {
        $service = app(ShortCourseReportService::class);
        $statement = $service->employerStatement(urldecode($employer));

        if (!$statement) {
            abort(404, "Employer not found or no applications.");
        }

        return view('admin.reports.short.employers.statement', compact('statement'));
    }

    public function employerStatementPdf($employer)
    {
        $service = app(ShortCourseReportService::class);
        $statement = $service->employerStatement(urldecode($employer));

        $pdf = Pdf::loadView('admin.reports.short.employers.statement_pdf', compact('statement'))
            ->setPaper('A4', 'portrait');

        return $pdf->download("Statement-{$statement['employer_name']}.pdf");
    }
    public function shortRevenueIndex(Request $request)
    {
        $courses = \App\Models\Course::orderBy('course_name')->get();

        $service = app(\App\Services\ShortCourseReportService::class);
        $summary = $service->revenueReport($request->all());

        return view('admin.reports.short.revenue.index', compact('summary', 'courses'));
    }

    public function shortRevenuePdf(Request $request)
    {
        $service = app(\App\Services\ShortCourseReportService::class);
        $summary = $service->revenueReport($request->all());

        return $service->generatePdf(
            'admin.reports.short.revenue.pdf',
            ['summary' => $summary],
            'Short-Course-Revenue-Report.pdf'
        );
    }

}
