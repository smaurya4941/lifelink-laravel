<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonorProfileController extends Controller
{
    public function matches(Request $request): View
    {
        $user = $request->user();

        $matches = $user->donorMatches()
            ->with('bloodRequest')
            ->whereHas('bloodRequest', function ($query) use ($user) {
                $query->where('requester_id', '!=', $user->id);
            })
            ->latest()
            ->get();

        $requestMatches = collect();
        if ($user->hasCapability('recipient')) {
            $requestMatches = MatchResult::with(['bloodRequest', 'donor'])
                ->whereHas('bloodRequest', function ($query) use ($user) {
                    $query->where('requester_id', $user->id);
                })
                ->latest()
                ->get();
        }

        $stats = [
            'pending' => $matches->where('status', 'pending')->count(),
            'accepted' => $matches->where('status', 'accepted')->count(),
            'completed' => $matches->where('status', 'completed')->count(),
            'rejected' => $matches->where('status', 'rejected')->count(),
            'request_matches' => $requestMatches->count(),
            'avg_score' => round((float) $matches->avg('match_score'), 1),
        ];

        return view('donor.matches', [
            'user' => $user,
            'matches' => $matches,
            'requestMatches' => $requestMatches,
            'stats' => $stats,
        ]);
    }
}
