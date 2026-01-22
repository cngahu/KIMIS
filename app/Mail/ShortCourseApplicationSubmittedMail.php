<?php
namespace App\Mail;

use App\Models\ShortTrainingApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShortCourseApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public ShortTrainingApplication $application;

    public function __construct(ShortTrainingApplication $application)
    {
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject('Short Course Application Submitted – KIHBT')
            ->view('emails.short_courses.submitted_html')
            ->with([
                'application' => $this->application,
            ]);
    }
}

