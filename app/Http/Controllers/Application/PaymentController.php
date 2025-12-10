<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Invoice;
use App\Services\MpesaService;
use App\Services\PaymentService;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected MpesaService $mpesa;
    protected PaymentService $payment;

    public function __construct(MpesaService $mpesa, PaymentService $payment)
    {
        $this->mpesa = $mpesa;
        $this->payment = $payment;
    }
    public function success(Request $request)
    {
        // Optional Pesaflow callback values
        $invoiceNo = $request->input('billRefNumber');
        $status    = $request->input('status');

        return redirect()
            ->route('callback')
            ->with('success', 'Your payment has been submitted successfully. It will be verified shortly.');
    }


    /**
     * Initiate MPESA STK Push
     */
    public function Now(Application $application)
    {
        $invoice = $application->invoice;

        $res = $this->mpesa->stkPush(
            $application->phone,
            $invoice->amount,
            $invoice->invoice_number,
            "Payment for Course Application"
        );

        return view('public.stk_sent', compact('application', 'invoice'));
    }

    public function pay0(Application $application)
    {
        $invoice = $application->invoice;

        if (!$invoice) {
            abort(404, "Invoice not found for this application.");
        }



        // REQUIRED ECITIZEN / PESAFLOW PARAMETERS
        $apiClientID   = config('pesaflow.api_client_id');
        $serviceID     = config('pesaflow.service_id');
        $currency      = "KES";
        $billRefNumber = $invoice->invoice_number;
        $billDesc      = "KNEC Application Fee for {$application->full_name}";
        $clientName    = $application->full_name;
        $clientIDNo    = $application->id_number ?? 'NA';
        $clientPhone   = $application->phone;
        $clientEmail   = $application->email ?? 'noemail@applicant.com';
//        $amount        = $invoice->amount;
        $amount        = $invoice->amount;

        $callbackURL   = route('payments.success');        // After payment
        $notificationURL = route('payments.notify');       // Server-to-server notification

        // Generate Secure Hash
        $secret = config('pesaflow.secret_key');

        $stringToHash = $apiClientID .
            $amount .
            $serviceID .
            $clientIDNo .
            $currency .
            $billRefNumber .
            $billDesc .
            $clientName .
            $secret;

        $secureHash = base64_encode(
            hash_hmac('sha256', $stringToHash, $secret, true)
        );



        return view('payments.iframe', [
            'endpoint'        => config('pesaflow.endpoint'),  // iframev2.1.php URL
            'apiClientID'     => $apiClientID,
            'serviceID'       => $serviceID,
            'currency'        => $currency,
            'billRefNumber'   => $billRefNumber,
            'billDesc'        => $billDesc,
            'clientName'      => $clientName,
            'clientIDNumber'  => $clientIDNo,
            'clientEmail'     => $clientEmail,
            'clientMSISDN'    => $clientPhone,
            'callbackURL'     => $callbackURL,
            'notificationURL' => $notificationURL,
            'secureHash'      => $secureHash,
            'amountExpected'  => $amount,
            'format'          => 'iframe',
            'sendSTK'         => 'true',
            'pictureURL'      => $application->profile_photo_url ?? null,
        ]);
    }

    public function pay1(Application $application)
    {
        $invoice = $application->invoice;


        if (!$invoice) {
            abort(404, "Invoice not found for this application.");
        }
        $pictureURL = null;
        // REQUIRED PESAFLOW PARAMETERS
//        $apiClientID   = config('pesaflow.api_client_id');
//        $serviceID     = config('pesaflow.service_id');
        $apiClientID   = 35;
        $serviceID     = 234330;

        $currency      = "KES";
        $billRefNumber = $invoice->invoice_number;
        $billDesc      = "KNEC Application Fee for {$application->full_name}";
        $clientName    = $application->full_name;
        $clientIDNo    = $application->id_number ?? 'NA';

        // MUST remove "+" and any non-numeric chars
        $clientPhone   = preg_replace('/[^0-9]/', '', $application->phone);

        $clientEmail   = $application->email ?? 'noemail@applicant.com';
        $amount        = (int)$invoice->amount;  // integer format required for hashing

        $callbackURL     = route('payments.success');
        $notificationURL = route('payments.notify');

        // Correct hashing values
//        $secret = config('pesaflow.secret');
//        $key    = config('pesaflow.key');

        $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";
        $key = "Fhtuo4tuMATrqmtL";

        // EXACT ORDER REQUIRED BY PESAFLOW
        $stringToHash =
            $apiClientID .
            $amount .
            $serviceID .
            $clientIDNo .
            $currency .
            $billRefNumber .
            $billDesc .
            $clientName .
            $secret;

        // Use KEY as the HMAC signing key
        $secureHash = base64_encode(
//            hash_hmac('sha256', $stringToHash, $key, true)
            hash_hmac('sha256', $stringToHash, $key)

        );


        return view('payments.iframe', [
//            'endpoint'        => config('pesaflow.endpoint'),
            'endpoint'        => 'https://test.pesaflow.com/PaymentAPI/iframev2.1.php',
            'apiClientID'     => $apiClientID,
            'serviceID'       => $serviceID,
            'currency'        => $currency,
            'billRefNumber'   => $billRefNumber,
            'billDesc'        => $billDesc,
            'clientName'      => $clientName,
            'clientIDNumber'  => $clientIDNo,
            'clientEmail'     => $clientEmail,
            'clientMSISDN'    => $clientPhone,
            'callbackURL'     => $callbackURL,
            'notificationURL' => $notificationURL,
            'secureHash'      => $secureHash,
            'amountExpected'  => $amount,
            'format'          => 'iframe',
            'sendSTK'         => 'True', // Case-sensitive
//            'pictureURL'      => $pictureURL,
        ]);
    }
    public function pay2(Application $application)
    {
        $invoice = $application->invoice;

        if (!$invoice) {
            abort(404, "Invoice not found for this application.");
        }

        // --- PESAFLOW CREDENTIALS (STATIC FOR NOW) ---
        $apiClientID = "35";
        $serviceID   = "234330";

        $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";   // appended in string
        $key    = "Fhtuo4tuMATrqmtL";                 // HMAC signing key

        // --- CLIENT / BILL DETAILS ---
        $clientName   = $application->full_name;
        $clientIDNo   = $application->id_number ?? 'NA';
        $clientPhone  = preg_replace('/[^0-9]/', '', $application->phone);
        $clientEmail  = $application->email ?? 'noemail@applicant.com';

        $currency      = "KES";
        $billRefNumber = $invoice->invoice_number;
        $billDesc      = "KNEC Application Fee for {$clientName}";

        $amount        = (int)$invoice->amount;

        // CALLBACK URLs
        $callbackURL     = route('payments.success');
        $notificationURL = route('payments.notify');

        // --- BUILD HASH ---
        $dataString =
            $apiClientID .
            $amount .
            $serviceID .
            $clientIDNo .
            $currency .
            $billRefNumber .
            $billDesc .
            $clientName .
            $secret;

        $hash = hash_hmac('sha256', $dataString, $key);
        $secureHash = base64_encode($hash);

        return view('payments.iframe', [
            'endpoint'        => 'https://test.pesaflow.com/PaymentAPI/iframev2.1.php',
            'apiClientID'     => $apiClientID,
            'serviceID'       => $serviceID,
            'billDesc'        => $billDesc,
            'currency'        => $currency,
            'billRefNumber'   => $billRefNumber,
            'clientMSISDN'    => $clientPhone,
            'clientName'      => $clientName,
            'clientIDNumber'  => $clientIDNo,
            'clientEmail'     => $clientEmail,
            'callbackURL'     => $callbackURL,
            'notificationURL' => $notificationURL,
            'amountExpected'  => $amount,
            'secureHash'      => $secureHash,
            'format'          => 'iframe',
            'sendSTK'         => 'True'
        ]);
    }
    public function pay($id)
    {

        $application = Application::with('invoice', 'course')->findOrFail($id);

        $invoice = $application->invoice;
        $meta = $application->metadata ?? [];

        // ------------ CONFIG (Move these to env later) -----------------
        $apiClientID = env('PF_CLIENT_ID', '35');
        $secret      = env('PF_SECRET', '7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw');
        $key         = env('PF_KEY', 'Fhtuo4tuMATrqmtL');
        $serviceID   = env('PF_SERVICE_ID', '234330');
        $callbackURL = route('payments.success'); // you can define this
        $notificationURL = route('payments.notify');
        // ---------------------------------------------------------------

        $amountExpected = $invoice->amount;

        // Dynamic BillRefNumber:
        $billRefNumber = $invoice->invoice_number;

        $billDesc  = $application->course->course_name ?? "Application Payment";
        $clientName = $application->full_name;
        $clientEmail = $application->email;
        $clientMSISDN = $application->phone;
        $clientIDNumber = $application->id_number ?? "A12345678";
        $currency = "KES";

        $serviceID=234330;
        $invoice = $application->invoice;

        $total=$invoice->amount;
        $curl = curl_init();



//        $callBackURLOnSuccess = 'https://portal.pck.go.ke/applicant/dashboard';
        route('payments.success');
        $notificationURL = "https://uat.kims.kihbt.ac.ke//api/pesaflow/confirm";

        $apiClientID = '580';

//        $amountExpected = $invoice->amount;
        $amountExpected = 1;



        $currency = "KES";

        $billRefNumber =$invoice->invoice_number;




        $secret = "7UiF90LT3RkIkala3FAxcwzYEXiy8Ztw";
        $key = "Fhtuo4tuMATrqmtL";


        $data_string = "$apiClientID"."$amountExpected"."$serviceID"."$clientIDNumber"."$currency"."$billRefNumber"."$billDesc"     . "$clientName"."$secret";
        // Step 2 hash the values
        $hash = hash_hmac('sha256', $data_string, $key);
        // Step 3 encode
        $my_secureHash = base64_encode($hash);
        return view('public.payment-iframe', [
            'secureHash' => $my_secureHash,
            'my_secureHash' => $my_secureHash,
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
            'application' => $application,
        ]);
    }
public function payEcitizen($id)
{
    dd('here');
}

    /**
     * Callback from MPESA (POST)
     */
    public function callback(Request $request)
    {
        Log::info('MPESA CALLBACK', $request->all());

        $result = $request->input('Body.stkCallback');

        $merchantRequestID = $result['MerchantRequestID'] ?? null;
        $checkoutRequestID = $result['CheckoutRequestID'] ?? null;
        $resultCode = $result['ResultCode'];

        // Payment failed
        if ($resultCode != 0) {
            return response()->json(['message' => 'Payment Failed'], 200);
        }

        $callbackItems = collect($result['CallbackMetadata']['Item']);

        $amount = $callbackItems->where('Name', 'Amount')->first()['Value'];
        $mpesaReceipt = $callbackItems->where('Name', 'MpesaReceiptNumber')->first()['Value'];
        $phone = $callbackItems->where('Name', 'PhoneNumber')->first()['Value'];
        $ref = $callbackItems->where('Name', 'AccountReference')->first()['Value'];

        // Find invoice
        $invoice = Invoice::where('invoice_number', $ref)->first();

        if ($invoice) {
            $this->payment->markPaid($invoice, $mpesaReceipt);
        }

        return response()->json(['message' => 'Payment Processed'], 200);
    }


    public function simulate(Invoice $invoice)
    {
        if (app()->environment('production')) {
            abort(403, "Not allowed in production");
        }

        // fake mpesa reference
        $fakeRef = 'SIM-' . strtoupper(Str::random(8));

        // mark invoice paid using payment service
        $this->payment->markPaid($invoice, $fakeRef);

        return redirect()
            ->route('applications.payment', $invoice->application_id)
            ->with('success', 'Simulated payment applied successfully!');
    }
    public function simulate0(Invoice $invoice)
    {
        if (app()->environment('production')) {
            abort(403, "Not allowed in production");
        }

        // fake mpesa reference
        $fakeRef = 'SIM-' . strtoupper(Str::random(8));

        // simulated amount paid (usually the invoice amount)
        $simulatedAmountPaid = $invoice->amount;

        // mark invoice paid using payment service
        $this->payment->markPaid($invoice, $fakeRef, $simulatedAmountPaid);

        return redirect()
            ->route('applications.payment', $invoice->application_id)
            ->with('success', 'Simulated payment applied successfully!');
    }

}
