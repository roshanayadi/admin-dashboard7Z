@extends('layouts.admin')
@section('title', 'Add Admin')

@section('content')
<form action="{{ route('admin.admins.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>Add New Admin</h3>
            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Role *</label>
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <div class="form-group">
                    <label>Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Admin
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
