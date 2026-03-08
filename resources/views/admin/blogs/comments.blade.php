@extends('layouts.admin')
@section('title', 'Blog Comments')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-comments" style="color:var(--primary);margin-right:8px;"></i> Blog Comments</h3>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Comment</th>
                    <th>By</th>
                    <th>Post</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>{{ Str::limit($comment->comment, 60) }}</td>
                        <td>
                            <div><strong>{{ $comment->name }}</strong></div>
                            <div style="font-size:12px;color:var(--gray-400);">{{ $comment->email }}</div>
                        </td>
                        <td>{{ Str::limit($comment->post->title ?? '—', 30) }}</td>
                        <td>
                            <span class="badge {{ $comment->status === 'approved' ? 'badge-success' : ($comment->status === 'rejected' ? 'badge-danger' : 'badge-warning') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </td>
                        <td>{{ $comment->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                @if($comment->status !== 'approved')
                                    <form action="{{ route('admin.blogs.comments.update', [$comment, 'approved']) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm" style="background:#dcfce7;color:#16a34a;" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($comment->status !== 'rejected')
                                    <form action="{{ route('admin.blogs.comments.update', [$comment, 'rejected']) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm" style="background:#fee2e2;color:#dc2626;" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.blogs.comments.destroy', $comment) }}" method="POST"
                                      onsubmit="return confirm('Delete this comment?')">
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
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-comments"></i>
                            <p>No comments yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $comments->links() }}
@endsection
