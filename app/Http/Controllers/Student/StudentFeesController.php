<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Student;
use App\Services\Finance\FeeStatementService;
use App\Services\InvoicePdfService;
use App\Services\ReceiptPdfService;
use Illuminate\Http\Request;

class StudentFeesController extends Controller
{
    public function index(FeeStatementService $service)
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        $data = $service->build($student->id, $student->admission_id);

        return view('student.fees.index', array_merge($data, [
            'student' => $student,
        ]));
    }

    public function download(FeeStatementService $service)
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        $data = $service->build($student->id, $student->admission_id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'student.fees.fee_statement_pdf',
            $data
        )->setPaper('A4');

        return $pdf->download('KIHBT_Fee_Statement.pdf');
    }

    /**
     * ✅ FIXED: was calling renderStudentStatement() which doesn't exist.
     * Now uses build() and returns a dedicated statement view.
     */
    public function statement(FeeStatementService $service)
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        $data = $service->build($student->id, $student->admission_id);

        return view('student.fees.statement', array_merge($data, [
            'student' => $student,
        ]));
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

    protected function authorizeInvoice(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }
    }
}