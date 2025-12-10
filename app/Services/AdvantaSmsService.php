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
}

