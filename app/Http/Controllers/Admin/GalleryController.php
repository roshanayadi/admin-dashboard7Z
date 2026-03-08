<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryItem::with('author');

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        if ($type = $request->get('type')) {
            $query->where('file_type', $type);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = GalleryItem::distinct()->pluck('category');

        return view('admin.gallery.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = GalleryItem::distinct()->pluck('category');
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'file_type' => 'required|in:image,video',
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('uploads/gallery', 'public');

        GalleryItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'file_type' => $validated['file_type'],
            'category' => $validated['category'],
            'location' => $validated['location'] ?? null,
            'author_id' => Auth::guard('admin')->id(),
        ]);

        ActivityLog::log('gallery', 'upload', "Uploaded: {$validated['title']}");

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item uploaded successfully.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->file_path) {
            Storage::disk('public')->delete($gallery->file_path);
        }

        $title = $gallery->title;
        $gallery->delete();

        ActivityLog::log('gallery', 'delete', "Deleted gallery: {$title}");

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item deleted successfully.');
    }
}
