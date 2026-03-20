<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MatchResult;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->is_donor) {
            return response()->json(MatchResult::with('bloodRequest')->where('donor_id', $user->id)->get());
        }
        if ($user->is_recipient) {
            return response()->json(MatchResult::with('bloodRequest')->whereHas('bloodRequest', fn ($q) => $q->where('requester_id', $user->id))->get());
        }

        return response()->json([]);
    }

    public function accept(Request $request, MatchResult $match, NotificationService $notificationService)
    {
        if ($match->donor_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $match->status = 'accepted';
        $match->responded_at = now();
        $match->save();

        if ($match->bloodRequest) {
            $match->bloodRequest->status = 'matched';
            $match->bloodRequest->save();

            $notificationService->create(
                $match->bloodRequest->requester,
                'REQUEST_ACCEPTED',
                'Donor Accepted Your Request',
                $request->user()->name . ' has accepted your blood request.',
                $match->bloodRequest,
                $match
            );
        }

        return response()->json(['detail' => 'Match accepted']);
    }

    public function reject(Request $request, MatchResult $match, NotificationService $notificationService)
    {
        if ($match->donor_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $match->status = 'rejected';
        $match->responded_at = now();
        $match->save();

        if ($match->bloodRequest) {
            $notificationService->create(
                $match->bloodRequest->requester,
                'REQUEST_REJECTED',
                'Match Rejected',
                $request->user()->name . ' has rejected your blood request.',
                $match->bloodRequest,
                $match
            );
        }

        return response()->json(['detail' => 'Match rejected']);
    }
}
