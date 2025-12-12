<?php

namespace App\Services;
use App\Models\Invoice;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class FinanceReportService
{
    /**
     * DAILY COLLECTIONS REPORT
     */
    public function dailyCollections(array $filters = [])
    {
        $query = Invoice::query()
            ->where('status', 'paid')
            ->orderBy('paid_at', 'desc');

        // Filter by a specific date
        if (!empty($filters['date'])) {
            $query->whereDate('paid_at', $filters['date']);
        }

        // Date range filters
        if (!empty($filters['from_date'])) {
            $query->whereDate('paid_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('paid_at', '<=', $filters['to_date']);
        }

        // Payment channel
        if (!empty($filters['channel'])) {
            $query->where('payment_channel', $filters['channel']);
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        // Load related billable entity automatically
        $query->with(['billable']);

        return $query->get();
    }


    /**
     * Generate PDF for daily collections
     */
    public function dailyCollectionsPdf($data)
    {
        $pdf = Pdf::loadView('admin.reports.finance.daily.pdf', [
            'invoices' => $data,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('Daily-Collections-Report.pdf');
    }

    public function outstandingPayments(array $filters = [])
    {
        $query = Invoice::query()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->with(['billable', ]);

        // Filter by date range
        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        // Filter by category
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

//        // Filter by course (for long or short course invoices)
//        if (!empty($filters['course_id'])) {
//            $query->where('course_id', $filters['course_id']);
//        }

        // Filter by payer type
        if (!empty($filters['payer_type'])) {
            $query->where('billable_type', $filters['payer_type']);
        }

        return $query->get();
    }
    protected function resolveCourseName($invoice)
    {
        $billable = $invoice->billable;

        if (!$billable) {
            return 'N/A';
        }

        // Long Course – Application Model
        if ($invoice->billable_type === \App\Models\Application::class) {
            return optional($billable->course)->course_name ?? 'N/A';
        }

        // Short Course – ShortTrainingApplication Model
        if ($invoice->billable_type === \App\Models\ShortTrainingApplication::class) {
            return optional($billable->training->course)->course_name ?? 'N/A';
        }

        return 'N/A';
    }
    protected function resolvePayerName($invoice)
    {
        $billable = $invoice->billable;

        if (!$billable) return 'Unknown';

        // Long Course Applicant
        if ($invoice->billable_type === \App\Models\Application::class) {
            return $billable->full_name;
        }

        // Short Course Applicant
        if ($invoice->billable_type === \App\Models\ShortTrainingApplication::class) {

            // Employer-sponsored
            if ($billable->financier === 'employer') {
                return $billable->employer_name;
            }

            // Self-sponsored
            return optional($billable->participants->first())->full_name;
        }

        return 'Unknown';
    }


    public function outstandingPaymentsPdf($data)
    {
        $pdf = Pdf::loadView('admin.reports.finance.outstanding.pdf', [
            'invoices' => $data,
            'generatedAt' => now(),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('Outstanding-Payments-Report.pdf');
    }

}
