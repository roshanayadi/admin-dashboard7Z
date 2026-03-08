@extends('layouts.admin')
@section('title', 'Admin Management')

@section('content')
<div class="filters-bar">
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Admin
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td><strong>{{ $admin->username }}</strong></td>
                        <td>{{ $admin->full_name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <span class="badge {{ $admin->role === 'admin' ? 'badge-info' : 'badge-secondary' }}">
                                {{ ucfirst($admin->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $admin->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </td>
                        <td>{{ $admin->last_login ? $admin->last_login->format('M d, Y h:i A') : 'Never' }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-secondary btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($admin->id !== auth()->guard('admin')->id())
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST"
                                          onsubmit="return confirm('Delete this admin?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No admins found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $admins->links() }}
@endsection
