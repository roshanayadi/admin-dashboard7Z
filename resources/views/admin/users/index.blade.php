@extends('layouts.admin')
@section('title', 'User Management')

@section('content')
<div class="filters-bar">
    <div class="search-input">
        <i class="fas fa-search"></i>
        <form method="GET" style="width:100%;">
            <input type="text" name="search" placeholder="Search by name, phone, email..." value="{{ request('search') }}">
        </form>
    </div>
    <select class="form-control" style="width:auto;" onchange="window.location.href='?status='+this.value">
        <option value="">All Status</option>
        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Member
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><strong>{{ $user->full_name }}</strong></td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email ?: '—' }}</td>
                        <td>
                            <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($user->notes, 30) }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete this member?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-icon" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-users"></i>
                            <p>No members found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $users->links() }}
@endsection
