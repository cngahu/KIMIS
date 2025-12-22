<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptPdfService
{
    public function generateReceiptPdf(Invoice $invoice)
    {
        if ($invoice->status !== 'paid') {
            abort(403, 'Receipt can only be generated for paid invoices.');
        }

        $invoice->load('items');

        $pdf = Pdf::loadView('student.fees.pdf.receipt', [
            'invoice' => $invoice,
            'student' => $invoice->user?->student,
        ])->setPaper('a4');

        return $pdf->download(
            'Receipt_' . $invoice->invoice_number . '.pdf'
        );
    }
}
