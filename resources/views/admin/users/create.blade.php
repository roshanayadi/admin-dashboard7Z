@extends('layouts.admin')
@section('title', 'Add Member')

@section('content')
<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>Add New Member</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>
                <div class="form-group">
                    <label>Phone *</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Member
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
