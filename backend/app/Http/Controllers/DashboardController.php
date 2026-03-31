<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\MatchResult;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.index');
        }

        if ($user->hasCapability('hospital')) {
            return redirect()->route('hospital.dashboard');
        }

        if (!$user->hasCapability('donor') && !$user->hasCapability('recipient')) {
            return redirect()->route('onboarding.capabilities.edit');
        }

        $recentRequests = BloodRequest::where('requester_id', $user->id)
            ->with(['matchResults', 'confirmedDonor'])
            ->latest()
            ->take(5)
            ->get();

        $recentMatches = MatchResult::with('bloodRequest')
            ->where('donor_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentDonations = Donation::where('donor_id', $user->id)
            ->latest('donation_date')
            ->take(5)
            ->get();

        $unreadNotifications = $user->notifications()->where('is_read', false)->count();

        $stats = [
            'total_units_donated' => (int) Donation::where('donor_id', $user->id)
                ->where('is_successful', true)
                ->sum('units_donated'),
            'completed_donations' => Donation::where('donor_id', $user->id)
                ->where('is_successful', true)
                ->count(),
            'pending_matches' => MatchResult::where('donor_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'accepted_matches' => MatchResult::where('donor_id', $user->id)
                ->where('status', 'accepted')
                ->count(),
            'completed_matches' => MatchResult::where('donor_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'total_requests' => BloodRequest::where('requester_id', $user->id)->count(),
            'active_requests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending', 'matched', 'confirmed', 'in_progress'])
                ->count(),
            'critical_requests' => BloodRequest::where('requester_id', $user->id)
                ->whereIn('urgency_level', ['critical', 'high'])
                ->whereIn('status', ['pending', 'matched', 'confirmed', 'in_progress'])
                ->count(),
            'confirmed_requests' => BloodRequest::where('requester_id', $user->id)
                ->whereNotNull('confirmed_donor_id')
                ->count(),
        ];

        $priorityItems = $this->buildPriorityItems($user->id, $user->hasCapability('donor'), $user->hasCapability('recipient'));
        $recentActivity = $this->buildRecentActivity($recentRequests, $recentMatches, $recentDonations);

        $impactScore = min(
            98,
            max(
                24,
                30
                + ($stats['completed_donations'] * 8)
                + ($stats['completed_matches'] * 4)
                + ($stats['confirmed_requests'] * 5)
            )
        );

        return view('pages.dashboard', [
            'user' => $user,
            'recentRequests' => $recentRequests,
            'recentMatches' => $recentMatches,
            'recentDonations' => $recentDonations,
            'unreadNotifications' => $unreadNotifications,
            'stats' => $stats,
            'priorityItems' => $priorityItems,
            'recentActivity' => $recentActivity,
            'impactScore' => $impactScore,
        ]);
    }

    private function buildPriorityItems(int $userId, bool $isDonor, bool $isRecipient): Collection
    {
        $items = collect();

        if ($isDonor) {
            $items = $items->merge(
                MatchResult::with('bloodRequest')
                    ->where('donor_id', $userId)
                    ->where('status', 'pending')
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function (MatchResult $match) {
                        return [
                            'title' => 'Potential Match: '.($match->bloodRequest?->blood_group ?? 'Unknown'),
                            'subtitle' => trim(($match->bloodRequest?->hospital_name ?? 'LifeLink request').' • '.($match->bloodRequest?->city ?? 'Unknown location')),
                            'tone' => ($match->bloodRequest?->urgency_level ?? 'medium') === 'critical' ? 'critical' : 'neutral',
                            'href' => route('matches.index'),
                        ];
                    })
            );
        }

        if ($isRecipient) {
            $items = $items->merge(
                BloodRequest::where('requester_id', $userId)
                    ->whereIn('status', ['pending', 'matched', 'confirmed', 'in_progress'])
                    ->orderByRaw("FIELD(urgency_level, 'critical','high','medium','low')")
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function (BloodRequest $bloodRequest) {
                        return [
                            'title' => 'Request: '.($bloodRequest->blood_group ?? 'Unknown'),
                            'subtitle' => trim(ucfirst($bloodRequest->urgency_level).' • '.($bloodRequest->hospital_name ?? 'No hospital')),
                            'tone' => in_array($bloodRequest->urgency_level, ['critical', 'high'], true) ? 'critical' : 'neutral',
                            'href' => route('requests.show', $bloodRequest),
                        ];
                    })
            );
        }

        return $items->take(4)->values();
    }

    private function buildRecentActivity(Collection $recentRequests, Collection $recentMatches, Collection $recentDonations): Collection
    {
        $requestActivities = $recentRequests->map(function (BloodRequest $request) {
            $status = Str::headline($request->status ?? 'pending');
            $matchesFound = $request->matchResults?->count() ?? 0;

            return [
                'title' => 'Blood Request '.$status,
                'description' => trim(($request->blood_group ?? 'Unknown').' request for '.($request->hospital_name ?? 'LifeLink').' in '.($request->city ?? 'Unknown city').'.'),
                'meta' => $matchesFound > 0 ? $matchesFound.' donor matches found' : 'Awaiting donor responses',
                'badge' => strtoupper((string) ($request->urgency_level ?? 'medium')),
                'badge_tone' => in_array($request->urgency_level, ['critical', 'high'], true) ? 'critical' : 'info',
                'time' => optional($request->created_at)->diffForHumans(),
                'icon' => 'emergency',
                'icon_tone' => 'blue',
                'href' => route('requests.show', $request),
                'actions' => [
                    ['label' => 'View Request', 'href' => route('requests.show', $request), 'tone' => 'primary'],
                ],
                'occurred_at' => $request->created_at,
            ];
        });

        $matchActivities = $recentMatches->map(function (MatchResult $match) {
            $status = Str::headline($match->status ?? 'pending');
            $bloodGroup = $match->bloodRequest?->blood_group ?? 'Unknown';
            $location = $match->bloodRequest?->hospital_name ?? ($match->bloodRequest?->city ?? 'LifeLink');

            $actions = [];

            if ($match->status === 'pending') {
                $actions[] = ['label' => 'Review Match', 'href' => route('matches.index'), 'tone' => 'primary'];
            }

            return [
                'title' => 'Match '.$status,
                'description' => trim('Potential '.$bloodGroup.' donor alignment for '.$location.'.'),
                'meta' => 'Match score: '.(int) $match->match_score,
                'badge' => strtoupper((string) $match->status),
                'badge_tone' => $match->status === 'completed' ? 'success' : ($match->status === 'accepted' ? 'info' : 'neutral'),
                'time' => optional($match->created_at)->diffForHumans(),
                'icon' => 'swap_horiz',
                'icon_tone' => 'rose',
                'href' => route('matches.index'),
                'actions' => $actions,
                'occurred_at' => $match->created_at,
            ];
        });

        $donationActivities = $recentDonations->map(function (Donation $donation) {
            return [
                'title' => 'Donation Recorded',
                'description' => trim(((int) $donation->units_donated).' unit(s) logged in your donation history.'),
                'meta' => $donation->is_successful ? 'Successful donation' : 'Recorded by system',
                'badge' => $donation->is_successful ? 'COMPLETED' : strtoupper((string) $donation->status),
                'badge_tone' => $donation->is_successful ? 'success' : 'info',
                'time' => optional($donation->donation_date ?? $donation->created_at)->diffForHumans(),
                'icon' => 'water_drop',
                'icon_tone' => 'rose',
                'href' => route('dashboard'),
                'actions' => [],
                'occurred_at' => $donation->donation_date ?? $donation->created_at,
            ];
        });

        return $requestActivities
            ->merge($matchActivities)
            ->merge($donationActivities)
            ->sortByDesc('occurred_at')
            ->take(6)
            ->values();
    }
}
