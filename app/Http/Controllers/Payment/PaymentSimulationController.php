<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payments\PesaFlowConfirmationController;
use Illuminate\Http\Request;

use App\Models\Invoice;
class PaymentSimulationController extends Controller
{
    //

    public function simulate(Invoice $invoice)
    {
        dd('Simulation disabled in demo');
        // Fake payload structure similar to eCitizen callback
        $fakePayload = [
            "client_invoice_ref" => $invoice->invoice_number,
            "status"             => "settled",
            "payment_channel"    => "SIMULATED",
            "invoice_amount"     => $invoice->amount+50,
            "invoice_number"     => "SIM-" . strtoupper(str()->random(6)),
            "amount_paid"        => $invoice->amount,
            "payment_reference"  => [
                [
                    "payment_reference" => "SIMREF-" . strtoupper(str()->random(6)),
                    "payment_date"      => now()->toDateTimeString()
                ]
            ]
        ];

        // Call your existing callback logic directly
        app(PesaFlowConfirmationController::class)
            ->index(new Request($fakePayload));

        return back()->with('success', "Invoice {$invoice->invoice_number} simulated as PAID.");
    }
}
