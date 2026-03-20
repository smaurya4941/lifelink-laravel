<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\MatchResult;
use App\Services\MatchingService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->is_recipient) {
            return response()->json(BloodRequest::where('requester_id', $request->user()->id)->get());
        }

        return response()->json(BloodRequest::all());
    }

    public function store(Request $request, MatchingService $matchingService, NotificationService $notificationService)
    {
        $data = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'patient_name' => ['nullable', 'string', 'max:255'],
            'units_required' => ['required', 'integer', 'min:1', 'max:10'],
            'hospital_name' => ['required', 'string', 'max:255'],
            'hospital_address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'urgency_level' => ['required', 'in:critical,high,medium,low'],
            'required_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'radius_km' => ['nullable', 'integer', 'min:1', 'max:200'],
        ]);

        $data['requester_id'] = $request->user()->id;

        $bloodRequest = BloodRequest::create($data);

        $matchingService->createMatchResults($bloodRequest, 10);

        $matches = MatchResult::with('donor')->where('request_id', $bloodRequest->id)->get();
        foreach ($matches as $match) {
            if ($match->donor) {
                $notificationService->create(
                    $match->donor,
                    'MATCH_FOUND',
                    'New Blood Request Match',
                    'You have been matched with a blood request. Score: ' . $match->match_score . '%',
                    $bloodRequest,
                    $match
                );
            }
        }

        return response()->json($bloodRequest, 201);
    }

    public function show(Request $request, BloodRequest $bloodRequest)
    {
        if ($request->user()->is_recipient && $bloodRequest->requester_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        return response()->json($bloodRequest);
    }

    public function update(Request $request, BloodRequest $bloodRequest)
    {
        if ($bloodRequest->requester_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'status' => ['nullable', 'in:pending,matched,confirmed,in_progress,completed,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);

        $bloodRequest->update($data);

        return response()->json($bloodRequest);
    }

    public function destroy(Request $request, BloodRequest $bloodRequest)
    {
        if ($bloodRequest->requester_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $bloodRequest->delete();

        return response()->json(['detail' => 'Deleted']);
    }

    public function findMatches(Request $request, BloodRequest $bloodRequest, MatchingService $matchingService)
    {
        $matchingService->createMatchResults($bloodRequest, 10);

        $matches = MatchResult::with('donor')
            ->where('request_id', $bloodRequest->id)
            ->get()
            ->map(function ($match) {
                return [
                    'donor_id' => $match->donor_id,
                    'donor_name' => $match->donor?->name,
                    'blood_group' => $match->donor?->donorProfile?->blood_group,
                    'overall_score' => $match->match_score,
                    'success_probability' => $match->success_probability,
                    'health_risk' => $match->health_risk,
                    'distance_km' => $match->distance_km,
                    'scores_breakdown' => $match->scores_breakdown,
                ];
            });

        return response()->json([
            'matches_found' => $matches->count(),
            'matches' => $matches,
            'request_id' => $bloodRequest->id,
        ]);
    }

    public function confirmDonor(Request $request, BloodRequest $bloodRequest)
    {
        $data = $request->validate([
            'match_id' => ['required', 'exists:match_results,id'],
            'confirmation_notes' => ['nullable', 'string'],
        ]);

        $match = MatchResult::where('id', $data['match_id'])
            ->where('request_id', $bloodRequest->id)
            ->firstOrFail();

        if ($match->status !== 'accepted') {
            return response()->json(['detail' => 'Donor not accepted yet'], 400);
        }

        $bloodRequest->confirmed_donor_id = $match->donor_id;
        $bloodRequest->confirmation_date = now();
        $bloodRequest->confirmation_notes = $data['confirmation_notes'] ?? null;
        $bloodRequest->status = 'confirmed';
        $bloodRequest->save();

        $match->status = 'completed';
        $match->save();

        return response()->json(['detail' => 'Donor confirmed']);
    }
}
