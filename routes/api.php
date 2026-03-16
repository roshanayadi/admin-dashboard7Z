<?php

use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Public Routes for Frontend
*/

Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1')->group(function () {
    // Blog Posts
    Route::get('/blogs', [PublicApiController::class, 'getBlogs']);
    Route::get('/blogs/{id}', [PublicApiController::class, 'getBlogDetail']);
    Route::get('/blogs/category/{category}', [PublicApiController::class, 'getBlogsByCategory']);

    // Gallery
    Route::get('/gallery', [PublicApiController::class, 'getGallery']);
    Route::get('/gallery/{id}', [PublicApiController::class, 'getGalleryDetail']);
    Route::get('/gallery/category/{category}', [PublicApiController::class, 'getGalleryByCategory']);

    // Notifications (Notices)
    Route::get('/notices', [PublicApiController::class, 'getNotices']);
    Route::get('/notices/{id}', [PublicApiController::class, 'getNoticeDetail']);
});
