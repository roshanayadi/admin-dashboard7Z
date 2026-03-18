@extends('layouts.admin')
@section('title', 'Feedback')

@section('content')
<div class="filters-bar">
    <select class="form-control" style="width:auto;" onchange="window.location.href='?rating='+this.value">
        <option value="">All Ratings</option>
        @for($i = 5; $i >= 1; $i--)
            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
        @endfor
    </select>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Feedback</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedback as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->name }}</strong>
                            @if($item->email)
                                <div style="font-size:12px;color:var(--gray-400);">{{ $item->email }}</div>
                            @endif
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($item->feedback, 60) }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="color:{{ $i <= $item->rating ? '#f59e0b' : '#e5e7eb' }};font-size:13px;"></i>
                            @endfor
                        </td>
                        <td>
                            <span class="badge {{ $item->approved ? 'badge-success' : 'badge-warning' }}">
                                {{ $item->approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <form action="{{ route('admin.feedback.toggle', $item) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm {{ $item->approved ? 'btn-warning' : 'btn-primary' }}">
                                        <i class="fas {{ $item->approved ? 'fa-eye-slash' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.feedback.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Delete this feedback?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm btn-icon">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-star"></i>
                            <p>No feedback yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $feedback->links() }}
@endsection
