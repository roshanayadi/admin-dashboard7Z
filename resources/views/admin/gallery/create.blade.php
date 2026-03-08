@extends('layouts.admin')
@section('title', 'Upload to Gallery')

@section('content')
<form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>Upload New Item</h3>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary btn-sm">
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
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                </div>
                <div class="form-group">
                    <label>File Type *</label>
                    <select name="file_type" class="form-control" required>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>File *</label>
                <input type="file" name="file" class="form-control" required>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:20px;">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
