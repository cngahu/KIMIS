<?php

namespace App\Mail;

use App\Models\HostelBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HostelBookingSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public HostelBooking $booking;

    public function __construct(HostelBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('KIHBT Hostel Booking Submitted')
            ->view('emails.hostel.booking_submitted');
    }
}
