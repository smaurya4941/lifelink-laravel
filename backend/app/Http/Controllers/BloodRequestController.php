<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\MatchResult;
use App\Models\RecipientProfile;
use App\Services\MatchingService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BloodRequestController extends Controller
{
    public function index(Request $request): View
    {
        $requests = BloodRequest::with(['matchResults', 'confirmedDonor'])
            ->where('requester_id', $request->user()->id)
            ->latest()
            ->get();

        $profile = RecipientProfile::where('user_id', $request->user()->id)->first();
        $activeRequest = $this->resolveActiveRequest($request, $requests);
        $activeMatches = collect();

        if ($activeRequest) {
            $activeMatches = MatchResult::with('donor')
                ->where('request_id', $activeRequest->id)
                ->where('donor_id', '!=', $request->user()->id)
                ->orderByDesc('match_score')
                ->take(5)
                ->get();
        }

        $stats = [
            'total' => $requests->count(),
            'critical' => $requests->where('urgency_level', 'critical')->whereIn('status', ['pending', 'matched', 'confirmed', 'in_progress'])->count(),
            'pending' => $requests->where('status', 'pending')->count(),
            'matched' => $requests->whereIn('status', ['matched', 'confirmed', 'in_progress'])->count(),
            'completed' => $requests->where('status', 'completed')->count(),
        ];

        return view('recipient.requests.index', [
            'requests' => $requests,
            'profile' => $profile,
            'activeRequest' => $activeRequest,
            'activeMatches' => $activeMatches,
            'stats' => $stats,
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('requests.index');
    }

    public function store(Request $request, MatchingService $matchingService, NotificationService $notificationService)
    {
        $data = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'units_required' => ['required', 'integer', 'min:1', 'max:10'],
            'hospital_name' => ['required', 'string', 'max:255'],
            'patient_name' => ['nullable', 'string', 'max:255'],
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

        $matches = MatchResult::with('donor')
            ->where('request_id', $bloodRequest->id)
            ->get();

        foreach ($matches as $match) {
            if ($match->donor) {
                $notificationService->create(
                    $match->donor,
                    'MATCH_FOUND',
                    'New Blood Request Match',
                    'You have been matched with a blood request for ' . ($bloodRequest->patient_name ?? 'a patient') . '. Score: ' . $match->match_score . '%',
                    $bloodRequest,
                    $match
                );
            }
        }

        return redirect()->route('requests.show', $bloodRequest)
            ->with('status', 'Blood request created and matches generated.');
    }

    public function show(Request $request, BloodRequest $bloodRequest)
    {
        if ($bloodRequest->requester_id !== $request->user()->id) {
            abort(403);
        }

        $matches = MatchResult::with('donor')
            ->where('request_id', $bloodRequest->id)
            ->where('donor_id', '!=', $request->user()->id)
            ->orderByDesc('match_score')
            ->get();

        return view('recipient.requests.show', [
            'bloodRequest' => $bloodRequest,
            'matches' => $matches,
        ]);
    }

    public function confirmDonor(Request $request, BloodRequest $bloodRequest)
    {
        if ($bloodRequest->requester_id !== $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'match_id' => ['required', 'exists:match_results,id'],
            'confirmation_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $match = MatchResult::where('id', $data['match_id'])
            ->where('request_id', $bloodRequest->id)
            ->firstOrFail();

        if ($match->donor_id === $request->user()->id) {
            return redirect()->back()->with('error', 'You cannot confirm yourself as donor for your own request.');
        }

        if ($match->status !== 'accepted') {
            return redirect()->back()->with('error', 'Donor has not accepted the match yet.');
        }

        $bloodRequest->confirmed_donor_id = $match->donor_id;
        $bloodRequest->confirmation_date = now();
        $bloodRequest->confirmation_notes = $data['confirmation_notes'] ?? null;
        $bloodRequest->status = 'confirmed';
        $bloodRequest->save();

        $match->status = 'completed';
        $match->save();

        $notificationService = app(NotificationService::class);
        $confirmationNote = trim((string) ($data['confirmation_notes'] ?? ''));
        $donorMessage = 'Your donation for ' . ($bloodRequest->patient_name ?? 'a patient') . ' has been confirmed.';
        if ($confirmationNote !== '') {
            $donorMessage .= ' Recipient note: ' . $confirmationNote;
        }

        if ($match->donor) {
            $notificationService->create(
                $match->donor,
                'DONOR_CONFIRMED',
                'Your Donation Has Been Confirmed',
                $donorMessage,
                $bloodRequest,
                $match
            );
        }

        $notificationService->create(
            $request->user(),
            'DONOR_CONFIRMED',
            'Donor Confirmed Successfully',
            'You have confirmed a donor for this request.',
            $bloodRequest,
            $match
        );

        return redirect()->route('requests.show', $bloodRequest)
            ->with('status', 'Donor confirmed successfully.');
    }

    private function resolveActiveRequest(Request $request, Collection $requests): ?BloodRequest
    {
        $selectedId = $request->integer('request');

        if ($selectedId) {
            $selected = $requests->firstWhere('id', $selectedId);
            if ($selected) {
                return $selected;
            }
        }

        return $requests->first();
    }
}
