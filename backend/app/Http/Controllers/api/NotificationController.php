<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            UserNotification::where('user_id', $request->user()->id)
                ->latest()
                ->get()
        );
    }

    public function markRead(Request $request, UserNotification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $notification->is_read = true;
        $notification->save();

        return response()->json(['detail' => 'Marked read']);
    }

    public function markAllRead(Request $request)
    {
        UserNotification::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['detail' => 'All marked read']);
    }
}
