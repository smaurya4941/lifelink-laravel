<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\Hospital;
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
                'hospitals' => User::where('is_hospital', true)->count(),
                'verified_hospitals' => Hospital::where('verification_status', 'verified')->count(),
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

    public function hospitals()
    {
        return view('admin.hospitals', [
            'hospitals' => Hospital::with('user')->latest()->paginate(25),
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => ['required', 'boolean'],
            'is_admin' => ['nullable', 'boolean'],
            'is_donor' => ['nullable', 'boolean'],
            'is_recipient' => ['nullable', 'boolean'],
            'is_hospital' => ['nullable', 'boolean'],
        ]);

        $isAdmin = $request->has('is_admin') ? $request->boolean('is_admin') : $user->isAdmin();
        $isDonor = $request->boolean('is_donor');
        $isRecipient = $request->boolean('is_recipient');
        $isHospital = $request->boolean('is_hospital');

        // Safety guard: prevent an admin from removing their own admin access.
        if ($request->user()->id === $user->id && !$isAdmin) {
            return redirect()
                ->route('admin.users')
                ->with('error', 'You cannot remove your own admin access.');
        }

        $user->status = (bool) $data['status'];
        $user->is_donor = $isDonor;
        $user->is_recipient = $isRecipient;
        $user->is_hospital = $isHospital;

        // Keep role as an admin marker; for non-admins preserve legacy compatibility value.
        if ($isAdmin) {
            $user->role = 'admin';
        } else {
            $user->role = $isHospital
                ? 'hospital'
                : ($isDonor ? 'donor' : ($isRecipient ? 'recipient' : 'recipient'));
        }

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

    public function updateHospital(Request $request, Hospital $hospital)
    {
        $data = $request->validate([
            'verification_status' => ['required', Rule::in(['pending', 'verified', 'rejected'])],
        ]);

        $hospital->verification_status = $data['verification_status'];
        $hospital->verified_at = $data['verification_status'] === 'verified' ? now() : null;
        $hospital->save();

        return redirect()->route('admin.hospitals')->with('status', 'Hospital verification updated.');
    }
}
