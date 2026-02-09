<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\HostelBookingSubmittedMail;
use App\Models\Course;
use App\Models\College;
use App\Models\HostelBooking;
use App\Models\StudentLedger;
use App\Services\HostelBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HostelBookingController extends Controller
{
    /**
     * Show hostel booking form
     */
    public function create(Request $request)
    {
        $courses = Course::with('college')
            ->where('is_hostel_booking_active', true)
            ->orderBy('course_name')
            ->get();

        $campuses = College::orderBy('name')->get();

        return view('public.hostel.book', compact('courses', 'campuses'));
    }


    /**
     * Store hostel booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'id_number'     => 'required|string|max:50',
            'email'         => 'required|email',
            'phone'         => 'required|string|max:20',
            'course_id'     => 'required|exists:courses,id',
            'boarding_type' => 'required|in:half,full',
        ]);

        $service = app(HostelBookingService::class);

        $booking = $service->createBooking($validated);

        // Email notification (next step)
        Mail::to($booking->email)
            ->send(new HostelBookingSubmittedMail($booking));

        return redirect()
            ->route('hostel.booking.payment', $booking->reference)
            ->with('success', 'Hostel booking submitted successfully.');
    }
    public function showPaymentPage(string $reference)
    {
        $booking = HostelBooking::where('reference', $reference)
            ->with(['course', 'college'])
            ->firstOrFail();

        $debits = StudentLedger::where([
            'ledger_owner_type' => HostelBooking::class,
            'ledger_owner_id'   => $booking->id,
            'entry_type'        => 'debit',
        ])->sum('amount');

        $credits = StudentLedger::where([
            'ledger_owner_type' => HostelBooking::class,
            'ledger_owner_id'   => $booking->id,
            'entry_type'        => 'credit',
        ])->sum('amount');

        $outstanding = round($debits - $credits, 2);

        return view('public.hostel.payment_choice', compact(
            'booking',
            'outstanding'
        ));
    }

}
