<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\DonorProfile;
use App\Models\MatchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $timeRange = $request->get('time_range', '30d');
        [$startDate, $endDate] = $this->parseDateRange($timeRange);

        $overview = $this->getOverview($startDate, $endDate);
        $trends = $this->getTrends($startDate, $endDate);
        $bloodGroupDistribution = $this->getBloodGroupDistribution();
        $locationStats = $this->getLocationStats($startDate, $endDate);
        $successRates = $this->getSuccessRates();
        $donorActivity = $this->getDonorActivity($startDate, $endDate);
        $urgentRequests = $this->getUrgentRequests();
        $predictive = [
            'demand_prediction' => $this->predictBloodDemand(),
            'availability_prediction' => $this->predictDonorAvailability(),
            'success_prediction' => $this->predictSuccessRates(),
        ];

        return view('pages.analytics', compact(
            'overview',
            'trends',
            'bloodGroupDistribution',
            'locationStats',
            'successRates',
            'donorActivity',
            'urgentRequests',
            'timeRange',
            'predictive'
        ));
    }

    public function data(Request $request)
    {
        $timeRange = $request->get('time_range', '30d');
        [$startDate, $endDate] = $this->parseDateRange($timeRange);

        return response()->json([
            'overview' => $this->getOverview($startDate, $endDate),
            'trends' => $this->getTrends($startDate, $endDate),
            'bloodGroupDistribution' => $this->getBloodGroupDistribution(),
            'locationStats' => $this->getLocationStats($startDate, $endDate),
            'successRates' => $this->getSuccessRates(),
            'donorActivity' => $this->getDonorActivity($startDate, $endDate),
            'urgentRequests' => $this->getUrgentRequests(),
        ]);
    }

    public function predictive(Request $request)
    {
        return response()->json([
            'demand_prediction' => $this->predictBloodDemand(),
            'availability_prediction' => $this->predictDonorAvailability(),
            'success_prediction' => $this->predictSuccessRates(),
        ]);
    }

    private function parseDateRange(string $timeRange): array
    {
        $end = Carbon::now()->startOfDay();
        return match ($timeRange) {
            '7d' => [$end->copy()->subDays(7), $end],
            '90d' => [$end->copy()->subDays(90), $end],
            '1y' => [$end->copy()->subYear(), $end],
            default => [$end->copy()->subDays(30), $end],
        };
    }

    private function getOverview(Carbon $start, Carbon $end): array
    {
        $totalMatches = MatchResult::whereBetween('created_at', [$start, $end])->count();
        $totalDonations = Donation::whereBetween('donation_date', [$start->toDateString(), $end->toDateString()])
            ->where('is_successful', true)
            ->count();
        $activeDonors = DonorProfile::where('availability_status', true)
            ->whereBetween('updated_at', [$start, $end])
            ->count();
        $urgentRequests = BloodRequest::whereIn('urgency_level', ['critical', 'high'])
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $successfulMatches = MatchResult::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $successRate = $totalMatches > 0 ? round(($successfulMatches / $totalMatches) * 100, 1) : 0;

        return [
            'total_matches' => $totalMatches,
            'total_donations' => $totalDonations,
            'active_donors' => $activeDonors,
            'urgent_requests' => $urgentRequests,
            'success_rate' => $successRate,
        ];
    }

    private function getTrends(Carbon $start, Carbon $end): array
    {
        $data = [];
        $cursor = $start->copy();

        while ($cursor <= $end) {
            $date = $cursor->toDateString();
            $matches = MatchResult::whereDate('created_at', $date)->count();
            $donations = Donation::whereDate('donation_date', $date)->where('is_successful', true)->count();

            $data[] = [
                'date' => $date,
                'matches' => $matches,
                'donations' => $donations,
            ];

            $cursor->addDay();
        }

        return $data;
    }

    private function getBloodGroupDistribution(): array
    {
        $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
        $result = [];

        foreach ($groups as $group) {
            $count = DonorProfile::where('blood_group', $group)->count();
            $result[] = ['name' => $group, 'value' => $count];
        }

        return $result;
    }

    private function getLocationStats(Carbon $start, Carbon $end): array
    {
        $stats = [];

        $requests = BloodRequest::whereBetween('created_at', [$start, $end])->get();
        foreach ($requests as $request) {
            if (!$request->city) {
                continue;
            }
            $stats[$request->city]['matches'] = ($stats[$request->city]['matches'] ?? 0) + MatchResult::where('request_id', $request->id)->count();
            $stats[$request->city]['donations'] = ($stats[$request->city]['donations'] ?? 0) + Donation::where('recipient_id', $request->requester_id)->count();
        }

        $formatted = [];
        foreach ($stats as $city => $values) {
            $formatted[] = [
                'city' => $city,
                'matches' => $values['matches'] ?? 0,
                'donations' => $values['donations'] ?? 0,
            ];
        }

        usort($formatted, fn ($a, $b) => ($b['matches'] + $b['donations']) <=> ($a['matches'] + $a['donations']));

        return array_slice($formatted, 0, 10);
    }

    private function getSuccessRates(): array
    {
        $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
        $result = [];

        foreach ($groups as $group) {
            $total = MatchResult::whereHas('bloodRequest', fn ($q) => $q->where('blood_group', $group))->count();
            $successful = MatchResult::where('status', 'completed')
                ->whereHas('bloodRequest', fn ($q) => $q->where('blood_group', $group))
                ->count();
            $rate = $total > 0 ? round(($successful / $total) * 100, 1) : 0;
            $result[] = [
                'blood_group' => $group,
                'success_rate' => $rate,
            ];
        }

        return $result;
    }

    private function getDonorActivity(Carbon $start, Carbon $end): array
    {
        $data = [];
        $cursor = $start->copy();

        while ($cursor <= $end) {
            $date = $cursor->toDateString();

            $newDonors = DonorProfile::whereDate('created_at', $date)->count();
            $activeDonors = DonorProfile::where('availability_status', true)
                ->whereDate('updated_at', $date)
                ->count();
            $donations = Donation::whereDate('donation_date', $date)->where('is_successful', true)->count();

            $data[] = [
                'date' => $date,
                'new_donors' => $newDonors,
                'active_donors' => $activeDonors,
                'donations' => $donations,
            ];

            $cursor->addDay();
        }

        return $data;
    }

    private function getUrgentRequests(): array
    {
        return BloodRequest::whereIn('urgency_level', ['critical', 'high'])
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($r) => [
                'patient_name' => $r->patient_name,
                'blood_group' => $r->blood_group,
                'city' => $r->city,
                'state' => $r->state,
                'urgency' => $r->urgency_level,
                'status' => $r->status,
                'created_at' => $r->created_at?->toISOString(),
            ])
            ->all();
    }

    private function predictBloodDemand(): array
    {
        $end = Carbon::now()->startOfDay();
        $start = $end->copy()->subDays(30);
        $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];

        $prediction = [];
        foreach ($groups as $group) {
            $count = BloodRequest::where('blood_group', $group)
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $avgDaily = $count / 30;
            $prediction[$group] = [
                'current_demand' => round($avgDaily, 2),
                'predicted_demand' => round($avgDaily * 1.1, 2),
                'confidence' => 0.75,
            ];
        }

        return $prediction;
    }

    private function predictDonorAvailability(): array
    {
        $eligibleSoon = DonorProfile::whereNotNull('last_donation_date')
            ->where('last_donation_date', '<=', Carbon::now()->subDays(80)->toDateString())
            ->count();

        $currentlyAvailable = DonorProfile::where('availability_status', true)->count();

        return [
            'currently_available' => $currentlyAvailable,
            'eligible_soon' => $eligibleSoon,
            'predicted_availability' => $currentlyAvailable + $eligibleSoon,
        ];
    }

    private function predictSuccessRates(): array
    {
        $totalMatches = MatchResult::count();
        $successfulMatches = MatchResult::where('status', 'completed')->count();
        $currentSuccessRate = $totalMatches > 0 ? round(($successfulMatches / $totalMatches) * 100, 1) : 0;

        return [
            'current_success_rate' => $currentSuccessRate,
            'predicted_success_rate' => round($currentSuccessRate * 1.05, 1),
            'confidence' => 0.8,
        ];
    }
}
