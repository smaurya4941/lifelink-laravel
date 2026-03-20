<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\MatchResult;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'stats' => [
                'users' => User::count(),
                'donors' => User::where('is_donor', true)->count(),
                'recipients' => User::where('is_recipient', true)->count(),
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
            'requests' => BloodRequest::latest()->paginate(25),
        ]);
    }

    public function matches()
    {
        return view('admin.matches', [
            'matches' => MatchResult::latest()->paginate(25),
        ]);
    }

    public function donations()
    {
        return view('admin.donations', [
            'donations' => Donation::latest()->paginate(25),
        ]);
    }

    public function notifications()
    {
        return view('admin.notifications', [
            'notifications' => UserNotification::latest()->paginate(25),
        ]);
    }
}
