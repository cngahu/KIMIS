<?php

namespace App\Services\Student;

use App\Models\AdmissionFeePayment;
use App\Models\Invoice;

use App\Models\Admission;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
class AdmissionPaymentService0
{

    public function createInvoiceForAdmission(Admission $admission, float $amount, string $type = 'partial'): Invoice
    {
        // generate unique invoice_number
        $invoiceNumber = 'ADM-' . date('Ymd') . '-' . Str::upper(Str::random(6));

        $invoice = Invoice::create([
            'application_id' => $admission->application_id,
            'invoice_number' => $invoiceNumber,
            'amount' => $amount,
            'status' => 'pending',
            'metadata' => json_encode(['admission_id' => $admission->id, 'payment_type' => $type]),
        ]);

        AdmissionFeePayment::create([
            'admission_id' => $admission->id,
            'invoice_id' => $invoice->id,
            'amount' => $amount,
            'payment_type' => $type,
            'status' => 'pending'
        ]);

        return $invoice;
    }

    /**
     * Mark invoice paid (called from callback or simulation).
     * This will update invoice.status, invoice.paid_at and the admission_fee_payment.
     */
    public function markInvoicePaid(Invoice $invoice, ?string $gatewayReference = null)
    {
        $invoice->update([
            'status' => 'paid',
            'gateway_reference' => $gatewayReference,
            'paid_at' => now(),
        ]);

        // update linked admission fee payment
        $fp = AdmissionFeePayment::where('invoice_id', $invoice->id)->first();
        if ($fp) {
            $fp->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        // compute totals and update admission status if fully paid
        $admissionId = data_get(json_decode($invoice->metadata, true), 'admission_id') ?? null;

        if ($admissionId) {
            $admission = Admission::find($admissionId);
            if ($admission) {
                $courseFee = optional($admission->application->course)->cost ?? 0;
                $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
                    ->where('status','paid')
                    ->sum('amount');

                if (bccomp($paidTotal, $courseFee, 2) >= 0) {
                    $admission->update(['status' => 'fee_paid']);
                } else {
                    // partial paid; you might set a status such as 'awaiting_balance'
                    $admission->update(['status' => 'awaiting_fee_balance']);
                }
            }
        }

        return $invoice;
    }

    /**
     * Create sponsor / pay later entry (no invoice).
     */
    public function createNonInvoicePayment(Admission $admission, array $data)
    {
        $rec = AdmissionFeePayment::create([
            'admission_id' => $admission->id,
            'invoice_id' => null,
            'amount' => $data['amount'] ?? 0,
            'payment_type' => $data['payment_type'],
            'status' => 'pending',
            'sponsor_name' => $data['sponsor_name'] ?? null,
            'explanation' => $data['explanation'] ?? null,
            'sponsor_letter' => $data['sponsor_letter'] ?? null,
        ]);

        // optionally update admission.status e.g. 'awaiting_verification'
        $admission->update(['status' => $data['payment_type'] === 'sponsor' ? 'awaiting_sponsor_verification' : 'awaiting_fee_decision']);

        return $rec;
    }
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


class AdmissionPaymentService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Generate an invoice for admission fee (full/partial).
     */
    public function createInvoiceForAdmission(Admission $admission, float $amount, string $type = 'partial'): Invoice
    {
        $invoiceNumber = 'ADM-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $invoice = Invoice::create([
            'application_id' => $admission->application_id,   // global invoice consistency
            'invoice_number' => $invoiceNumber,
            'amount'         => $amount,
            'status'         => 'pending',
            'metadata'       => [
                'admission_id' => $admission->id,
                'payment_type' => $type,
                'module'       => 'admission_fee'
            ],
        ]);

        // Ledger entry
        $feePayment = AdmissionFeePayment::create([
            'admission_id' => $admission->id,
            'invoice_id'   => $invoice->id,
            'amount'       => $amount,
            'payment_type' => $type,
            'status'       => 'pending'
        ]);

        // Audit
        $this->audit->log('admission_invoice_created', $invoice, [
            'new' => [
                'amount' => $amount,
                'type'   => $type,
                'invoice_number' => $invoiceNumber
            ]
        ]);

        return $invoice;
    }


    /**
     * Mark invoice as paid (callback or manual simulation)
     */
    public function markInvoicePaid0(Invoice $invoice, ?string $gatewayReference = null)
    {
        $old = $invoice->getOriginal();

        $invoice->update([
            'status'            => 'paid',
            'gateway_reference' => $gatewayReference,
            'amount_paid'      => $invoice->amount,
            'paid_at'           => now(),
        ]);

        // update admission ledger
        $fp = AdmissionFeePayment::where('invoice_id', $invoice->id)->first();
        if ($fp) {
            $fp->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);
        }

        // Identify admission ID from invoice metadata
        $meta = $invoice->metadata ?? [];
        $admissionId = $meta['admission_id'] ?? null;

        if ($admissionId) {
            $admission = Admission::find($admissionId);

            if ($admission) {
//                $courseFee = optional($admission->application->course)->cost ?? 0;
                $courseFee = $admission->required_fee ?? 0;

                $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
                    ->where('status','paid')
                    ->sum('amount');

                if (bccomp($paidTotal, $courseFee, 2) >= 0) {
                    $admission->update(['status' => 'fee_paid']);
                } else {
                    $admission->update(['status' => 'fee_pending']);
                }

                // Audit
                $this->audit->log('admission_invoice_paid', $invoice, [
                    'old' => $old,
                    'new' => $invoice->getChanges(),
                ]);
            }
        }

        return $invoice;
    }
    public function markInvoicePaid(Invoice $invoice, ?string $gatewayReference = null, ?float $amountPaid = null)
    {
        $old = $invoice->getOriginal();

        // Default to full invoice amount if not provided
        $amountPaid = $amountPaid ?? $invoice->amount;

        $invoice->update([
            'status'            => 'paid',
            'gateway_reference' => $gatewayReference,
            'amount_paid'       => $amountPaid,    // ✅ store actual paid amount
            'paid_at'           => now(),
        ]);

        // Update admission ledger
        $fp = AdmissionFeePayment::where('invoice_id', $invoice->id)->first();
        if ($fp) {
            $fp->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);
        }

        // Identify admission ID from invoice metadata
        $meta = $invoice->metadata ?? [];
        $admissionId = $meta['admission_id'] ?? null;

        if ($admissionId) {
            $admission = Admission::find($admissionId);

            if ($admission) {
                $courseFee = $admission->required_fee ?? 0;

                // Compute total paid so far from all invoices
                $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
                    ->where('status','paid')
                    ->sum('amount');

                if (bccomp($paidTotal, $courseFee, 2) >= 0) {
                    $admission->update(['status' => 'fee_paid']);
                } else {
                    $admission->update(['status' => 'fee_pending']);
                }

                // Audit
                $this->audit->log('admission_invoice_paid', $invoice, [
                    'old' => $old,
                    'new' => $invoice->getChanges(),
                ]);
            }
        }

        return $invoice;
    }


    /**
     * Sponsor / bursary / Pay Later
     */
    public function createNonInvoicePayment(Admission $admission, array $data)
    {
        $entry = AdmissionFeePayment::create([
            'admission_id'   => $admission->id,
            'invoice_id'     => null,
            'amount'         => $data['amount'] ?? 0,
            'payment_type'   => $data['payment_type'],
            'status'         => 'pending',
            'sponsor_name'   => $data['sponsor_name'] ?? null,
            'explanation'    => $data['explanation'] ?? null,
            'sponsor_letter' => $data['sponsor_letter'] ?? null,
        ]);

        $status = match ($data['payment_type']) {
            'sponsor' => 'awaiting_sponsor_verification',
            default   => 'awaiting_fee_decision'
        };

        $admission->update(['status' => $status]);

        $this->audit->log('noninvoice_admission_payment_created', $entry);

        return $entry;
    }


    /**
     * Legacy method (kept for backward compatibility)
     */
    public function createInvoice($admission, $amount)
    {
        return $this->createInvoiceForAdmission($admission, $amount, 'partial');
    }
}
