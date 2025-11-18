<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOTP extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $code;
    public $user;
    public $ip;
    public $date;

    public function __construct($code, $user)
    {
        $this->code = $code;
        $this->user = $user;
        $this->ip = request()->ip();
        $this->date = now()->format('l, F j, Y \a\t g:i A');
    }


    public function build()
    {
        return $this->subject('KIHBT Secure Login – Your Verification Code')
            ->view('emails.otp-html')
            ->with([
                'code' => $this->code,
                'user' => $this->user,
                'ip'   => $this->ip,
                'date' => $this->date,
            ]);
    }

}
