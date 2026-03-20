<?php

namespace App\Http\Controllers;

use App\Models\DonorProfile;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class NearbyController extends Controller
{
    public function donors(Request $request)
    {
        $request->validate([
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
            'radius' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string'],
        ]);

        $radius = $request->get('radius', 50);
        $lat = (float) $request->lat;
        $lon = (float) $request->lon;

        $donors = DonorProfile::with('user')
            ->where('availability_status', true)
            ->get()
            ->filter(function ($donor) use ($lat, $lon, $radius, $request) {
                $dLat = $donor->current_latitude ?? $donor->user?->latitude;
                $dLon = $donor->current_longitude ?? $donor->user?->longitude;
                if (!$dLat || !$dLon) {
                    return false;
                }
                if ($request->blood_group && $donor->blood_group !== $request->blood_group) {
                    return false;
                }
                return $this->distanceKm($lat, $lon, (float) $dLat, (float) $dLon) <= $radius;
            })
            ->values()
            ->map(function ($donor) use ($lat, $lon) {
                $dLat = $donor->current_latitude ?? $donor->user?->latitude;
                $dLon = $donor->current_longitude ?? $donor->user?->longitude;
                return [
                    'id' => $donor->id,
                    'name' => $donor->user?->name,
                    'blood_group' => $donor->blood_group,
                    'city' => $donor->city ?? $donor->user?->city,
                    'distance_km' => $this->distanceKm($lat, $lon, (float) $dLat, (float) $dLon),
                ];
            });

        return response()->json([
            'count' => $donors->count(),
            'results' => $donors,
        ]);
    }

    public function requests(Request $request)
    {
        $request->validate([
            'lat' => ['required', 'numeric'],
            'lon' => ['required', 'numeric'],
            'radius' => ['nullable', 'numeric'],
            'blood_group' => ['nullable', 'string'],
        ]);

        $radius = $request->get('radius', 50);
        $lat = (float) $request->lat;
        $lon = (float) $request->lon;

        $requests = BloodRequest::whereNotNull('latitude')->whereNotNull('longitude')
            ->get()
            ->filter(function ($req) use ($lat, $lon, $radius, $request) {
                if ($request->blood_group && $req->blood_group !== $request->blood_group) {
                    return false;
                }
                return $this->distanceKm($lat, $lon, (float) $req->latitude, (float) $req->longitude) <= $radius;
            })
            ->values()
            ->map(function ($req) use ($lat, $lon) {
                return [
                    'id' => $req->id,
                    'patient_name' => $req->patient_name,
                    'blood_group' => $req->blood_group,
                    'urgency' => $req->urgency_level,
                    'city' => $req->city,
                    'distance_km' => $this->distanceKm($lat, $lon, (float) $req->latitude, (float) $req->longitude),
                ];
            });

        return response()->json([
            'count' => $requests->count(),
            'results' => $requests,
        ]);
    }

    private function distanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $r = 6371.0;
        $dlat = deg2rad($lat2 - $lat1);
        $dlon = deg2rad($lon2 - $lon1);

        $a = sin($dlat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($r * $c, 2);
    }
}
