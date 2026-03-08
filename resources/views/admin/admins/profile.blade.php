@extends('layouts.admin')
@section('title', 'My Profile')

@section('content')
<form action="{{ route('admin.profile.update') }}" method="POST">
    @csrf @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-circle" style="color:var(--primary);margin-right:8px;"></i> My Profile</h3>
        </div>
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:20px;margin-bottom:30px;padding-bottom:24px;border-bottom:1px solid var(--gray-200);">
                <div style="width:72px;height:72px;background:var(--primary);color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;">
                    {{ strtoupper(substr($admin->full_name, 0, 1)) }}
                </div>
                <div>
                    <h2 style="font-size:22px;font-weight:700;">{{ $admin->full_name }}</h2>
                    <p style="color:var(--gray-500);">{{ '@' . $admin->username }} &middot; {{ ucfirst($admin->role) }}</p>
                    <p style="color:var(--gray-400);font-size:12px;">
                        Member since {{ $admin->created_at->format('M Y') }}
                        @if($admin->last_login)
                            &middot; Last login: {{ $admin->last_login->diffForHumans() }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $admin->full_name) }}" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                </div>
            </div>

            <hr style="margin:24px 0;border:none;border-top:1px solid var(--gray-200);">
            <h4 style="margin-bottom:16px;color:var(--gray-600);">Change Password</h4>

            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" minlength="8">
                </div>
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control">
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
