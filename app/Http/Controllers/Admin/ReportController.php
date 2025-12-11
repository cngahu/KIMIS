<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\User;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //

    protected ReportService $reports;

    public function __construct(ReportService $reports)
    {
        $this->reports = $reports;
    }
    public function applicationsData(Request $request)
    {
        $data = $this->reports->applications($request);

        return view('admin.reports.applications.table', compact('data'));
    }

    // Applications Report

    public function applicationsIndex()
    {
        $courses = Course::orderBy('course_name')->get();
        return view('admin.reports.applications.index', compact('courses'));
    }

    public function applicationsIndexKnec()
    {
        $courses = Course::orderBy('course_name')->get();
        return view('admin.reports.applications.knec_index', compact('courses'));
    }

//    public function applicationsPreview(Request $request) {
//        $data = $this->reports->applications($request);
//        return view('admin.reports.applications.preview', compact('data'));
//    }
    public function applicationsPreview(Request $request)
    {
        $data = $this->reports->applications($request, true);

        return view('admin.reports.applications.preview', compact('data'));
    }

    public function applicationsPreview0(Request $request)
    {
        $service = app(\App\Services\ApplicationReportService::class);

        $applications = $service->getFilteredApplications($request->all());

        return view('admin.reports.applications.preview-table', compact('applications'))->render();
    }

//    public function applicationsPdf(Request $request) {
//        $data = $this->reports->applications($request);
//        return $this->reports->generatePdf('admin.reports.applications.pdf', $data, 'All_Applications_Report.pdf');
//    }
    public function applicationsPdf(Request $request)
    {
        $data = $this->reports->applications($request, false);

        return $this->reports->generatePdf(
            'admin.reports.applications.pdf',
            $data,
            'applications-report.pdf'
        );
    }

    // Decisions Report (Approved/Rejected)
//    public function decisionsIndex() {
//        return view('admin.reports.decisions.index');
//    }

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

    public function decisionsIndex()
    {
        // Load reviewers for filter dropdown
        $reviewers = \App\Models\User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['hod', 'campus_registrar']);
        })->orderBy('surname')->get();


        return view('admin.reports.decisions.index', compact('reviewers'));
    }
    public function rejectedIndex(Request $request)
    {
        // Load reviewers who can reject applications
        $reviewers = User::whereHas('roles', function ($q) {
            $q->whereIn('name', ['hod', 'campus_registrar']);
        })->orderBy('surname')->get();

        // Fetch rejected applications (with filtering)
        $query = Application::with(['course', 'reviewer'])
            ->where('status', 'rejected');

        if ($request->reviewer_id) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        $applications = $query->orderBy('updated_at', 'desc')->get();

        return view('admin.reports.decisions.rejected', compact('applications', 'reviewers'));
    }
    public function rejectedPdf(Request $request)
    {
        $query = Application::with(['course', 'reviewer'])
            ->where('status', 'rejected');

        if ($request->reviewer_id) {
            $query->where('reviewer_id', $request->reviewer_id);
        }

        $applications = $query->orderBy('updated_at', 'desc')->get();

        $pdf = Pdf::loadView('admin.reports.decisions.rejected-pdf', [
            'applications' => $applications
        ])->setPaper('A4', 'landscape');

        return $pdf->download('Rejected-Applications.pdf');
    }

    public function rejectedData(Request $request)
    {
        $data = app(\App\Services\ReportService::class)->rejectedApplications($request);

        return view('admin.reports.decisions.table', compact('data'))->render();
    }
    public function applicationsSummary(Request $request)
    {
        // Base query
        $query = Application::query();

        // Optional filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->get();

        // -------------------------------------
        // 1. STATUS COUNTS
        // -------------------------------------
        $statusCounts = Application::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total','status');

        // -------------------------------------
        // 2. FINANCIER COUNTS
        // -------------------------------------
        $financiers = Application::select('financier', DB::raw('COUNT(*) as total'))
            ->groupBy('financier')
            ->pluck('total','financier');

        // -------------------------------------
        // 3. HOME COUNTY DISTRIBUTION
        // -------------------------------------
        $homeCountyStats = Application::select('home_county_id', DB::raw('COUNT(*) as total'))
            ->with('homeCounty')
            ->groupBy('home_county_id')
            ->get();

        // -------------------------------------
        // 4. CURRENT COUNTY DISTRIBUTION
        // -------------------------------------
        $currentCountyStats = Application::select('current_county_id', DB::raw('COUNT(*) as total'))
            ->with('currentCounty')
            ->groupBy('current_county_id')
            ->get();

        // -------------------------------------
        // 5. CURRENT SUBCOUNTY DISTRIBUTION
        // -------------------------------------
        $subcountyStats = Application::select('current_subcounty_id', DB::raw('COUNT(*) as total'))
            ->with('currentSubcounty')
            ->groupBy('current_subcounty_id')
            ->get();

        // -------------------------------------
        // 6. COURSE DISTRIBUTION
        // -------------------------------------
        $courseStats = Application::select('course_id', DB::raw('COUNT(*) as total'))
            ->with('course')
            ->groupBy('course_id')
            ->get();

        // -------------------------------------
        // 7. AGE GROUP DISTRIBUTION
        // -------------------------------------
        $ageGroups = [
            'Below 18' => 0,
            '18-24' => 0,
            '25-29' => 0,
            '30-34' => 0,
            '35-39' => 0,
            '40-44' => 0,
            '45-49' => 0,
            '50-54' => 0,
            '55+' => 0,
        ];

        foreach ($applications as $app) {
            if (!$app->date_of_birth) continue;

            $age = \Carbon\Carbon::parse($app->date_of_birth)->age;

            match (true) {
                $age < 18 => $ageGroups['Below 18']++,
                $age <= 24 => $ageGroups['18-24']++,
                $age <= 29 => $ageGroups['25-29']++,
                $age <= 34 => $ageGroups['30-34']++,
                $age <= 39 => $ageGroups['35-39']++,
                $age <= 44 => $ageGroups['40-44']++,
                $age <= 49 => $ageGroups['45-49']++,
                $age <= 54 => $ageGroups['50-54']++,
                default => $ageGroups['55+']++
            };
        }

        return view('admin.reports.summary.index', compact(
            'applications',
            'statusCounts',
            'financiers',
            'homeCountyStats',
            'currentCountyStats',
            'subcountyStats',
            'courseStats',
            'ageGroups'
        ));
    }
    public function applicationsSummaryPdf(Request $request)
    {
        // Use same logic as summary above, reuse summary builder
        $data = $this->applicationsSummary($request)->getData();

        $pdf = Pdf::loadView('admin.reports.summary.pdf', (array) $data)
            ->setPaper('A4', 'landscape');

        return $pdf->download('Applications-Summary-Report.pdf');
    }
//    public function applicationsSummaryIndex(Request $request)
//    {
//        // Build all summary data (status counts, charts, county breakdown, etc.)
//        $data = $this->applicationsSummary($request);
//
//        return view('admin.reports.summary.index', $data);
//    }
    public function applicationsSummaryIndex(Request $request)
    {
        $data = $this->buildApplicationsSummary($request);
        return view('admin.reports.summary.index', $data);
    }

    private function buildApplicationsSummary(Request $request): array
    {
        $query = Application::query();

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $applications = $query->get();

        $statusCounts = Application::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total','status');

        $financiers = Application::select('financier', DB::raw('COUNT(*) as total'))
            ->groupBy('financier')
            ->pluck('total','financier');

        $homeCountyStats = Application::select('home_county_id', DB::raw('COUNT(*) as total'))
            ->with('homeCounty')
            ->groupBy('home_county_id')
            ->get();

        $currentCountyStats = Application::select('current_county_id', DB::raw('COUNT(*) as total'))
            ->with('currentCounty')
            ->groupBy('current_county_id')
            ->get();

        $subcountyStats = Application::select('current_subcounty_id', DB::raw('COUNT(*) as total'))
            ->with('currentSubcounty')
            ->groupBy('current_subcounty_id')
            ->get();

        $courseStats = Application::select('course_id', DB::raw('COUNT(*) as total'))
            ->with('course')
            ->groupBy('course_id')
            ->get();

        // ---- AGE GROUPS ----
        $ageGroups = [
            'Below 18' => 0, '18-24' => 0, '25-29' => 0,
            '30-34' => 0, '35-39' => 0, '40-44' => 0,
            '45-49' => 0, '50-54' => 0, '55+' => 0,
        ];

        foreach ($applications as $app) {
            if (!$app->date_of_birth) continue;
            $age = \Carbon\Carbon::parse($app->date_of_birth)->age;

            match (true) {
                $age < 18 => $ageGroups['Below 18']++,
                $age <= 24 => $ageGroups['18-24']++,
                $age <= 29 => $ageGroups['25-29']++,
                $age <= 34 => $ageGroups['30-34']++,
                $age <= 39 => $ageGroups['35-39']++,
                $age <= 44 => $ageGroups['40-44']++,
                $age <= 49 => $ageGroups['45-49']++,
                $age <= 54 => $ageGroups['50-54']++,
                default => $ageGroups['55+']++
            };
        }

        return [
            'applications' => $applications,
            'statusCounts' => $statusCounts,
            'financiers' => $financiers,
            'homeCountyStats' => $homeCountyStats,
            'currentCountyStats' => $currentCountyStats,
            'subcountyStats' => $subcountyStats,
            'courseStats' => $courseStats,
            'ageGroups' => $ageGroups,
        ];
    }

}
