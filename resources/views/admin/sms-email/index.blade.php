@extends('layouts.admin')
@section('title', 'SMS & Email')

@section('content')
<div class="grid-2">
    <!-- Send SMS -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-sms" style="color:var(--primary);margin-right:8px;"></i> Send SMS</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sms-email.sms') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Recipients (comma separated phone numbers)</label>
                    <input type="text" name="recipients" class="form-control" placeholder="9812345678, 9876543210" required>
                    <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">
                        Quick select:
                        @foreach($users->take(5) as $user)
                            <span style="cursor:pointer;color:var(--primary);text-decoration:underline;" 
                                  onclick="addRecipient('sms', '{{ $user->phone }}')">{{ $user->full_name }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="4" maxlength="1000" required placeholder="Type your SMS message..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Send SMS to these recipients?')">
                    <i class="fas fa-paper-plane"></i> Send SMS
                </button>
            </form>
        </div>
    </div>

    <!-- Send Email -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-envelope" style="color:var(--secondary);margin-right:8px;"></i> Send Email</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sms-email.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Recipients (comma separated emails)</label>
                    <input type="text" name="recipients" class="form-control" placeholder="email@example.com" required>
                    <div style="font-size:12px;color:var(--gray-400);margin-top:4px;">
                        Quick select:
                        @foreach($users->where('email', '!=', '')->take(5) as $user)
                            <span style="cursor:pointer;color:var(--secondary);text-decoration:underline;"
                                  onclick="addRecipient('email', '{{ $user->email }}')">{{ $user->full_name }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="Email subject" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="4" required placeholder="Type your email message..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return confirm('Send email to these recipients?')">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>
            </form>
        </div>
    </div>
</div>

<!-- History -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history" style="color:var(--accent);margin-right:8px;"></i> Send History</h3>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Subject/Message</th>
                    <th>Recipients</th>
                    <th>Success</th>
                    <th>Failed</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr>
                        <td>
                            <span class="badge {{ $item->type === 'email' ? 'badge-info' : 'badge-success' }}">
                                <i class="fas {{ $item->type === 'email' ? 'fa-envelope' : 'fa-sms' }}"></i>
                                {{ ucfirst($item->type) }}
                            </span>
                        </td>
                        <td>
                            @if($item->subject)
                                <strong>{{ Str::limit($item->subject, 30) }}</strong><br>
                            @endif
                            {{ Str::limit($item->message, 40) }}
                        </td>
                        <td>{{ $item->recipient_count }}</td>
                        <td style="color:var(--success);font-weight:600;">{{ $item->success_count }}</td>
                        <td style="color:var(--danger);font-weight:600;">{{ $item->failed_count }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'completed' ? 'badge-success' : ($item->status === 'failed' ? 'badge-danger' : 'badge-warning') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-paper-plane"></i>
                            <p>No messages sent yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $history->links() }}

@push('scripts')
<script>
function addRecipient(type, value) {
    const formIndex = type === 'sms' ? 0 : 1;
    const input = document.querySelectorAll('input[name="recipients"]')[formIndex];
    if (input.value && !input.value.endsWith(',')) {
        input.value += ', ';
    }
    input.value += value;
}
</script>
@endpush
@endsection
