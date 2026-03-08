<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query();

        if ($rating = $request->get('rating')) {
            $query->where('rating', $rating);
        }

        $feedback = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.feedback.index', compact('feedback'));
    }

    public function toggleApproval(Feedback $feedback)
    {
        $feedback->update(['approved' => !$feedback->approved]);

        $status = $feedback->approved ? 'approved' : 'unapproved';
        ActivityLog::log('feedback', $status, "Feedback #{$feedback->id} {$status}");

        return back()->with('success', "Feedback {$status} successfully.");
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully.');
    }
}
