@extends('layouts.admin')
@section('title', 'Edit Admin')

@section('content')
<form action="{{ route('admin.admins.update', $admin) }}" method="POST">
    @csrf @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3>Edit: {{ $admin->username }}</h3>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="{{ $admin->username }}" disabled>
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $admin->full_name) }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="admin" {{ $admin->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="editor" {{ $admin->role === 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ $admin->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $admin->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control" minlength="8">
                </div>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
