<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;
    public string $comments;

    public function __construct(Application $application, string $comments)
    {
        $this->application = $application;
        $this->comments   = $comments;
    }

    public function build()
    {
        return $this->subject('Your Application to KIHBT Was Not Successful')
            ->view('emails.application_rejected')
            ->with([
                'application' => $this->application,
                'comments'    => $this->comments,
            ]);
    }
}
