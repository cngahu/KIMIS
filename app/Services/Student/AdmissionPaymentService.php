<?php

namespace App\Services\Student;

use App\Models\AdmissionFeePayment;
use App\Models\Invoice;

class AdmissionPaymentService
{
    public function createInvoice($admission, $amount)
    {
        $invoiceNo = 'ADMPAY-' . date('Ymd') . '-' . str_pad(rand(1,999999), 6, '0', STR_PAD_LEFT);

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNo,
            'application_id' => $admission->application_id,
            'amount' => $amount,
            'status' => 'pending',
            'metadata' => ['admission_payment' => true]
        ]);

        AdmissionFeePayment::create([
            'admission_id' => $admission->id,
            'invoice_id' => $invoice->id,
            'amount' => $amount,
            'status' => 'pending'
        ]);

        return $invoice;
    }
}
