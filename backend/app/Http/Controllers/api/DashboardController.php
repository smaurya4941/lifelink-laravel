<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\DonorProfile;
use App\Models\MatchResult;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        $data = [
            'user' => $user,
            'stats' => [],
        ];

        if ($user->is_donor) {
            $donorProfile = DonorProfile::where('user_id', $user->id)->first();
            $data['donor_profile'] = $donorProfile;
            $data['stats'] = [
                'total_donations' => Donation::where('donor_id', $user->id)->count(),
                'pending_matches' => MatchResult::where('donor_id', $user->id)->where('status', 'pending')->count(),
                'accepted_matches' => MatchResult::where('donor_id', $user->id)->where('status', 'accepted')->count(),
            ];
        }

        if ($user->is_recipient) {
            $data['stats'] = array_merge($data['stats'], [
                'total_requests' => BloodRequest::where('requester_id', $user->id)->count(),
                'pending_requests' => BloodRequest::where('requester_id', $user->id)->where('status', 'pending')->count(),
                'matched_requests' => BloodRequest::where('requester_id', $user->id)->where('status', 'matched')->count(),
            ]);
        }

        $data['unread_notifications'] = UserNotification::where('user_id', $user->id)->where('is_read', false)->count();

        return response()->json($data);
    }
}
