<?php

namespace App\Mail;
use App\Models\Admission;
use Illuminate\Mail\Mailable;
class AdmissionFeePaidMail
{
    public Admission $admission;

    public function __construct(Admission $admission)
    {
        $this->admission = $admission;
    }

    public function build()
    {
        return $this->subject('Admission Fee Payment Confirmation')
            ->view('emails.admission_fee_paid');
    }
}
