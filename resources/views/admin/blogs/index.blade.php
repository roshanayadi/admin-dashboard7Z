@extends('layouts.admin')
@section('title', 'Blog Management')

@section('content')
<div class="filters-bar">
    <div class="search-input">
        <i class="fas fa-search"></i>
        <form method="GET" style="width:100%;">
            <input type="text" name="search" placeholder="Search blogs..." value="{{ request('search') }}">
        </form>
    </div>
    <select class="form-control" style="width:auto;" onchange="window.location.href='?status='+this.value">
        <option value="">All Status</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
    </select>
    <select class="form-control" style="width:auto;" onchange="window.location.href='?category='+this.value">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
        @endforeach
    </select>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Blog
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $blog)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                @if($blog->featured_image)
                                    <img src="{{ asset('storage/' . $blog->featured_image) }}" class="img-preview" alt="">
                                @endif
                                <strong>{{ Str::limit($blog->title, 40) }}</strong>
                            </div>
                        </td>
                        <td><span class="badge badge-info">{{ ucfirst($blog->category) }}</span></td>
                        <td>{{ $blog->author->full_name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $blog->status === 'published' ? 'badge-success' : ($blog->status === 'draft' ? 'badge-warning' : 'badge-secondary') }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </td>
                        <td>{{ number_format($blog->views) }}</td>
                        <td>{{ $blog->comments_count }}</td>
                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-secondary btn-icon" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                      onsubmit="return confirm('Delete this blog post?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-newspaper"></i>
                            <p>No blog posts found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $blogs->links() }}
@endsection
