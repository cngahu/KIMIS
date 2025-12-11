<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class AdvantaSmsService
{
    public function sendSms(string $mobile, string $message): array
    {
        $baseUrl = config('services.advanta.base_url');
        $apiKey = config('services.advanta.api_key');
        $partnerId = config('services.advanta.partner_id');
        $shortcode = config('services.advanta.sender_id');

        $url = rtrim($baseUrl, '/') . '/api/services/sendsms/';

        $payload = [
            'apikey' => $apiKey,
            'partnerID' => $partnerId,
            'mobile' => $mobile,
            'message' => $message,
            'shortcode' => $shortcode,
            'pass_type' => 'plain',
        ];

        $response = Http::asJson()->post($url, $payload);

        if ($response->failed()) {
            throw new \RuntimeException('Advanta SMS error: ' . $response->body());
        }

        return $response->json();
    }

//    public function sendSms(string $mobile, string $message): array
//    {
//        $baseUrl = config('services.advanta.base_url');
//        $apiKey = config('services.advanta.api_key');
//        $partnerId = config('services.advanta.partner_id');
//        $shortcode = config('services.advanta.sender_id');
//
//        // ✅ Normalise Kenyan numbers: 07XXXXXXXX → 2547XXXXXXXX
//        $mobile = $this->normalizeMsisdn($mobile);
//
//        $url = rtrim($baseUrl, '/') . '/api/services/sendsms/';
//
//        $payload = [
//            'apikey' => $apiKey,
//            'partnerID' => $partnerId,
//            'mobile' => $mobile,
//            'message' => $message,
//            'shortcode' => $shortcode,
//            'pass_type' => 'plain',
//        ];
//
//        Log::info('Sending OTP via Advanta', $payload);
//
//        $response = Http::asJson()->post($url, $payload);
//
//        if ($response->failed()) {
//            Log::error('Advanta SMS failed', [
//                'status' => $response->status(),
//                'body' => $response->body(),
//            ]);
//
//            throw new \RuntimeException('Advanta SMS error: ' . $response->body());
//        }
//
//        return $response->json();
//    }

    /**
     * Normalize MSISDN to 2547XXXXXXXX for Kenyan numbers.
     */
    protected function normalizeMsisdn(string $mobile): string
    {
        $mobile = preg_replace('/\s+/', '', $mobile); // remove spaces

        // 07XXXXXXXX → 2547XXXXXXXX
        if (preg_match('/^0[17]\d{8}$/', $mobile)) {
            return '254' . substr($mobile, 1);
        }

        // +2547XXXXXXXX → 2547XXXXXXXX
        if (str_starts_with($mobile, '+254')) {
            return substr($mobile, 1);
        }

        return $mobile; // assume already correct
    }

}

