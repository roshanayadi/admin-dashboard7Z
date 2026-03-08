@extends('layouts.admin')
@section('title', 'View Contact')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Message from {{ $contact->name }}</h3>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div class="form-group">
                <label>Name</label>
                <p>{{ $contact->name }}</p>
            </div>
            <div class="form-group">
                <label>Email</label>
                <p>{{ $contact->email }}</p>
            </div>
        </div>
        <div class="form-group">
            <label>Subject</label>
            <p>{{ $contact->subject }}</p>
        </div>
        <div class="form-group">
            <label>Message</label>
            <div style="background:var(--gray-50);padding:16px;border-radius:8px;white-space:pre-wrap;">{{ $contact->message }}</div>
        </div>
        <div style="font-size:12px;color:var(--gray-400);margin-top:12px;">
            Received: {{ $contact->created_at->format('M d, Y h:i A') }}
        </div>
    </div>
</div>
@endsection
