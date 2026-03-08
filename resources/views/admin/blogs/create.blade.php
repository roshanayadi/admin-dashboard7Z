@extends('layouts.admin')
@section('title', 'Create Blog Post')

@section('content')
<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>New Blog Post</h3>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label>Category *</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" list="categories" required>
                    <datalist id="categories">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div class="form-group">
                <label>Excerpt *</label>
                <textarea name="excerpt" class="form-control" rows="3" required>{{ old('excerpt') }}</textarea>
            </div>

            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" class="form-control" id="content" rows="10" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Publish
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Optional: Initialize Quill rich text editor
    // You can replace the textarea with Quill for rich content editing
</script>
@endpush
