<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HostelBooking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\StudentLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HostelBookingPaymentController extends Controller
{
    public function createInvoice(Request $request, string $reference)
    {
        // --------------------------------------
        // 1. FETCH BOOKING
        // --------------------------------------
        $booking = HostelBooking::where('reference', $reference)->firstOrFail();

        // --------------------------------------
        // 2. CALCULATE OUTSTANDING (LEDGER TRUTH)
        // --------------------------------------
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

        if ($outstanding <= 0) {
            return back()->withErrors([
                'amount' => 'This hostel booking is already fully paid.',
            ]);
        }

        // --------------------------------------
        // 3. CREATE INVOICE (FULL AMOUNT ONLY)
        // --------------------------------------
        $invoice = Invoice::create([
            'billable_type'  => HostelBooking::class,
            'billable_id'    => $booking->id,
            'category'       => 'hostel',
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
            'amount'         => $outstanding,
            'status'         => 'pending',
            'metadata'       => [
                'booking_reference' => $booking->reference,
                'payment_type'      => 'full',
            ],
        ]);

        InvoiceItem::create([
            'invoice_id'   => $invoice->id,
            'item_name'    => 'Hostel Accommodation Fee',
            'unit_amount'  => $outstanding,
            'quantity'     => 1,
            'total_amount' => $outstanding,
        ]);

        // --------------------------------------
        // 4. REDIRECT TO PAYMENT GATEWAY
        // --------------------------------------
        return redirect()->route('hostel.payment', $invoice->id);
    }


    public function show(Invoice $invoice)
    {
        // --------------------------------------
        // 1. RESOLVE BILLABLE MODEL
        // --------------------------------------
        $billable = $invoice->billable;

        if (! $billable) {
            abort(404, 'Invoice is not linked to a valid billable record.');
        }

        // --------------------------------------
        // 2. VALIDATE INVOICE CATEGORY
        // --------------------------------------
        if ($invoice->category !== 'hostel') {
            abort(404, 'Invalid invoice type.');
        }

        // billable is HostelBooking model
        /** @var \App\Models\HostelBooking $booking */
        $booking = $billable->load(['course', 'college']);

        // --------------------------------------
        // 3. PAYER DETAILS (SINGLE, ALWAYS SELF)
        // --------------------------------------
        $payer = [
            'type'    => 'self',
            'name'    => $booking->full_name,
            'email'   => $booking->email,
            'phone'   => $booking->phone,
            'address' => null,
            'town'    => optional($booking->college)->name,
            'county'  => null,
        ];

        // --------------------------------------
        // 4. RETURN PAYMENT VIEW
        // --------------------------------------
        return view('public.payments.hostel_payment', compact(
            'invoice',
            'booking',
            'payer'
        ));
    }

}