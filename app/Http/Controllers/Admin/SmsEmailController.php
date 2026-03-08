<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SmsDetail;
use App\Models\SmsHistory;
use App\Models\User;
use App\Services\EmailService;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsEmailController extends Controller
{
    public function index()
    {
        $history = SmsHistory::with('details')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $users = User::active()->get();

        return view('admin.sms-email.index', compact('history', 'users'));
    }

    public function sendSms(Request $request, SmsService $smsService)
    {
        $validated = $request->validate([
            'recipients' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $recipients = array_map('trim', explode(',', $validated['recipients']));

        $history = SmsHistory::create([
            'type' => 'phone',
            'message' => $validated['message'],
            'recipient_count' => count($recipients),
            'status' => 'pending',
        ]);

        $successCount = 0;
        $failedCount = 0;

        foreach ($recipients as $recipient) {
            $result = $smsService->send($recipient, $validated['message']);

            SmsDetail::create([
                'sms_history_id' => $history->id,
                'recipient' => $recipient,
                'status' => $result['success'] ? 'sent' : 'failed',
                'message' => $result['message'],
            ]);

            $result['success'] ? $successCount++ : $failedCount++;
        }

        $history->update([
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'status' => $failedCount === count($recipients) ? 'failed' : 'completed',
        ]);

        ActivityLog::log('sms', 'send', "SMS sent to {$successCount}/{$history->recipient_count} recipients");

        return back()->with('success', "SMS sent: {$successCount} success, {$failedCount} failed.");
    }

    public function sendEmail(Request $request, EmailService $emailService)
    {
        $validated = $request->validate([
            'recipients' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $recipients = array_map('trim', explode(',', $validated['recipients']));

        $history = SmsHistory::create([
            'type' => 'email',
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'recipient_count' => count($recipients),
            'status' => 'pending',
        ]);

        $successCount = 0;
        $failedCount = 0;

        foreach ($recipients as $recipient) {
            $result = $emailService->send($recipient, $validated['subject'], $validated['message']);

            SmsDetail::create([
                'sms_history_id' => $history->id,
                'recipient' => $recipient,
                'status' => $result['success'] ? 'sent' : 'failed',
                'message' => $result['message'],
            ]);

            $result['success'] ? $successCount++ : $failedCount++;
        }

        $history->update([
            'success_count' => $successCount,
            'failed_count' => $failedCount,
            'status' => $failedCount === count($recipients) ? 'failed' : 'completed',
        ]);

        ActivityLog::log('email', 'send', "Email sent to {$successCount}/{$history->recipient_count} recipients");

        return back()->with('success', "Email sent: {$successCount} success, {$failedCount} failed.");
    }
}
