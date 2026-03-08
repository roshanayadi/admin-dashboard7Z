@extends('layouts.admin')
@section('title', 'Edit Blog Post')

@section('content')
<form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3>Edit: {{ Str::limit($blog->title, 50) }}</h3>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $blog->category) }}" list="categories" required>
                    <datalist id="categories">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="form-group">
                <label>Excerpt *</label>
                <textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" class="form-control" rows="10" required>{{ old('content', $blog->content) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Featured Image</label>
                    @if($blog->featured_image)
                        <div style="margin-bottom:8px;">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" style="max-height:100px;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="archived" {{ $blog->status === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
