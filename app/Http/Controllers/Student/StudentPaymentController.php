<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Admission;
use App\Models\StudentCycleRegistration;

class StudentPaymentController extends Controller
{
    public function paymentIframe(Invoice $invoice)
    {
        // -------------------------------------------------
        // Security: ensure invoice belongs to logged-in user
        // -------------------------------------------------
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('student.dashboard')
                ->with('success', 'Invoice already paid.');
        }

        // -------------------------------------------------
        // Resolve context via polymorphism
        // -------------------------------------------------
        $clientName = auth()->user()->firstname;
        $clientEmail = auth()->user()->email;
        $clientMSISDN = auth()->user()->phone;
        $clientIDNumber = auth()->user()->national_id ?? 'A12345678';

        $billDesc = 'Student Fee Payment';

        if ($invoice->billable_type === Admission::class) {
            $admission = $invoice->billable;
            $application = $admission->application;

            $billDesc = 'Admission Fee – ' . ($application->full_name ?? '');
            $clientName = $application->full_name ?? $clientName;
            $clientEmail = $application->email ?? $clientEmail;
            $clientMSISDN = $application->phone ?? $clientMSISDN;
            $clientIDNumber = $application->id_number ?? $clientIDNumber;
        }

//        if ($invoice->billable_type === StudentCycleRegistration::class) {
//            $registration = $invoice->billable;
//
//            $billDesc = "Tuition Fee – {$registration->cycle_term} {$registration->cycle_year}";
//        }

        $campusId = null;

        if ($invoice->billable_type === Admission::class) {
            $admission = $invoice->billable;
            $application = $admission->application;

            $billDesc = 'Admission Fee – ' . ($application->full_name ?? '');
            $clientName = $application->full_name ?? $clientName;
            $clientEmail = $application->email ?? $clientEmail;
            $clientMSISDN = $application->phone ?? $clientMSISDN;
            $clientIDNumber = $application->id_number ?? $clientIDNumber;

            // ✅ Campus from admission
            $campusId = $admission->campus_id ?? null;
        }

        if ($invoice->billable_type === StudentCycleRegistration::class) {
            $registration = $invoice->billable;

            $billDesc = "Tuition Fee – {$registration->cycle_term} {$registration->cycle_year}";

            // ✅ Campus from enrollment
            $campusId = $registration->enrollment->campus_id ?? null;
        }



        // -------------------------------------------------
        // Pesaflow / eCitizen config test
        // -------------------------------------------------
//        $apiClientID = env('PF_CLIENT_ID', '35');
//        $secret      = env('PF_SECRET', '7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw');
//        $key         = env('PF_KEY', 'Fhtuo4tuMATrqmtL');
//        $serviceID   = env('PF_SERVICE_ID', '234330');




        // -------------------------------------------------
        // Pesaflow / eCitizen config live
        // -------------------------------------------------
        $apiClientID = env('PF_CLIENT_ID', '145');
        $secret      = env('PF_SECRET', 'dn3ngJmaoGfMK8+NqIFns8b06a8bMARI');
        $key         = env('PF_KEY', 'jVMRIYcb456ERAk9');
//        $serviceID   = env('PF_SERVICE_ID', '234330');

        if (!$campusId) {
            abort(500, 'Unable to resolve campus for payment.');
        }

        $serviceID = ($campusId == 3)
            ? '15248135'
            : '15248134';

        $amountExpected = $invoice->amount;
        $billRefNumber  = $invoice->invoice_number;
        $currency       = 'KES';

        $callBackURLOnSuccess = route('payments.success');
        $notificationURL     = route('payments.notify');
//        $notificationURL = "https://kims.kihbt.ac.ke/api/pesaflow/confirm";

        // -------------------------------------------------
        // Generate secure hash
        // -------------------------------------------------
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

        return view('student.admission.payment.iframe', [
            'my_secureHash' => $secureHash,
            'apiClientID' => $apiClientID,
            'serviceID' => $serviceID,
            'billDesc' => $billDesc,
            'billRefNumber' => $billRefNumber,
            'clientMSISDN' => $clientMSISDN,
            'clientName' => $clientName,
            'clientIDNumber' => $clientIDNumber,
            'clientEmail' => $clientEmail,
            'callBackURLOnSuccess' => $callBackURLOnSuccess,
            'notificationURL' => $notificationURL,
            'amountExpected' => $amountExpected,
            'invoice' => $invoice,
        ]);
    }
}
