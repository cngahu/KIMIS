<?php

namespace App\Services;
use App\Models\Invoice;
use App\Models\Application;
use App\Models\ShortTrainingApplication;
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
}
