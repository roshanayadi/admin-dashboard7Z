@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf @method('PUT')

    <!-- SMTP Settings -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-envelope" style="color:var(--primary);margin-right:8px;"></i> SMTP / Email Settings</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>SMTP Host</label>
                    <input type="text" name="smtp_host" class="form-control" value="{{ $settings['smtp_host'] ?? '' }}" placeholder="smtp.gmail.com">
                </div>
                <div class="form-group">
                    <label>SMTP Port</label>
                    <input type="text" name="smtp_port" class="form-control" value="{{ $settings['smtp_port'] ?? '' }}" placeholder="587">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>SMTP Username</label>
                    <input type="text" name="smtp_username" class="form-control" value="{{ $settings['smtp_username'] ?? '' }}" placeholder="your@email.com">
                </div>
                <div class="form-group">
                    <label>SMTP Password</label>
                    <input type="password" name="smtp_password" class="form-control" value="{{ $settings['smtp_password'] ?? '' }}" placeholder="••••••••">
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Settings -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-sms" style="color:var(--accent);margin-right:8px;"></i> SMS Settings</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>SMS Provider</label>
                    <select name="sms_provider" class="form-control">
                        <option value="sparrow" {{ ($settings['sms_provider'] ?? '') === 'sparrow' ? 'selected' : '' }}>Sparrow SMS</option>
                        <option value="custom" {{ ($settings['sms_provider'] ?? '') === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sender ID</label>
                    <input type="text" name="sms_sender_id" class="form-control" value="{{ $settings['sms_sender_id'] ?? '' }}" placeholder="TheAlert">
                </div>
            </div>
            <div class="form-group">
                <label>SMS API Key</label>
                <input type="text" name="sms_api_key" class="form-control" value="{{ $settings['sms_api_key'] ?? '' }}" placeholder="Your API key">
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Settings
        </button>
    </div>
</form>
@endsection
