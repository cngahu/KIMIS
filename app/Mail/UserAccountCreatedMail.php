<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserAccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $plainPassword
    ) {}

    public function build()
    {
        return $this->subject('Your account has been created')
            ->view('emails.user_account_created');
    }
}
