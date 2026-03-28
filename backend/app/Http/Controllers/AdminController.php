<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\MatchResult;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'stats' => [
                'users' => User::count(),
                'donors' => User::where('is_donor', true)->count(),
                'recipients' => User::where('is_recipient', true)->count(),
                'hospitals' => User::where('role', 'hospital')->count(),
                'requests' => BloodRequest::count(),
                'matches' => MatchResult::count(),
                'donations' => Donation::count(),
                'notifications' => UserNotification::count(),
            ],
        ]);
    }

    public function users()
    {
        return view('admin.users', [
            'users' => User::latest()->paginate(25),
            'roleOptions' => ['donor', 'recipient', 'hospital', 'admin'],
        ]);
    }

    public function requests()
    {
        return view('admin.requests', [
            'requests' => BloodRequest::with('requester')->latest()->paginate(25),
        ]);
    }

    public function matches()
    {
        return view('admin.matches', [
            'matches' => MatchResult::with(['donor', 'bloodRequest'])->latest()->paginate(25),
        ]);
    }

    public function donations()
    {
        return view('admin.donations', [
            'donations' => Donation::with(['donor', 'recipient', 'hospital'])->latest()->paginate(25),
        ]);
    }

    public function notifications()
    {
        return view('admin.notifications', [
            'notifications' => UserNotification::with('user')->latest()->paginate(25),
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['donor', 'recipient', 'hospital', 'admin'])],
            'status' => ['required', 'boolean'],
        ]);

        $user->role = $data['role'];
        $user->status = (bool) $data['status'];
        $user->is_donor = $data['role'] === 'donor';
        $user->is_recipient = $data['role'] === 'recipient';
        $user->save();

        return redirect()->route('admin.users')->with('status', 'User updated successfully.');
    }

    public function updateRequest(Request $request, BloodRequest $bloodRequest)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'matched', 'confirmed', 'in_progress', 'completed', 'cancelled'])],
        ]);

        $bloodRequest->status = $data['status'];
        $bloodRequest->save();

        return redirect()->route('admin.requests')->with('status', 'Request status updated.');
    }

    public function updateMatch(Request $request, MatchResult $match)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'accepted', 'rejected', 'completed'])],
        ]);

        $match->status = $data['status'];
        if ($data['status'] !== 'pending' && !$match->responded_at) {
            $match->responded_at = now();
        }
        $match->save();

        return redirect()->route('admin.matches')->with('status', 'Match status updated.');
    }

    public function updateDonation(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['completed', 'failed'])],
            'is_successful' => ['required', 'boolean'],
        ]);

        $donation->status = $data['status'];
        $donation->is_successful = (bool) $data['is_successful'];
        $donation->save();

        return redirect()->route('admin.donations')->with('status', 'Donation updated.');
    }

    public function updateNotification(Request $request, UserNotification $notification)
    {
        $data = $request->validate([
            'is_read' => ['required', 'boolean'],
        ]);

        $notification->is_read = (bool) $data['is_read'];
        $notification->save();

        return redirect()->route('admin.notifications')->with('status', 'Notification updated.');
    }
}
