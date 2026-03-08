<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with('author')->withCount('comments');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = BlogPost::distinct()->pluck('category');

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogPost::distinct()->pluck('category');
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = Auth::guard('admin')->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('uploads/blogs', 'public');
        }

        $blog = BlogPost::create($validated);

        ActivityLog::log('blog', 'create', "Created blog: {$blog->title}");

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogPost::distinct()->pluck('category');
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|max:100',
            'status' => 'required|in:published,draft,archived',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('uploads/blogs', 'public');
        }

        $blog->update($validated);

        ActivityLog::log('blog', 'update', "Updated blog: {$blog->title}");

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $title = $blog->title;
        $blog->delete();

        ActivityLog::log('blog', 'delete', "Deleted blog: {$title}");

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    // Comment Management
    public function comments(Request $request)
    {
        $comments = BlogComment::with('post')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.blogs.comments', compact('comments'));
    }

    public function updateCommentStatus(BlogComment $comment, string $status)
    {
        if (!in_array($status, ['approved', 'rejected'])) {
            abort(400);
        }

        $comment->update(['status' => $status]);

        ActivityLog::log('comment', $status, "Comment #{$comment->id} {$status}");

        return back()->with('success', "Comment {$status} successfully.");
    }

    public function destroyComment(BlogComment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}
