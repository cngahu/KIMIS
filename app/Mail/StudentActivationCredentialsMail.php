<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentActivationCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $username;
    public string $password;
    public string $studentName;

    public function __construct(string $username, string $password, string $studentName)
    {
        $this->username = $username;
        $this->password = $password;
        $this->studentName = $studentName;
    }

    public function build()
    {
        return $this->subject('KIHBT Student Portal Account Activated')
            ->view('emails.student_activation_credentials');
    }
}
