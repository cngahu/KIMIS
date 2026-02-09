<?php

namespace App\Services;

use App\Models\Course;
use App\Models\HostelBooking;
use App\Models\StudentLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HostelBookingService
{
    public function createBooking(array $validated)
    {
        return DB::transaction(function () use ($validated) {

            $course = Course::with('college')->findOrFail($validated['course_id']);

            $amount = $validated['boarding_type'] === 'half'
                ? $course->half_board_fee
                : $course->full_board_fee;

            // -----------------------------------------
            // 1. CREATE HOSTEL BOOKING
            // -----------------------------------------
            $booking = HostelBooking::create([
                'reference'     => $this->generateReference(),
                'full_name'     => $validated['full_name'],
                'id_number'     => $validated['id_number'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'],
                'course_id'     => $course->id,
                'college_id'    => $course->college_id,
                'boarding_type' => $validated['boarding_type'],
                'status'        => 'pending_payment',
                'payment_status'=> 'pending',
                'metadata'      => [
                    'boarding_fee' => $amount,
                ],
            ]);

            // -----------------------------------------
            // 2. LEDGER DEBIT (EXPECTED HOSTEL FEE)
            // -----------------------------------------
            StudentLedger::create([
                'ledger_owner_type' => HostelBooking::class,
                'ledger_owner_id'   => $booking->id,

                'entry_type' => 'debit',
                'category'   => 'hostel_fee',
                'amount'     => $amount,

                'course_id'  => $course->id,

                'source'     => 'hostel_booking',
                'provisional'=> false,

                'reference_type' => HostelBooking::class,
                'reference_id'   => $booking->id,

                'description' =>
                    ucfirst($validated['boarding_type']) .
                    " board hostel fee for {$course->course_name}",
            ]);

            return $booking;
        });
    }

    protected function generateReference()
    {
        return 'HOSTEL-' . strtoupper(Str::random(8));
    }
}

