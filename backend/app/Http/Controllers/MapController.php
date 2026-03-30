<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\DonorProfile;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MapController extends Controller
{
    public function index()
    {
        return view('pages.map');
    }

    /**
     * Legacy endpoint kept for backward compatibility.
     */
    public function data(Request $request): JsonResponse
    {
        $donors = $this->donorMarkers($request, true)->map(function (array $marker) {
            return [
                'id' => $marker['id'],
                'name' => $marker['name'],
                'blood_group' => $marker['blood_group'],
                'city' => $marker['city'],
                'state' => $marker['state'],
                'lat' => $marker['lat'],
                'lng' => $marker['lng'],
            ];
        })->values();

        $requests = BloodRequest::query()
            ->where('status', 'pending')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('id')
            ->get()
            ->map(function (BloodRequest $req) {
                return [
                    'id' => $req->id,
                    'patient_name' => $req->patient_name,
                    'blood_group' => $req->blood_group,
                    'urgency' => $req->urgency_level,
                    'city' => $req->city,
                    'state' => $req->state,
                    'lat' => (float) $req->latitude,
                    'lng' => (float) $req->longitude,
                ];
            })
            ->filter(fn (array $row) => $this->isCoordinateValid($row['lat'], $row['lng']))
            ->values();

        return response()->json([
            'donors' => $donors,
            'requests' => $requests,
        ]);
    }

    public function markers(Request $request): JsonResponse
    {
        $types = collect(explode(',', strtolower((string) $request->query('types', 'donor,request,hospital'))))
            ->map(fn (string $type) => trim($type))
            ->filter(fn (string $type) => in_array($type, ['donor', 'request', 'hospital'], true))
            ->values();

        if ($types->isEmpty()) {
            $types = collect(['donor', 'request', 'hospital']);
        }

        $markers = collect();

        if ($types->contains('donor')) {
            $availableOnly = filter_var($request->query('available_only', '1'), FILTER_VALIDATE_BOOLEAN);
            $markers = $markers->concat($this->donorMarkers($request, $availableOnly));
        }

        if ($types->contains('request')) {
            $markers = $markers->concat($this->requestMarkers($request));
        }

        if ($types->contains('hospital')) {
            $markers = $markers->concat($this->hospitalMarkers($request));
        }

        $markers = $markers->values();

        return response()->json([
            'meta' => [
                'generated_at' => now()->toISOString(),
                'types' => $types,
                'counts' => [
                    'total' => $markers->count(),
                    'donor' => $markers->where('type', 'donor')->count(),
                    'request' => $markers->where('type', 'request')->count(),
                    'hospital' => $markers->where('type', 'hospital')->count(),
                ],
            ],
            'markers' => $markers,
        ]);
    }

    private function donorMarkers(Request $request, bool $availableOnly): Collection
    {
        $query = DonorProfile::query()->with('user');

        if ($availableOnly) {
            $query->where('availability_status', true);
        }

        return $query->latest('id')->get()->map(function (DonorProfile $donor) use ($request) {
            $lat = $donor->current_latitude ?? $donor->user?->latitude;
            $lng = $donor->current_longitude ?? $donor->user?->longitude;

            if (!$this->isCoordinateValid($lat, $lng) || !$this->inBounds($request, (float) $lat, (float) $lng)) {
                return null;
            }

            return [
                'id' => $donor->id,
                'type' => 'donor',
                'name' => $donor->user?->name ?? 'Donor',
                'lat' => (float) $lat,
                'lng' => (float) $lng,
                'city' => $donor->city ?? $donor->user?->city,
                'state' => $donor->state ?? $donor->user?->traditional_state,
                'blood_group' => $donor->blood_group,
                'is_available' => (bool) $donor->availability_status,
            ];
        })->filter()->values();
    }

    private function requestMarkers(Request $request): Collection
    {
        return BloodRequest::query()
            ->with('requester:id,name,is_recipient')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('id')
            ->get()
            ->map(function (BloodRequest $bloodRequest) use ($request) {
                $lat = $bloodRequest->latitude;
                $lng = $bloodRequest->longitude;

                if (!$this->isCoordinateValid($lat, $lng) || !$this->inBounds($request, (float) $lat, (float) $lng)) {
                    return null;
                }

                // Show requests created by recipients or hospitals.
                if (!($bloodRequest->requester?->is_recipient || $bloodRequest->requester?->is_hospital)) {
                    return null;
                }

                return [
                    'id' => $bloodRequest->id,
                    'type' => 'request',
                    'name' => $bloodRequest->patient_name ?: ($bloodRequest->requester?->name ?? 'Request'),
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                    'city' => $bloodRequest->city,
                    'state' => $bloodRequest->state,
                    'blood_group' => $bloodRequest->blood_group,
                    'urgency' => $bloodRequest->urgency_level,
                    'hospital_name' => $bloodRequest->hospital_name,
                    'address' => $bloodRequest->hospital_address,
                    'is_available' => null,
                ];
            })
            ->filter()
            ->values();
    }

    private function hospitalMarkers(Request $request): Collection
    {
        return Hospital::query()
            ->with('user:id,latitude,longitude')
            ->latest('id')
            ->get()
            ->map(function (Hospital $hospital) use ($request) {
                $lat = $hospital->latitude ?? $hospital->user?->latitude;
                $lng = $hospital->longitude ?? $hospital->user?->longitude;

                if (!$this->isCoordinateValid($lat, $lng) || !$this->inBounds($request, (float) $lat, (float) $lng)) {
                    return null;
                }

                return [
                    'id' => $hospital->id,
                    'type' => 'hospital',
                    'name' => $hospital->hospital_name ?? 'Hospital',
                    'lat' => (float) $lat,
                    'lng' => (float) $lng,
                    'city' => $hospital->city,
                    'state' => $hospital->state,
                    'blood_group' => null,
                    'address' => $hospital->address,
                    'verification_status' => $hospital->verification_status,
                    'is_available' => null,
                ];
            })
            ->filter()
            ->values();
    }

    private function isCoordinateValid(mixed $lat, mixed $lng): bool
    {
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return false;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

        return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
    }

    private function inBounds(Request $request, float $lat, float $lng): bool
    {
        $north = $request->query('north');
        $south = $request->query('south');
        $east = $request->query('east');
        $west = $request->query('west');

        if ($north === null || $south === null || $east === null || $west === null) {
            return true;
        }

        if (!is_numeric($north) || !is_numeric($south) || !is_numeric($east) || !is_numeric($west)) {
            return true;
        }

        $north = (float) $north;
        $south = (float) $south;
        $east = (float) $east;
        $west = (float) $west;

        return $lat <= $north && $lat >= $south && $lng <= $east && $lng >= $west;
    }
}
