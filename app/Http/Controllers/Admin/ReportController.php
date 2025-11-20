<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //

    protected ReportService $reports;

    public function __construct(ReportService $reports)
    {
        $this->reports = $reports;
    }

    // Applications Report

    public function applicationsIndex()
    {
        $courses = Course::orderBy('course_name')->get();
        return view('admin.reports.applications.index', compact('courses'));
    }

    public function applicationsPreview(Request $request) {
        $data = $this->reports->applications($request);
        return view('admin.reports.applications.preview', compact('data'));
    }

    public function applicationsPdf(Request $request) {
        $data = $this->reports->applications($request);
        return $this->reports->generatePdf('admin.reports.applications.pdf', $data, 'All_Applications_Report.pdf');
    }

    // Decisions Report (Approved/Rejected)
    public function decisionsIndex() {
        return view('admin.reports.decisions.index');
    }

    public function decisionsPreview(Request $request) {
        $data = $this->reports->decisions($request);
        return view('admin.reports.decisions.preview', compact('data'));
    }

    public function decisionsPdf(Request $request) {
        $data = $this->reports->decisions($request);
        return $this->reports->generatePdf('admin.reports.decisions.pdf', $data, 'Decision_Report.pdf');
    }

    // Reviewer Performance
    public function reviewerIndex() {
        return view('admin.reports.reviewers.index');
    }

    public function reviewerPreview(Request $request) {
        $data = $this->reports->reviewer($request);
        return view('admin.reports.reviewers.preview', compact('data'));
    }

    public function reviewerPdf(Request $request) {
        $data = $this->reports->reviewer($request);
        return $this->reports->generatePdf('admin.reports.reviewers.pdf', $data, 'Reviewer_Performance_Report.pdf');
    }
}
