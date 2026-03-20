<?php

namespace App\Http\Controllers;

use App\Models\DonorProfile;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        return view('pages.map');
    }

    public function data(Request $request)
    {
        $donors = DonorProfile::with('user')
            ->where('availability_status', true)
            ->get()
            ->map(function ($donor) {
                $lat = $donor->current_latitude ?? $donor->user?->latitude;
                $lng = $donor->current_longitude ?? $donor->user?->longitude;
                return [
                    'id' => $donor->id,
                    'name' => $donor->user?->name,
                    'blood_group' => $donor->blood_group,
                    'city' => $donor->city ?? $donor->user?->city,
                    'state' => $donor->state,
                    'lat' => $lat,
                    'lng' => $lng,
                ];
            })
            ->filter(fn ($d) => $d['lat'] && $d['lng'])
            ->values();

        $requests = BloodRequest::where('status', 'pending')
            ->get()
            ->map(function ($req) {
                return [
                    'id' => $req->id,
                    'patient_name' => $req->patient_name,
                    'blood_group' => $req->blood_group,
                    'urgency' => $req->urgency_level,
                    'city' => $req->city,
                    'state' => $req->state,
                    'lat' => $req->latitude,
                    'lng' => $req->longitude,
                ];
            })
            ->filter(fn ($r) => $r['lat'] && $r['lng'])
            ->values();

        return response()->json([
            'donors' => $donors,
            'requests' => $requests,
        ]);
    }
}
