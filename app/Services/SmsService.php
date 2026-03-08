<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function send(string $phone, string $message): array
    {
        $apiKey = Setting::getValue('sms_api_key');
        $senderId = Setting::getValue('sms_sender_id', 'TheAlert');

        if (!$apiKey) {
            return ['success' => false, 'message' => 'SMS API key not configured'];
        }

        try {
            $response = Http::get('http://api.sparrowsms.com/v2/sms/', [
                'token' => $apiKey,
                'from' => $senderId,
                'to' => $phone,
                'text' => $message,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['response_code']) && $data['response_code'] === 200) {
                    return ['success' => true, 'message' => "SMS sent to {$phone}"];
                }
                return ['success' => false, 'message' => $data['response'] ?? 'Unknown SMS error'];
            }

            return ['success' => false, 'message' => 'SMS API error: HTTP ' . $response->status()];
        } catch (\Exception $e) {
            Log::error('SMS send failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'SMS error: ' . $e->getMessage()];
        }
    }
}
