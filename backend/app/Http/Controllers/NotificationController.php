<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = UserNotification::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('pages.notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function list(Request $request)
    {
        $notifications = UserNotification::where('user_id', $request->user()->id)
            ->latest()
            ->take(50)
            ->get();

        return response()->json($notifications);
    }

    public function markRead(Request $request, UserNotification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            abort(403);
        }

        $notification->is_read = true;
        $notification->save();

        return redirect()->back()->with('status', 'Notification marked as read.');
    }

    public function markAllRead(Request $request)
    {
        UserNotification::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('status', 'All notifications marked as read.');
    }
}
