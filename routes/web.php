<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SmsEmailController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/test-api', function() {
    return response()->json(['message' => 'Web route is working']);
});

// Admin Routes (Protected)
Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Blogs
    Route::resource('blogs', BlogController::class)->except(['show']);
    Route::get('blogs/comments', [BlogController::class, 'comments'])->name('blogs.comments');
    Route::patch('blogs/comments/{comment}/{status}', [BlogController::class, 'updateCommentStatus'])->name('blogs.comments.update');
    Route::delete('blogs/comments/{comment}', [BlogController::class, 'destroyComment'])->name('blogs.comments.destroy');

    // Gallery
    Route::resource('gallery', GalleryController::class)->only(['index', 'create', 'store', 'destroy']);

    // Users
    Route::resource('users', UserController::class)->except(['show']);

    // Admins
    Route::resource('admins', AdminController::class)->except(['show']);
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::patch('contacts/{contact}/read', [ContactController::class, 'markRead'])->name('contacts.read');

    // Feedback
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::patch('feedback/{feedback}/toggle', [FeedbackController::class, 'toggleApproval'])->name('feedback.toggle');
    Route::delete('feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // SMS & Email
    Route::get('sms-email', [SmsEmailController::class, 'index'])->name('sms-email.index');
    Route::post('sms-email/sms', [SmsEmailController::class, 'sendSms'])->name('sms-email.sms');
    Route::post('sms-email/email', [SmsEmailController::class, 'sendEmail'])->name('sms-email.email');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
