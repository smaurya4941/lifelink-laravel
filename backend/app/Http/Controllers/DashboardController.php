<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\MatchResult;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (
            !$user->isAdmin()
            && !$user->hasCapability('hospital')
            && !$user->hasCapability('donor')
            && !$user->hasCapability('recipient')
        ) {
            return redirect()->route('onboarding.capabilities.edit');
        }

        $recentRequests = BloodRequest::where('requester_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentMatches = MatchResult::with('bloodRequest')
            ->where('donor_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = $user->notifications()->where('is_read', false)->count();

        return view('pages.dashboard', [
            'user' => $user,
            'recentRequests' => $recentRequests,
            'recentMatches' => $recentMatches,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
}
