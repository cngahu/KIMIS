<?php

namespace App\Mail;
use App\Models\Application;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class ApplicationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;
    public User $user;
    public ?string $password; // <-- FIXED HERE
    public string $admissionLetter;
    public string $feeStructure;
    public string $medicalReport;


    public function __construct($application, $user, $password, $admissionLetter, $feeStructure,$medicalReport)
    {
        $this->application = $application;
        $this->user = $user;
        $this->password = $password;  // can be null now
        $this->admissionLetter = $admissionLetter;
        $this->feeStructure = $feeStructure;
        $this->medicalReport = $medicalReport;


    }

    public function build()
    {
        return $this->subject('Your Admission to KIHBT Has Been Approved')
            ->view('emails.application_approved')
            ->attachData($this->admissionLetter, 'Admission_Letter.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->feeStructure, 'Fee_Structure.pdf', [
                'mime' => 'application/pdf',
            ])
            ->attachData($this->medicalReport, 'medical_report.pdf', [
                'mime' => 'application/pdf',
            ])

            ->with([
                'application' => $this->application,
                'user'        => $this->user,
                'password'    => $this->password,  // null is now valid
            ]);
    }

}

