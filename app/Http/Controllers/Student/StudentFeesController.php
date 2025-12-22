<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Student;
use App\Services\FeeStatementService;
use App\Services\InvoicePdfService;
use App\Services\ReceiptPdfService;
use Illuminate\Http\Request;

class StudentFeesController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        $invoices = Invoice::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('student.fees.index', compact('student', 'invoices'));
    }

    public function showInvoice(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        return view('student.fees.invoice', compact('invoice'));
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        return app(InvoicePdfService::class)->generateInvoicePdf($invoice);
    }

    public function downloadReceipt(Invoice $invoice)
    {
        $this->authorizeInvoice($invoice);

        if ($invoice->status !== 'paid') {
            abort(403, 'Receipt only available for paid invoices.');
        }

        return app(ReceiptPdfService::class)->generateReceiptPdf($invoice);
    }

    public function statement()
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        return app(FeeStatementService::class)->renderStudentStatement($student);
    }

    protected function authorizeInvoice(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
    }
}

