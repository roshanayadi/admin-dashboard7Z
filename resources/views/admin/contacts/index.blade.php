@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-envelope" style="color:var(--primary);margin-right:8px;"></i> Contact Messages</h3>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr style="{{ !$contact->is_read ? 'background:#f0fdf4;' : '' }}">
                        <td><strong>{{ $contact->name }}</strong></td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ Str::limit($contact->subject, 30) }}</td>
                        <td>{{ Str::limit($contact->message, 40) }}</td>
                        <td>
                            <span class="badge {{ $contact->is_read ? 'badge-secondary' : 'badge-success' }}">
                                {{ $contact->is_read ? 'Read' : 'New' }}
                            </span>
                        </td>
                        <td>{{ $contact->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                @if(!$contact->is_read)
                                    <form action="{{ route('admin.contacts.read', $contact) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-secondary" title="Mark Read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-icon btn-sm" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-envelope-open"></i>
                            <p>No contact messages</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $contacts->links() }}
@endsection
