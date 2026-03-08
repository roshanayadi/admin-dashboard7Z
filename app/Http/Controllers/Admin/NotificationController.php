<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted.');
    }
}
