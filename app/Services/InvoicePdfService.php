<?php

namespace App\Services;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoicePdfService
{
    public function generateInvoicePdf(Invoice $invoice)
    {
        $invoice->load('items');

        $pdf = Pdf::loadView('student.fees.pdf.invoice', [
            'invoice' => $invoice,
            'student' => $invoice->user?->student,
        ])->setPaper('a4');

        return $pdf->download(
            'Invoice_' . $invoice->invoice_number . '.pdf'
        );
    }
}
