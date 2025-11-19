<?php

namespace App\Services;
use App\Mail\AdminNewApplicationMail;
use App\Mail\ApplicantApplicationReceivedMail;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;
class ApplicationNotificationService
{
    public function sendNotifications(Invoice $invoice)
    {
        $application = $invoice->application;

        // 1. Email the applicant
        if ($application->email) {
            Mail::to($application->email)
                ->send(new ApplicantApplicationReceivedMail($application));
        }

        // 2. Email the admin office
        Mail::to('papacosi@gmail.com')
            ->send(new AdminNewApplicationMail($application));
    }
}
