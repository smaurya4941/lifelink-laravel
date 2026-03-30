<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use Illuminate\Http\Request;

class DonorProfileController extends Controller
{
    public function matches(Request $request)
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

        return view('donor.matches', [
            'matches' => $matches,
            'requestMatches' => $requestMatches,
        ]);
    }
}
