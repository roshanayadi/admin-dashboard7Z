@extends('layouts.admin')
@section('title', 'Gallery')

@section('content')
<div class="filters-bar">
    <div class="search-input">
        <i class="fas fa-search"></i>
        <form method="GET" style="width:100%;">
            <input type="text" name="search" placeholder="Search gallery..." value="{{ request('search') }}">
        </form>
    </div>
    <select class="form-control" style="width:auto;" onchange="window.location.href='?category='+this.value">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
        @endforeach
    </select>
    <select class="form-control" style="width:auto;" onchange="window.location.href='?type='+this.value">
        <option value="">All Types</option>
        <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Images</option>
        <option value="video" {{ request('type') === 'video' ? 'selected' : '' }}>Videos</option>
    </select>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <i class="fas fa-upload"></i> Upload
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px;">
    @forelse($items as $item)
        <div class="card" style="margin-bottom:0;">
            <div style="position:relative;height:200px;overflow:hidden;border-radius:12px 12px 0 0;">
                @if($item->file_type === 'image')
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}"
                         style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;background:var(--gray-800);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-video" style="font-size:48px;color:white;opacity:0.5;"></i>
                    </div>
                @endif
                <span class="badge {{ $item->file_type === 'image' ? 'badge-info' : 'badge-warning' }}"
                      style="position:absolute;top:10px;right:10px;">
                    {{ ucfirst($item->file_type) }}
                </span>
            </div>
            <div class="card-body" style="padding:16px;">
                <h4 style="font-size:14px;font-weight:600;margin-bottom:4px;">{{ Str::limit($item->title, 40) }}</h4>
                <div style="font-size:12px;color:var(--gray-400);margin-bottom:12px;">
                    <i class="fas fa-folder"></i> {{ ucfirst($item->category) }}
                    @if($item->location)
                        &middot; <i class="fas fa-map-marker-alt"></i> {{ $item->location }}
                    @endif
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:12px;color:var(--gray-400);">
                        <i class="fas fa-eye"></i> {{ $item->views }}
                        &middot; <i class="fas fa-heart"></i> {{ $item->likes }}
                    </span>
                    <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Delete this item?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm btn-icon" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column:1/-1;">
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <p>No gallery items found</p>
            </div>
        </div>
    @endforelse
</div>

<div style="margin-top:20px;">
    {{ $items->links() }}
</div>
@endsection
