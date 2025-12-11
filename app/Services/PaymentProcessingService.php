<?php

namespace App\Services;
use App\Models\Admission;
use App\Models\AdmissionFeePayment;
use App\Models\Invoice;
use App\Models\Application;
use App\Models\ShortTrainingApplication;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentProcessingService
{
    public function handleInvoicePaid(Invoice $invoice)
    {
        $billable = $invoice->billable;

        if (!$billable) {
            return;
        }

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

    protected function handleAdmissionFeePaid(Admission $admission, Invoice $invoice)
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

}
