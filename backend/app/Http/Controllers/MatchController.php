<?php

namespace App\Http\Controllers;

use App\Models\MatchResult;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function accept(Request $request, MatchResult $match, NotificationService $notificationService)
    {
        if ($match->donor_id !== $request->user()->id) {
            abort(403);
        }

        if ($match->bloodRequest && $match->bloodRequest->requester_id === $request->user()->id) {
            return redirect()->back()->with('error', 'You cannot accept your own blood request.');
        }

        if ($match->status !== 'pending') {
            return redirect()->back()->with('error', 'This match has already been responded to.');
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

        return redirect()->back()->with('status', 'Match accepted.');
    }

    public function reject(Request $request, MatchResult $match, NotificationService $notificationService)
    {
        if ($match->donor_id !== $request->user()->id) {
            abort(403);
        }

        if ($match->bloodRequest && $match->bloodRequest->requester_id === $request->user()->id) {
            return redirect()->back()->with('error', 'You cannot respond to your own blood request.');
        }

        if ($match->status !== 'pending') {
            return redirect()->back()->with('error', 'This match has already been responded to.');
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

        return redirect()->back()->with('status', 'Match rejected.');
    }
}
