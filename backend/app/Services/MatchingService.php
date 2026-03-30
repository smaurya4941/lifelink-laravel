<?php

namespace App\Services;

use App\Models\BloodRequest;
use App\Models\DonorProfile;
use App\Models\MatchResult;
use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MatchingService
{
    private array $bloodCompatibility = [
        'A+' => ['A+', 'A-', 'O+', 'O-'],
        'A-' => ['A-', 'O-'],
        'B+' => ['B+', 'B-', 'O+', 'O-'],
        'B-' => ['B-', 'O-'],
        'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
        'AB-' => ['A-', 'B-', 'AB-', 'O-'],
        'O+' => ['O+', 'O-'],
        'O-' => ['O-'],
    ];

    private array $healthRiskFactors = [
        'diabetes' => 0.3,
        'hypertension' => 0.2,
        'heart_disease' => 0.4,
        'anemia' => 0.1,
        'hepatitis' => 0.5,
        'hiv' => 0.8,
        'cancer' => 0.6,
        'pregnancy' => 0.2,
        'recent_surgery' => 0.3,
        'medication' => 0.1,
    ];

    public function findMatches(BloodRequest $request, int $limit = 10): Collection
    {
        $compatibleGroups = $this->bloodCompatibility[$request->blood_group] ?? [];

        $donors = DonorProfile::with('user')
            ->whereIn('blood_group', $compatibleGroups)
            ->where('availability_status', true)
            ->where('user_id', '!=', $request->requester_id)
            ->get();

        return $donors->map(function (DonorProfile $donor) use ($request) {
            $scores = $this->calculateScores($donor, $request);
            $distanceKm = $this->calculateDistanceKm($donor, $request);
            $successProbability = $this->predictSuccessProbability($donor, $request);
            $healthRisk = $this->calculateHealthRiskScore($donor->medical_conditions, $request->description ?? $request->notes);

            return [
                'donor' => $donor,
                'scores' => $scores,
                'distance_km' => $distanceKm,
                'success_probability' => $successProbability,
                'health_risk' => $healthRisk,
            ];
        })->sortByDesc(fn ($item) => $item['scores']['overall_score'])
          ->take($limit)
          ->values();
    }

    public function createMatchResults(BloodRequest $request, int $limit = 10): void
    {
        $request->loadMissing('requester');
        MatchResult::where('request_id', $request->id)->delete();

        $matches = $this->findMatches($request, $limit);

        foreach ($matches as $match) {
            MatchResult::create([
                'request_id' => $request->id,
                'donor_id' => $match['donor']->user_id,
                'match_score' => $match['scores']['overall_score'],
                'distance_km' => $match['distance_km'],
                'success_probability' => $match['success_probability'],
                'health_risk' => $match['health_risk'],
                'scores_breakdown' => $match['scores'],
                'status' => 'pending',
                'notes' => sprintf('Success: %.2f, Health Risk: %.2f', $match['success_probability'], $match['health_risk']),
            ]);
        }
    }

    private function calculateScores(DonorProfile $donor, BloodRequest $request): array
    {
        $scores = [
            'blood_compatibility' => 0,
            'location_proximity' => 0,
            'temporal_compatibility' => 0,
            'health_risk' => 0,
            'donor_reliability' => 0,
            'urgency_factor' => 0,
            'institutional_priority' => 0,
            'overall_score' => 0,
        ];

        // Blood compatibility (40)
        if ($donor->blood_group === $request->blood_group) {
            $scores['blood_compatibility'] = 40;
        } elseif (in_array($donor->blood_group, ['O-', 'O+'], true)) {
            $scores['blood_compatibility'] = 35;
        } else {
            $scores['blood_compatibility'] = 30;
        }

        // Location proximity (25)
        if ($donor->city && $request->city && strcasecmp($donor->city, $request->city) === 0) {
            $scores['location_proximity'] = 25;
        } elseif ($donor->state && $request->state && strcasecmp($donor->state, $request->state) === 0) {
            $scores['location_proximity'] = 15;
        }

        // Temporal compatibility (15)
        $scores['temporal_compatibility'] = $this->calculateTemporalScore($donor, $request);

        // Health risk (10) -> lower risk higher score
        $risk = $this->calculateHealthRiskScore($donor->medical_conditions, $request->description ?? $request->notes);
        $scores['health_risk'] = round((1 - $risk) * 10, 2);

        // Donor reliability (5)
        $scores['donor_reliability'] = round($this->calculateDonorReliability($donor) * 5, 2);

        // Urgency factor (5)
        $urgencyWeights = [
            'critical' => 5,
            'high' => 4,
            'medium' => 3,
            'low' => 1,
        ];
        $scores['urgency_factor'] = $urgencyWeights[$request->urgency_level] ?? 3;

        // Verified hospital requests receive additional routing priority.
        if ($request->requester?->hasCapability('hospital')) {
            $hospital = $request->requester->hospital;
            $scores['institutional_priority'] = $hospital && $hospital->isVerified() ? 3 : 1;
        }

        $scores['overall_score'] = round(array_sum([
            $scores['blood_compatibility'],
            $scores['location_proximity'],
            $scores['temporal_compatibility'],
            $scores['health_risk'],
            $scores['donor_reliability'],
            $scores['urgency_factor'],
            $scores['institutional_priority'],
        ]), 2);

        return $scores;
    }

    private function calculateTemporalScore(DonorProfile $donor, BloodRequest $request): float
    {
        $score = 0.0;

        if ($donor->last_donation_date) {
            $days = Carbon::parse($donor->last_donation_date)->diffInDays(now());
            if ($days < 90) {
                return 0.0;
            }
            $score += 5;
        } else {
            $score += 5;
        }

        if ($request->required_date) {
            $daysUntil = Carbon::parse($request->required_date)->diffInDays(now(), false);
            if ($request->urgency_level === 'critical' && $daysUntil <= 1) {
                $score += 10;
            } elseif ($request->urgency_level === 'high' && $daysUntil <= 3) {
                $score += 7;
            } elseif ($request->urgency_level === 'medium' && $daysUntil <= 7) {
                $score += 4;
            } elseif ($request->urgency_level === 'low') {
                $score += 2;
            }
        }

        return min($score, 15);
    }

    private function calculateHealthRiskScore(?string $donorConditions, ?string $recipientConditions): float
    {
        if (!$donorConditions && !$recipientConditions) {
            return 0.0;
        }

        $donor = $this->parseConditions($donorConditions);
        $recipient = $this->parseConditions($recipientConditions);

        $risk = 0.0;
        foreach ($donor as $condition) {
            if (isset($this->healthRiskFactors[$condition])) {
                $risk += $this->healthRiskFactors[$condition];
            }
        }

        $pairs = [
            ['diabetes', 'diabetes'],
            ['hypertension', 'hypertension'],
            ['heart_disease', 'heart_disease'],
        ];
        foreach ($pairs as [$donorCond, $recipientCond]) {
            if (in_array($donorCond, $donor, true) && in_array($recipientCond, $recipient, true)) {
                $risk += 0.2;
            }
        }

        return min($risk, 1.0);
    }

    private function parseConditions(?string $conditions): array
    {
        if (!$conditions) {
            return [];
        }

        return collect(explode(',', strtolower($conditions)))
            ->map(fn ($c) => trim($c))
            ->filter()
            ->values()
            ->all();
    }

    private function calculateDonorReliability(DonorProfile $donor): float
    {
        $score = 0.0;

        if ($donor->is_verified) {
            $score += 0.3;
        }

        $donationCount = Donation::where('donor_id', $donor->user_id)->count();
        if ($donationCount > 0) {
            $score += min($donationCount * 0.05, 0.3);
        }

        $profileFields = [
            $donor->weight,
            $donor->height,
            $donor->emergency_contact,
            $donor->medical_conditions,
        ];
        $completed = collect($profileFields)->filter(fn ($v) => !is_null($v) && $v !== '')->count();
        $score += ($completed / count($profileFields)) * 0.2;

        if ($donor->updated_at) {
            $days = $donor->updated_at->diffInDays(now());
            if ($days <= 30) {
                $score += 0.2;
            }
        }

        return min($score, 1.0);
    }

    private function predictSuccessProbability(DonorProfile $donor, BloodRequest $request): float
    {
        $base = 0.7;
        if ($donor->is_verified) {
            $base += 0.1;
        }
        if ($request->urgency_level === 'critical') {
            $base += 0.1;
        }

        $risk = $this->calculateHealthRiskScore($donor->medical_conditions, $request->description ?? $request->notes);
        $base -= $risk * 0.2;

        return round(max(0.0, min(1.0, $base)), 2);
    }

    private function calculateDistanceKm(DonorProfile $donor, BloodRequest $request): ?float
    {
        if (!$donor->is_live_location_enabled) {
            return null;
        }

        if (!$donor->current_latitude || !$donor->current_longitude || !$request->latitude || !$request->longitude) {
            return null;
        }

        $lat1 = deg2rad((float) $donor->current_latitude);
        $lon1 = deg2rad((float) $donor->current_longitude);
        $lat2 = deg2rad((float) $request->latitude);
        $lon2 = deg2rad((float) $request->longitude);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dlon / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $r = 6371.0;

        return round($r * $c, 2);
    }
}
