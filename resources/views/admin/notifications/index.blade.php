@extends('layouts.admin')
@section('title', 'Notifications')

@section('content')
<div class="filters-bar">
    <form action="{{ route('admin.notifications.markAllRead') }}" method="POST">
        @csrf
        <button class="btn btn-secondary btn-sm">
            <i class="fas fa-check-double"></i> Mark All Read
        </button>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr style="{{ !$notification->is_read ? 'background:#f0fdf4;' : '' }}">
                        <td>
                            <span class="badge badge-info">{{ ucfirst($notification->type) }}</span>
                        </td>
                        <td>{{ $notification->message }}</td>
                        <td>
                            <span class="badge {{ $notification->is_read ? 'badge-secondary' : 'badge-success' }}">
                                {{ $notification->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td>{{ $notification->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                @if(!$notification->is_read)
                                    <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm btn-secondary" title="Mark Read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST"
                                      onsubmit="return confirm('Delete this notification?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-icon" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-bell-slash"></i>
                            <p>No notifications</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $notifications->links() }}
@endsection
