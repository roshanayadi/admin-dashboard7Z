<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function send(string $to, string $subject, string $body): array
    {
        try {
            // Dynamic SMTP config from settings
            $host = Setting::getValue('smtp_host', config('mail.mailers.smtp.host'));
            $port = Setting::getValue('smtp_port', config('mail.mailers.smtp.port'));
            $username = Setting::getValue('smtp_username', config('mail.mailers.smtp.username'));
            $password = Setting::getValue('smtp_password', config('mail.mailers.smtp.password'));

            config([
                'mail.mailers.smtp.host' => $host,
                'mail.mailers.smtp.port' => $port,
                'mail.mailers.smtp.username' => $username,
                'mail.mailers.smtp.password' => $password,
                'mail.from.address' => $username,
            ]);

            Mail::raw($body, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });

            return ['success' => true, 'message' => 'Sent'];
        } catch (\Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Email error: ' . $e->getMessage()];
        }
    }
}
