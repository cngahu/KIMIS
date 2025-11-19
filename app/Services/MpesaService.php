<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('mpesa.env') === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke'
            : 'https://api.safaricom.co.ke';
    }

    /**
     * Generate access token
     */
    public function token()
    {
        $response = Http::withBasicAuth(
            config('mpesa.consumer_key'),
            config('mpesa.consumer_secret')
        )
            ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

        return $response['access_token'];
    }

    /**
     * Initiate STK Push
     */
    public function stkPush($phone, $amount, $reference, $description)
    {
        $token = $this->token();

        $timestamp = date('YmdHis');
        $password = base64_encode(
            config('mpesa.shortcode') . config('mpesa.passkey') . $timestamp
        );

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', [
                "BusinessShortCode" => config('mpesa.shortcode'),
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => config('mpesa.shortcode'),
                "PhoneNumber" => $phone,
                "CallBackURL" => route('payment.callback'),
                "AccountReference" => $reference,
                "TransactionDesc" => $description,
            ]);

        Log::info('STK PUSH RESPONSE', $response->json());

        return $response->json();
    }
}
