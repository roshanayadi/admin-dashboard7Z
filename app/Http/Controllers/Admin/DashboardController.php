<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\Feedback;
use App\Models\GalleryItem;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'total_blogs' => BlogPost::count(),
            'published_blogs' => BlogPost::published()->count(),
            'total_gallery' => GalleryItem::count(),
            'total_contacts' => Contact::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'total_feedback' => Feedback::count(),
            'avg_rating' => round(Feedback::avg('rating'), 1),
            'unread_notifications' => Notification::unread()->count(),
        ];

        $recentActivity = ActivityLog::orderBy('created_at', 'desc')->limit(10)->get();

        $recentBlogs = BlogPost::with('author')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        $monthlyStats = BlogPost::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'recentActivity',
            'recentBlogs',
            'recentUsers',
            'monthlyStats'
        ));
    }
}
