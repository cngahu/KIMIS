<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\FinanceReportService;

class FinanceReportController extends Controller
{
    //

    protected FinanceReportService $service;

    public function __construct(FinanceReportService $service)
    {
        $this->service = $service;
    }

    public function dailyCollectionsIndex(Request $request)
    {
        $invoices = $this->service->dailyCollections($request->all());

        return view('admin.reports.finance.daily.index', compact('invoices'));
    }

    public function dailyCollectionsPdf(Request $request)
    {
        $invoices = $this->service->dailyCollections($request->all());
        return $this->service->dailyCollectionsPdf($invoices);
    }

    public function outstandingIndex(Request $request)
    {
        $invoices = $this->service->outstandingPayments($request->all());
        $courses = \App\Models\Course::orderBy('course_name')->get();

        return view('admin.reports.finance.outstanding.index', compact('invoices', 'courses'));
    }

    public function outstandingPdf(Request $request)
    {
        $invoices = $this->service->outstandingPayments($request->all());
        return $this->service->outstandingPaymentsPdf($invoices);
    }

}
