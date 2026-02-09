<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\HostelBooking;
use Barryvdh\DomPDF\Facade\Pdf;

class HostelInvoiceController extends Controller
{
    public function pdf(Invoice $invoice)
    {
        $invoice->load('billable');

        if ($invoice->category !== 'hostel') {
            abort(404, 'Invalid hostel invoice.');
        }

        /** @var HostelBooking $booking */
        $booking = $invoice->billable->load(['course', 'college']);

        $payer = [
            'name' => $booking->full_name,
            'email' => $booking->email,
            'phone' => $booking->phone,
        ];

        $pdf = Pdf::loadView('public.payments.hostel-invoice-pdf', [
            'invoice' => $invoice,
            'booking' => $booking,
            'payer' => $payer,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Hostel-Invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function payByInvoice(Invoice $invoice)
    {
        $invoice->load('billable');

        if ($invoice->category !== 'hostel') {
            abort(404, 'Invalid hostel invoice.');
        }

        /** @var HostelBooking $booking */
        $booking = $invoice->billable->load(['course', 'college']);

        if (! $booking) {
            abort(404, 'Hostel booking not found.');
        }

        // --------------------------------------
        // 1. Resolve payer
        // --------------------------------------
        $clientName     = $booking->full_name;
        $clientEmail    = $booking->email;
        $clientMSISDN   = $booking->phone;
        $clientIDNumber = $booking->id_number ?? 'A12345678';

        $billDesc = 'Hostel Accommodation - ' .
            optional($booking->course)->course_name;

        // --------------------------------------
        // 2. SERVICE ID (BASED ON COURSE COLLEGE)
        // --------------------------------------
        $serviceID = null;

        $collegeId = optional($booking->course)->college_id;

        if (in_array($collegeId, [1, 2])) {
            $serviceID = '15248137';
        } else {
            $serviceID = '15248139';
        }

        // --------------------------------------
        // 3. Payment configuration
        // --------------------------------------
        $apiClientID = env('PF_CLIENT_ID', '145');
        $secret      = env('PF_SECRET', 'dn3ngJmaoGfMK8+NqIFns8b06a8bMARI');
        $key         = env('PF_KEY', 'jVMRIYcb456ERAk9');

        $callBackURLOnSuccess = route('payments.success');
        $notificationURL     = route('payments.notify');

        $amountExpected  = $invoice->amount;
        $billRefNumber   = $invoice->invoice_number;
        $currency        = 'KES';

        // --------------------------------------
        // 4. Secure hash
        // --------------------------------------
        $dataString =
            $apiClientID .
            $amountExpected .
            $serviceID .
            $clientIDNumber .
            $currency .
            $billRefNumber .
            $billDesc .
            $clientName .
            $secret;

        $hash       = hash_hmac('sha256', $dataString, $key);
        $secureHash = base64_encode($hash);

        // --------------------------------------
        // 5. Return payment iframe
        // --------------------------------------
        return view('public.payment-iframe', [
            'my_secureHash'           => $secureHash,
            'apiClientID'             => $apiClientID,
            'serviceID'               => $serviceID,
            'billDesc'                => $billDesc,
            'billRefNumber'           => $billRefNumber,
            'clientMSISDN'            => $clientMSISDN,
            'clientName'              => $clientName,
            'clientIDNumber'          => $clientIDNumber,
            'clientEmail'             => $clientEmail,
            'callBackURLOnSuccess'    => $callBackURLOnSuccess,
            'notificationURL'         => $notificationURL,
            'amountExpected'          => $amountExpected,
            'invoice'                 => $invoice,
            'billable'                => $booking,
        ]);
    }


}
