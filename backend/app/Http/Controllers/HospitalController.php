<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Hospital;
use App\Models\MatchResult;
use App\Services\MatchingService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HospitalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $hospital = $this->resolveHospital($user);

        $requestsQuery = BloodRequest::query()->where('requester_id', $user->id);
        $requestIds = $requestsQuery->pluck('id');

        $stats = [
            'total_requests' => $requestsQuery->count(),
            'active_requests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending', 'matched', 'confirmed', 'in_progress'])
                ->count(),
            'critical_requests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('urgency_level', ['critical', 'high'])
                ->count(),
            'matched_donors' => MatchResult::whereIn('request_id', $requestIds)
                ->whereIn('status', ['accepted', 'completed'])
                ->count(),
        ];

        $recentRequests = BloodRequest::where('requester_id', $user->id)
            ->latest()
            ->take(8)
            ->get();

        return view('hospital.dashboard', [
            'hospital' => $hospital,
            'stats' => $stats,
            'recentRequests' => $recentRequests,
        ]);
    }

    public function editProfile(Request $request): View
    {
        return view('hospital.profile', [
            'hospital' => $this->resolveHospital($request->user()),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hospital_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'license_number' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $hospital = $this->resolveHospital($request->user());
        $licenseChanged = $hospital->exists && $hospital->license_number !== $data['license_number'];

        $hospital->fill([
            'hospital_name' => $data['hospital_name'],
            'address' => $data['address'],
            'license_number' => $data['license_number'],
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'pincode' => $data['pincode'] ?? null,
            'contact_phone' => $data['contact_phone'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        // Changing key compliance attributes sends profile back for re-review.
        if ($licenseChanged) {
            $hospital->verification_status = 'pending';
            $hospital->verified_at = null;
        }

        $hospital->save();

        $request->user()->update([
            'is_hospital' => true,
            'role' => $request->user()->isAdmin() ? 'admin' : 'hospital',
            'address' => $data['address'],
            'city' => $data['city'] ?? null,
            'traditional_state' => $data['state'] ?? null,
            'pincode' => $data['pincode'] ?? null,
            'phone_number' => $data['contact_phone'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return redirect()->route('hospital.profile.edit')->with('status', 'Hospital profile updated successfully.');
    }

    public function requestsIndex(Request $request): View
    {
        $hospital = $this->resolveHospital($request->user());
        $requests = BloodRequest::where('requester_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('hospital.requests.index', [
            'hospital' => $hospital,
            'requests' => $requests,
        ]);
    }

    public function createRequest(Request $request): View
    {
        return view('hospital.requests.create', [
            'hospital' => $this->resolveHospital($request->user()),
        ]);
    }

    public function storeRequest(
        Request $request,
        MatchingService $matchingService,
        NotificationService $notificationService
    ): RedirectResponse {
        $hospital = $this->resolveHospital($request->user());

        if (!$hospital->isVerified()) {
            return redirect()->route('hospital.profile.edit')
                ->with('error', 'Hospital verification is required before creating requests.');
        }

        $data = $request->validate([
            'patient_name' => ['required', 'string', 'max:255'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'units_required' => ['required', 'integer', 'min:1', 'max:20'],
            'urgency_level' => ['required', 'in:critical,high,medium,low'],
            'required_date' => ['nullable', 'date'],
            'contact_person' => ['required', 'string', 'max:100'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'radius_km' => ['nullable', 'integer', 'min:1', 'max:300'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $bloodRequest = BloodRequest::create([
            'requester_id' => $request->user()->id,
            'patient_name' => $data['patient_name'],
            'blood_group' => $data['blood_group'],
            'units_required' => $data['units_required'],
            'hospital_name' => $hospital->hospital_name,
            'hospital_address' => $hospital->address,
            'city' => $hospital->city ?? $request->user()->city,
            'state' => $hospital->state ?? $request->user()->traditional_state,
            'pincode' => $hospital->pincode ?? $request->user()->pincode,
            'contact_person' => $data['contact_person'],
            'contact_phone' => $data['contact_phone'],
            'urgency_level' => $data['urgency_level'],
            'required_date' => $data['required_date'] ?? null,
            'notes' => $data['notes'] ?? null,
            'description' => $data['description'] ?? null,
            'radius_km' => $data['radius_km'] ?? 20,
            'latitude' => $data['latitude'] ?? $hospital->latitude,
            'longitude' => $data['longitude'] ?? $hospital->longitude,
            'status' => 'pending',
        ]);

        // Higher volume priority: generate a deeper donor shortlist for hospitals.
        $matchingService->createMatchResults($bloodRequest, 25);

        $matches = MatchResult::with('donor')
            ->where('request_id', $bloodRequest->id)
            ->get();

        foreach ($matches as $match) {
            if ($match->donor) {
                $notificationService->create(
                    $match->donor,
                    'HOSPITAL_MATCH_FOUND',
                    'Hospital Request Match',
                    'A verified hospital request needs ' . $bloodRequest->blood_group . ' blood. Score: ' . $match->match_score . '%',
                    $bloodRequest,
                    $match
                );
            }
        }

        return redirect()->route('hospital.requests.show', $bloodRequest)
            ->with('status', 'Hospital request created and donors notified.');
    }

    public function showRequest(Request $request, BloodRequest $bloodRequest): View
    {
        if ($bloodRequest->requester_id !== $request->user()->id) {
            abort(403);
        }

        $matches = MatchResult::with('donor')
            ->where('request_id', $bloodRequest->id)
            ->orderByDesc('match_score')
            ->get();

        return view('hospital.requests.show', [
            'hospital' => $this->resolveHospital($request->user()),
            'bloodRequest' => $bloodRequest,
            'matches' => $matches,
        ]);
    }

    private function resolveHospital($user): Hospital
    {
        return Hospital::firstOrCreate(
            ['user_id' => $user->id],
            [
                'hospital_name' => $user->name . ' Hospital',
                'license_number' => 'PENDING-' . $user->id,
                'address' => $user->address ?? 'Address not provided',
                'city' => $user->city,
                'state' => $user->traditional_state,
                'pincode' => $user->pincode,
                'contact_phone' => $user->phone_number,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'verification_status' => 'pending',
            ]
        );
    }
}

