<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    //

    public function pdf(Invoice $invoice)
    {
        $invoice->load('billable');

        $billable = $invoice->billable;
        $application = $billable->load('participants');
        $participants = $application->participants;

        $payer = $this->resolvePayer($application); // you can reuse earlier logic

        $pdf = Pdf::loadView('public.payments.invoice-pdf', [
            'invoice' => $invoice,
            'application' => $application,
            'participants' => $participants,
            'payer' => $payer,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-'.$invoice->invoice_number.'.pdf');
    }

    public function payByInvoice(Invoice $invoice)

    {

        // Load the billable model (Application OR ShortTrainingApplication OR future modules)
        $billable = $invoice->billable;

        if (! $billable) {
            abort(404, "Invoice is not linked to a valid record.");
        }

        // -----------------------------
        // 1. Resolve payer details
        // -----------------------------
        $clientName = null;
        $clientEmail = null;
        $clientMSISDN = null;
        $clientIDNumber = "A12345678"; // fallback

        $billDesc = "Payment"; // fallback description

        // Handle by category
        switch ($invoice->category) {

            case 'application_fee':
            case 'knec_application':
            case 'course_fee':
            case 'admission_fee':
                // Long-course Application model
                $app = $billable;

                $clientName    = $app->full_name;
                $clientEmail   = $app->email;
                $clientMSISDN  = $app->phone;
                $clientIDNumber = $app->id_number ?? "A12345678";

                $billDesc = $app->course->course_name ?? "Application Payment";
                break;

//            case 'short_course':
//                // ShortTrainingApplication model
//                $short = $billable;
//
//                $participants = $short->participants;
//
//                if ($short->financier === 'employer') {
//                    $clientName   = $short->employer_name;
//                    $clientEmail  = $short->employer_email;
//                    $clientMSISDN = $short->employer_phone;
//                } else {
//                    $first = $participants->first();
//                    $clientName   = $first->full_name;
//                    $clientEmail  = $first->email;
//                    $clientMSISDN = $first->phone;
//                    $clientIDNumber = $first->id_no ?? "A12345678";
//                }
//
//                $training = \App\Models\Training::find($short->training_id);
//
//                $billDesc = "Short Course: " .
//                    optional($training->course)->course_name .
//                    " - " . ($training->schedule_label ?? "");
//                break;
            case 'short_course':
                // ShortTrainingApplication model
                $short = $billable;

                $participants = $short->participants;

                if ($short->financier === 'employer') {
                    $clientName   = $short->employer_name;
                    $clientEmail  = $short->employer_email;
                    $clientMSISDN = $short->employer_phone;
                } else {
                    $first = $participants->first();
                    $clientName      = $first->full_name;
                    $clientEmail     = $first->email;
                    $clientMSISDN    = $first->phone;
                    $clientIDNumber  = $first->id_no ?? "A12345678";
                }

                $training = \App\Models\Training::find($short->training_id);

                // 🔑 SERVICE CODE SELECTION BASED ON COLLEGE
                if ($training) {
                    if (in_array($training->college_id, [1, 2])) {
                        $serviceID = '15248134';
                    } elseif ($training->college_id == 3) {
                        $serviceID = '15248135';
                    }
                }

                $billDesc = "Short Course: " .
                    optional($training->course)->course_name .
                    " - " . ($training->schedule_label ?? "");
                break;


            default:
                $billDesc = "Invoice Payment";
                break;
        }

        // -----------------------------
        // 2. Payment configuration
        // -----------------------------
//        $apiClientID       = env('PF_CLIENT_ID', '580');
//        $secret            = env('PF_SECRET', '');
//        $key               = env('PF_KEY', '');
//        $serviceID         = env('PF_SERVICE_ID', '234330');

        $apiClientID = env('PF_CLIENT_ID', '145');
        $secret      = env('PF_SECRET', 'dn3ngJmaoGfMK8+NqIFns8b06a8bMARI');
        $key         = env('PF_KEY', 'jVMRIYcb456ERAk9');

        $callBackURLOnSuccess = route('payments.success');
//        $notificationURL   = env('PF_NOTIFICATION_URL', "https://uat.kims.kihbt.ac.ke/api/pesaflow/confirm");
        $notificationURL     = route('payments.notify');

        $amountExpected    = $invoice->amount; // REAL AMOUNT
//        $amountExpected    = 1; // REAL AMOUNT
        $billRefNumber     = $invoice->invoice_number;
        $currency          = "KES";

        // -----------------------------
        // 3. Build Secure Hash
        // -----------------------------
        $data_string = $apiClientID
            . $amountExpected
            . $serviceID
            . $clientIDNumber
            . $currency
            . $billRefNumber
            . $billDesc
            . $clientName
            . $secret;

        $hash = hash_hmac('sha256', $data_string, $key);
        $secureHash = base64_encode($hash);

//        dd($notificationURL,$callBackURLOnSuccess);
        // -----------------------------
        // 4. Return payment iframe
        // -----------------------------
        return view('public.payment-iframe', [
            'my_secureHash'            => $secureHash,
            'apiClientID'           => $apiClientID,
            'serviceID'             => $serviceID,
            'billDesc'              => $billDesc,
            'billRefNumber'         => $billRefNumber,
            'clientMSISDN'          => $clientMSISDN,
            'clientName'            => $clientName,
            'clientIDNumber'        => $clientIDNumber,
            'clientEmail'           => $clientEmail,
            'callBackURLOnSuccess'  => $callBackURLOnSuccess,
            'notificationURL'       => $notificationURL,
            'amountExpected'        => $amountExpected,
            'invoice'               => $invoice,
            'billable'              => $billable, // dynamic source
        ]);
    }

}
