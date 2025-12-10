<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PesaFlowConfirmationController extends Controller
{
    //

    public function index0(Request $request)
    {


        $data = $request->all();


        // Extract fields from the response
        $clientInvoiceRef = $data['client_invoice_ref'];
        $status = $data['status'];
        $paymentChannel = $data['payment_channel'];
        $amountPaid = $data['amount_paid'];
        $paymentReference = $data['payment_reference'][0] ?? [];
        $receivedHash = $data['secure_hash'];


        // Find the invoice by client_invoice_ref
        $invoice = invoice::where('invoice_no', $clientInvoiceRef)->first();

        if ($invoice) {
            if ($status === 'settled') {
                // Update the invoice status and other details
                $invoice->update([
                    'status' => 'Paid',
                    'payment_channel' => $paymentChannel,
                    'payment_reference' => $paymentReference['payment_reference'] ?? null,
                    'payment_date' => $paymentReference['payment_date'] ?? null,
                    'currency' => $paymentReference['currency'] ?? null,
                    'amount_paid' => $amountPaid,
                ]);



            }
        }

        // Respond with success or acknowledgment
        return response()->json(['message' => 'Notification processed successfully'], 200);
    }

    public function index1(Request $request)
    {
        $data = $request->all();

        // Extract fields safely
        $clientInvoiceRef = $data['client_invoice_ref'] ?? null;
        $status           = $data['status'] ?? null;
        $paymentChannel   = $data['payment_channel'] ?? null;
        $amountPaid       = $data['amount_paid'] ?? null;
        $paymentReference = $data['payment_reference'][0] ?? [];
        $receivedHash     = $data['secure_hash'] ?? null;

        // Find matching invoice
        $invoice = Invoice::where('invoice_number', $clientInvoiceRef)->first();

        if ($invoice)
        {
            // Merge incoming notification into metadata
            $existingMeta = $invoice->metadata ?? [];
            $existingMeta['ecitizen_notification'][] = [
                'received_at' => now()->toDateTimeString(),
                'payload'     => $data,
            ];

            // Update invoice status if settled
            if ($status === 'settled') {

                $invoice->update([
                    'status'            => 'paid',
//                    'payment_channel'   => $paymentChannel,
                    'gateway_reference' => $paymentReference['payment_reference'] ?? null,
                    'paid_at'           => $paymentReference['payment_date'] ?? now(),
                    'amount_paid'       => $amountPaid,
                    'metadata'          => $existingMeta, // store notification here
                ]);
            }
            else {
                // Still log failed/pending notifications
                $invoice->update([
                    'metadata' => $existingMeta,
                ]);
            }
        }

        // Respond SUCCESS to eCitizen
        return response()->json([
            'message' => 'Notification processed successfully'
        ], 200);
    }
    public function index2(Request $request)
    {
        $data = $request->all();

        // Extract values safely
        $clientInvoiceRef = $data['client_invoice_ref'] ?? null;
        $status           = $data['status'] ?? null;
        $paymentChannel   = $data['payment_channel'] ?? null;
        $amountPaid       = $data['amount_paid'] ?? null;
        $paymentReference = $data['payment_reference'][0] ?? [];
        $receivedHash     = $data['secure_hash'] ?? null;

        // Find invoice by client ref
        $invoice = Invoice::where('invoice_number', $clientInvoiceRef)->first();

        if ($invoice)
        {
            // Load existing notifications
            $existingNotifications = $invoice->ecitizen_notification ?? [];

            // Append new notification packet
            $existingNotifications[] = [
                'received_at' => now()->toDateTimeString(),
                'payload'     => $data,
            ];

            // Always save notification log, even if pending
            $invoice->ecitizen_notification = $existingNotifications;
            $invoice->save();

            // Update invoice with important extracted fields
            $invoice->update([
                'invoice_amount'          => $data['invoice_amount'] ?? null,
                'payment_channel'         => $paymentChannel,
                'ecitizen_invoice_number' => $data['invoice_number'] ?? null,
            ]);

            // If payment is confirmed
            if ($status === 'settled') {

                $invoice->update([
                    'status'            => 'paid',
                    'gateway_reference' => $paymentReference['payment_reference'] ?? null,
                    'paid_at'           => $paymentReference['payment_date'] ?? now(),
                    'amount_paid'       => $amountPaid,
                ]);
            }
        }

        // Success response to eCitizen
        return response()->json([
            'message' => 'Notification processed successfully'
        ], 200);
    }
    public function index(Request $request)
    {
        // Default Laravel parsing
        $data = $request->all();

        // If invoice fields missing, decode raw JSON body
        if (!isset($data['invoice_amount']) || !isset($data['invoice_number'])) {
            $raw = $request->getContent();
            $json = json_decode($raw, true);

            if (is_array($json)) {
                $data = array_merge($data, $json);
            }
        }

        $clientInvoiceRef  = $data['client_invoice_ref'] ?? null;
        $status            = $data['status'] ?? null;
        $paymentChannel    = $data['payment_channel'] ?? null;
        $invoiceAmount     = $data['invoice_amount'] ?? null;
        $eciInvoiceNumber  = $data['invoice_number'] ?? null;
        $amountPaid        = $data['amount_paid'] ?? null;
        $paymentReference  = $data['payment_reference'][0] ?? [];

        $invoice = Invoice::where('invoice_number', $clientInvoiceRef)->first();

        if ($invoice) {

            // Append notification
            $existing = $invoice->ecitizen_notification ?? [];
            $existing[] = [
                'received_at' => now()->toDateTimeString(),
                'payload'     => $data,
            ];

            // Save notification log
            $invoice->update([
                'ecitizen_notification' => $existing,
            ]);

            // Save structured fields
            $invoice->update([
                'invoice_amount'          => $invoiceAmount,
                'payment_channel'         => $paymentChannel,
                'ecitizen_invoice_number' => $eciInvoiceNumber,
            ]);

            // Mark paid
            if ($status === 'settled') {
                $invoice->update([
                    'status'            => 'paid',
                    'amount_paid'       => $amountPaid,
                    'gateway_reference' => $paymentReference['payment_reference'] ?? null,
                    'paid_at'           => $paymentReference['payment_date'] ?? now(),
                ]);
            }
        }

        return response()->json(['message' => 'Notification processed successfully'], 200);
    }

}
