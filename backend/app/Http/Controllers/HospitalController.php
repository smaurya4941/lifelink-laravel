<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        $recentRequests = BloodRequest::where('requester_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('hospital.dashboard', [
            'user' => $user,
            'recentRequests' => $recentRequests,
        ]);
    }
}
