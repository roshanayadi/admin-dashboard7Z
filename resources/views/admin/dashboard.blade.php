@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Total Members</div>
            </div>
            <div class="stat-icon green"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_blogs'] }}</div>
                <div class="stat-label">Blog Posts</div>
            </div>
            <div class="stat-icon blue"><i class="fas fa-blog"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_gallery'] }}</div>
                <div class="stat-label">Gallery Items</div>
            </div>
            <div class="stat-icon purple"><i class="fas fa-images"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['unread_contacts'] }}</div>
                <div class="stat-label">Unread Messages</div>
            </div>
            <div class="stat-icon yellow"><i class="fas fa-envelope"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['avg_rating'] ?: '0' }}</div>
                <div class="stat-label">Avg Feedback Rating</div>
            </div>
            <div class="stat-icon red"><i class="fas fa-star"></i></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['unread_notifications'] }}</div>
                <div class="stat-label">Pending Notifications</div>
            </div>
            <div class="stat-icon blue"><i class="fas fa-bell"></i></div>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid-2">
    <!-- Recent Blog Posts -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-blog" style="color:var(--primary);margin-right:8px;"></i> Recent Blog Posts</h3>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> New
            </a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($recentBlogs as $blog)
                <div style="display:flex;align-items:center;gap:12px;padding:14px 24px;border-bottom:1px solid var(--gray-100);">
                    <div style="flex:1;">
                        <div style="font-size:14px;font-weight:600;">{{ Str::limit($blog->title, 40) }}</div>
                        <div style="font-size:12px;color:var(--gray-400);margin-top:2px;">
                            {{ $blog->author->full_name ?? 'Unknown' }} &middot; {{ $blog->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <span class="badge {{ $blog->status === 'published' ? 'badge-success' : 'badge-warning' }}">
                        {{ ucfirst($blog->status) }}
                    </span>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p>No blog posts yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-history" style="color:var(--accent);margin-right:8px;"></i> Recent Activity</h3>
        </div>
        <div class="card-body">
            <ul class="activity-list">
                @forelse($recentActivity as $activity)
                    <li class="activity-item">
                        <div class="activity-dot {{ $activity->type === 'auth' ? 'green' : ($activity->type === 'blog' ? 'blue' : 'yellow') }}"></div>
                        <div>
                            <div class="activity-text">
                                <strong>{{ ucfirst($activity->action) }}</strong> — {{ $activity->details ?? $activity->type }}
                            </div>
                            <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </li>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-clock"></i>
                        <p>No activity yet</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Recent Users -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-user-plus" style="color:var(--secondary);margin-right:8px;"></i> Recent Members</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Member
        </a>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td><strong>{{ $user->full_name }}</strong></td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email ?: '—' }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No members yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
