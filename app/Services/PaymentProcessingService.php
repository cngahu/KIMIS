<?php

namespace App\Services;
use App\Models\Admission;
use App\Models\AdmissionFeePayment;
use App\Models\Invoice;
use App\Models\Application;
use App\Models\ShortTrainingApplication;
use App\Models\StudentCycleRegistration;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use App\Models\StudentLedger;

class PaymentProcessingService
{
    public function handleInvoicePaid(Invoice $invoice)
    {
        $billable = $invoice->billable;

        if (!$billable) {
            return;
        }
        // 🔥 NEW: Always post ledger credit first
        $this->postLedgerCredit($invoice);

        switch ($invoice->category) {

            case 'application_fee':
            case 'knec_application':

                $this->handleKnecApplicationPaid($billable);
                break;
            case 'course_fee':
                $this->handleLongCoursePaid($billable);
                break;

            case 'short_course':
                $this->handleShortCoursePaid($billable);
                break;
            case 'admission_fee':  // 🔥 new case
                $this->handleAdmissionFeePaid($billable, $invoice);
                break;
            case 'tuition_fee': // 🔥 NEW
                $this->handleTuitionFeePaid($billable, $invoice);
                break;
            // future:
            // case 'hostel_fee':
            // case 'admission_fee':
            // case 'exam_fee':
        }
    }
    protected function handleKnecApplicationPaid(Application $app)
    {
        $app->update([
            'payment_status' => 'paid',
            'status' => 'submitted',
        ]);

        // trigger vetting workflow, send email, etc.
    }
    protected function handleLongCoursePaid(Application $app)
    {
        $app->update([
            'payment_status' => 'paid',
            'status' => 'under_review',
        ]);

        // trigger vetting workflow, send email, etc.
    }

    protected function handleShortCoursePaid(ShortTrainingApplication $app)
    {
        $app->update([
            'payment_status' => 'paid',
            'status' => 'paid', // short courses don’t go to vetting
        ]);

        // send email / SMS to employer or student
    }

    protected function handleAdmissionFeePaid0(Admission $admission, Invoice $invoice)
    {
        // 1. Get required fee
        $courseFee = $admission->required_fee ?? 0;

        // 2. Sum all payments from ledger
        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount');

        // 3. Update admission status based on cumulative payments
        if (bccomp($paidTotal, $courseFee, 2) >= 0) {
            $admission->update(['status' => 'fee_paid']);
        } else {
            $admission->update(['status' => 'fee_pending']);
        }

        // 4. Send communications (email/SMS)
        try {
//            Mail::to($admission->application->email)
//                ->send(new \App\Mail\AdmissionFeePaidMail($admission, $invoice));
        } catch (\Exception $e) {
            Log::error("Failed to send admission fee email", ['error' => $e->getMessage()]);
        }

        // 5. Audit log
        app(AuditLogService::class)->log('admission_fee_paid', $invoice, [
            'admission_id' => $admission->id,
            'paid_total'   => $paidTotal,
            'course_fee'   => $courseFee,
        ]);
    }
    protected function handleAdmissionFeePaid(Admission $admission, Invoice $invoice)
    {
        // 1. Update the ledger entry for THIS specific invoice
        $fp = AdmissionFeePayment::where('invoice_id', $invoice->id)->first();

        if ($fp) {
            $fp->update([
                'status'  => 'paid',
                'paid_at' => now(),
            ]);
        }

        // 2. Compute total paid so far for this admission (ALL invoices)
        $courseFee = $admission->required_fee ?? 0;

        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount'); // YES — this stays using admission_id

        // 3. Update admission status
        if (bccomp($paidTotal, $courseFee, 2) >= 0) {
            $admission->update(['status' => 'fee_paid']);
        } else {
            $admission->update(['status' => 'fee_pending']);
        }

        // 4. Audit log
        app(AuditLogService::class)->log('admission_fee_paid', $invoice, [
            'admission_id' => $admission->id,
            'paid_total'   => $paidTotal,
            'course_fee'   => $courseFee,
            'invoice_id'   => $invoice->id,
        ]);
    }
    protected function handleTuitionFeePaid(StudentCycleRegistration $registration, Invoice $invoice)
    {
        // 1. Mark registration as confirmed
        $registration->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // 2. Advance enrollment stage (if applicable)
        $enrollment = $registration->enrollment;

        if ($enrollment && $enrollment->course_stage_id !== $registration->course_stage_id) {
            $enrollment->update([
                'course_stage_id' => $registration->course_stage_id,
            ]);
        }

        // 3. Audit
        app(AuditLogService::class)->log('tuition_fee_paid', $invoice, [
            'student_id'      => $registration->student_id,
            'enrollment_id'   => $registration->enrollment_id,
            'cycle_year'      => $registration->cycle_year,
            'cycle_term'      => $registration->cycle_term,
            'invoice_id'      => $invoice->id,
        ]);
    }




    protected function postLedgerCredit0(Invoice $invoice): void
    {


        // Idempotency: never double-post
        $exists = StudentLedger::where([
            'reference_type' => 'invoice',
            'reference_id'   => $invoice->id,
            'entry_type'     => 'credit',
        ])->exists();

        if ($exists) {
            return;
        }

        $student = Student::where('user_id', $invoice->user_id)->first();

        StudentLedger::create([
            // -------------------------------------------------
            // LEGACY / CURRENT (keep)
            // -------------------------------------------------
            'student_id'     => $student?->id,
            'masterdata_id'  => $student?->admission_id,

            // -------------------------------------------------
            // NEW: LEDGER OWNER (AUTHORITATIVE)
            // -------------------------------------------------
            'ledger_owner_type' => $student
                ? \App\Models\Student::class
                : \App\Models\Masterdata::class,

            'ledger_owner_id' => $student
                ? $student->id
                : $invoice->metadata['masterdata_id'] ?? $student?->admission_id,

            // -------------------------------------------------
            // LEDGER ENTRY DETAILS
            // -------------------------------------------------
            'entry_type'     => 'credit',
            'category'       => 'payment',
            'amount'         => $invoice->amount_paid,

            // -------------------------------------------------
            // REFERENCE (WHAT CAUSED THIS ENTRY)
            // -------------------------------------------------
            'reference_type' => \App\Models\Invoice::class,
            'reference_id'   => $invoice->id,

            // -------------------------------------------------
            // METADATA
            // -------------------------------------------------
            'source'         => $invoice->payment_channel ?? 'ecitizen',
            'provisional'    => false,

            'description'    => "Payment received for invoice {$invoice->invoice_number}",
        ]);


    }
    protected function postLedgerCredit(Invoice $invoice): void
    {
        // -------------------------------------------------
        // IDEMPOTENCY CHECK
        // -------------------------------------------------
        $exists = StudentLedger::where([
            'reference_type' => Invoice::class,
            'reference_id'   => $invoice->id,
            'entry_type'     => 'credit',
        ])->exists();

        if ($exists) {
            return;
        }

        // -------------------------------------------------
        // RESOLVE LEDGER OWNER
        // -------------------------------------------------
        $ledgerOwnerType = null;
        $ledgerOwnerId   = null;

        // 1️⃣ Short course payment
        if ($invoice->category === 'short_course'
            && $invoice->billable_type === \App\Models\ShortTrainingApplication::class
        ) {
            $ledgerOwnerType = \App\Models\ShortTrainingApplication::class;
            $ledgerOwnerId   = $invoice->billable_id;
        }

        // 2️⃣ Student payment
        elseif ($invoice->user_id) {
            $student = Student::where('user_id', $invoice->user_id)->first();

            if ($student) {
                $ledgerOwnerType = Student::class;
                $ledgerOwnerId   = $student->id;
            }
        }

        // 3️⃣ Legacy fallback (VERY RARE)
        if (!$ledgerOwnerType) {
            $ledgerOwnerType = \App\Models\Masterdata::class;
            $ledgerOwnerId   = $invoice->metadata['masterdata_id'] ?? null;
        }

        // -------------------------------------------------
        // CREATE LEDGER CREDIT
        // -------------------------------------------------
        StudentLedger::create([

            // ------------------------------
            // LEDGER OWNER (AUTHORITATIVE)
            // ------------------------------
            'ledger_owner_type' => $ledgerOwnerType,
            'ledger_owner_id'   => $ledgerOwnerId,

            // ------------------------------
            // LEGACY SUPPORT (STUDENTS ONLY)
            // ------------------------------
            'student_id'    => isset($student) ? $student->id : null,
            'masterdata_id' => isset($student) ? $student->admission_id : null,

            // ------------------------------
            // ENTRY DETAILS
            // ------------------------------
            'entry_type' => 'credit',
            'category'   => 'payment',
            'amount'     => $invoice->amount_paid,

            // ------------------------------
            // TRACEABILITY
            // ------------------------------
            'reference_type' => Invoice::class,
            'reference_id'   => $invoice->id,

            // ------------------------------
            // METADATA
            // ------------------------------
            'source'      => $invoice->payment_channel ?? 'ecitizen',
            'provisional' => false,

            'description' =>
                "Payment received for invoice {$invoice->invoice_number}",
        ]);
    }

}
