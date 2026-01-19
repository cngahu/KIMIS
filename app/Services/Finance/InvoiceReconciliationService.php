<?php

namespace App\Services\Finance;

use App\Models\Invoice;
use App\Models\StudentLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceReconciliationService
{
    public function reconcile(bool $dryRun = false): array
    {
        $summary = [
            'invoices_processed' => 0,
            'debits_created'     => 0,
            'credits_created'    => 0,
            'skipped'            => 0,
        ];

        $invoices = Invoice::orderBy('id')->get();

        foreach ($invoices as $invoice) {
            DB::transaction(function () use ($invoice, &$summary, $dryRun) {

                $summary['invoices_processed']++;

                // --------------------------------------------------
                // Resolve finance subject
                // --------------------------------------------------
                $studentId = null;
                $masterdataId = null;

                if ($invoice->user_id) {
                    $studentId = optional(
                        \App\Models\Student::where('user_id', $invoice->user_id)->first()
                    )->id;
                }

                if (!$studentId && isset($invoice->metadata['masterdata_id'])) {
                    $masterdataId = $invoice->metadata['masterdata_id'];
                }

                // --------------------------------------------------
                // A. DEBIT (if required)
                // --------------------------------------------------
                if ($this->requiresDebit($invoice)) {

                    $exists = StudentLedger::where([
                        'reference_type' => 'invoice',
                        'reference_id'   => $invoice->id,
                        'entry_type'     => 'debit',
                    ])->exists();

                    if (!$exists) {

                        if (!$dryRun) {
                            StudentLedger::create([
                                'student_id'    => $studentId,
                                'masterdata_id' => $masterdataId,

                                'entry_type'    => 'debit',
                                'category'      => $invoice->category,
                                'amount'        => $invoice->amount,

                                'reference_type'=> 'invoice',
                                'reference_id'  => $invoice->id,

                                'provisional'   => false,
                                'source'        => 'invoice_reconciliation',
                                'description'   => "Invoice {$invoice->invoice_number}",
                            ]);
                        }

                        $summary['debits_created']++;
                    }
                }

                // --------------------------------------------------
                // B. CREDIT (if paid)
                // --------------------------------------------------
                if ($invoice->status === 'paid' && $invoice->amount_paid > 0) {

                    $exists = StudentLedger::where([
                        'reference_type' => 'invoice',
                        'reference_id'   => $invoice->id,
                        'entry_type'     => 'credit',
                    ])->exists();

                    if (!$exists) {

                        if (!$dryRun) {
                            StudentLedger::create([
                                'student_id'    => $studentId,
                                'masterdata_id' => $masterdataId,

                                'entry_type'    => 'credit',
                                'category'      => 'payment',
                                'amount'        => $invoice->amount_paid,

                                'reference_type'=> 'invoice',
                                'reference_id'  => $invoice->id,

                                'provisional'   => false,
                                'source'        => $invoice->payment_channel ?? 'ecitizen',
                                'description'   => "Payment for {$invoice->invoice_number}",
                            ]);
                        }

                        $summary['credits_created']++;
                    }
                }

            });
        }

        return $summary;
    }

    protected function requiresDebit(Invoice $invoice): bool
    {
        return !in_array($invoice->category, [
            'tuition_fee',
            'course_fee',
        ]);
    }
}

