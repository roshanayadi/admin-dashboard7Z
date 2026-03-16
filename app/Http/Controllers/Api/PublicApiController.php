<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\GalleryItem;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class PublicApiController extends Controller
{
    /**
     * Get all blog posts (public - approved/published only)
     */
    public function getBlogs(): JsonResponse
    {
        try {
            $blogs = BlogPost::where('status', 'published')
                ->with('author:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return response()->json([
                'success' => true,
                'data' => $blogs->items(),
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'total' => $blogs->total(),
                    'per_page' => $blogs->perPage(),
                    'last_page' => $blogs->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get single blog post detail
     */
    public function getBlogDetail($id): JsonResponse
    {
        try {
            $blog = BlogPost::where('status', 'published')
                ->with('author:id,name')
                ->withCount('comments')
                ->findOrFail($id);

            // Increment views
            $blog->increment('views');

            return response()->json(['success' => true, 'data' => $blog]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Blog not found'], 404);
        }
    }

    /**
     * Get blogs by category
     */
    public function getBlogsByCategory($category): JsonResponse
    {
        try {
            $blogs = BlogPost::where('status', 'published')
                ->where('category', $category)
                ->with('author:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return response()->json([
                'success' => true,
                'data' => $blogs->items(),
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'total' => $blogs->total(),
                    'per_page' => $blogs->perPage(),
                    'last_page' => $blogs->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all gallery items (public)
     */
    public function getGallery(): JsonResponse
    {
        try {
            $gallery = GalleryItem::with('author:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return response()->json([
                'success' => true,
                'data' => $gallery->items(),
                'pagination' => [
                    'current_page' => $gallery->currentPage(),
                    'total' => $gallery->total(),
                    'per_page' => $gallery->perPage(),
                    'last_page' => $gallery->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get single gallery item detail
     */
    public function getGalleryDetail($id): JsonResponse
    {
        try {
            $item = GalleryItem::with('author:id,name')->findOrFail($id);

            // Increment views
            $item->increment('views');

            return response()->json(['success' => true, 'data' => $item]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gallery item not found'], 404);
        }
    }

    /**
     * Get gallery items by category
     */
    public function getGalleryByCategory($category): JsonResponse
    {
        try {
            $gallery = GalleryItem::where('category', $category)
                ->with('author:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            return response()->json([
                'success' => true,
                'data' => $gallery->items(),
                'pagination' => [
                    'current_page' => $gallery->currentPage(),
                    'total' => $gallery->total(),
                    'per_page' => $gallery->perPage(),
                    'last_page' => $gallery->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all notices/notifications (public)
     */
    public function getNotices(): JsonResponse
    {
        try {
            $notices = Notification::orderBy('created_at', 'desc')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $notices->items(),
                'pagination' => [
                    'current_page' => $notices->currentPage(),
                    'total' => $notices->total(),
                    'per_page' => $notices->perPage(),
                    'last_page' => $notices->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get single notice/notification detail
     */
    public function getNoticeDetail($id): JsonResponse
    {
        try {
            $notice = Notification::findOrFail($id);
            return response()->json(['success' => true, 'data' => $notice]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Notice not found'], 404);
        }
    }
}
