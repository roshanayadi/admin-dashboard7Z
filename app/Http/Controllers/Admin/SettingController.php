<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('setting_value', 'setting_key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|string|max:10',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'sms_provider' => 'nullable|string|max:50',
            'sms_api_key' => 'nullable|string|max:255',
            'sms_sender_id' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                Setting::setValue($key, $value);
            }
        }

        ActivityLog::log('settings', 'update', 'Settings updated');

        return back()->with('success', 'Settings updated successfully.');
    }
}
