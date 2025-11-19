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

    /**
     * Initiate MPESA STK Push
     */
    public function pay(Application $application)
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

}
