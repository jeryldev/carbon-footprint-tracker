<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\BaselineAssessment;
use App\Models\User;
use Carbon\Carbon;

class CarbonReportingService
{
    /**
     * Get carbon savings for a time period
     *
     * @param User $user
     * @param string $period 'today', 'week', or 'month'
     * @return array
     */
    public function getSavings(User $user, string $period = 'today'): array
    {
        // Get baseline daily value
        $baseline = $user->baselineAssessment;
        if (!$baseline || !$baseline->baseline_carbon_footprint) {
            return $this->noBaselineResponse();
        }

        $baselineDaily = $baseline->baseline_carbon_footprint / 365;

        // Get actual footprint for the period
        $logs = $this->getLogsForPeriod($user, $period);
        $actualFootprint = $logs->sum('carbon_footprint');

        // Calculate expected baseline for the period
        $days = match($period) {
            'today' => 1,
            'week' => 7,
            'month' => 30,
            default => 1,
        };

        $expectedFootprint = $baselineDaily * $days;

        // Calculate savings
        $savings = $expectedFootprint - $actualFootprint;
        $isSaving = $savings > 0;

        return [
            'is_saving' => $isSaving,
            'savings' => abs($savings),
            'trees_saved' => $this->treesEquivalent($savings),
            'car_kilometers' => $this->carKilometersEquivalent($savings),
            'ice_saved' => $this->iceSavedEquivalent($savings),
            'superhero_points' => $this->superheroPoints($savings),
            'days_tracked' => $logs->count(),
            'message' => $this->friendlyMessage($isSaving, $savings, $period)
        ];
    }

    /**
     * Get activity logs for the specified period
     */
    private function getLogsForPeriod(User $user, string $period): object
    {
        $query = ActivityLog::where('user_id', $user->id);

        switch ($period) {
            case 'today':
                return $query->whereDate('date', Carbon::today())->get();
            case 'week':
                return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            case 'month':
                return $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
            default:
                return $query->whereDate('date', Carbon::today())->get();
        }
    }

    /**
     * Create friendly message
     */
    private function friendlyMessage(bool $isSaving, float $savings, string $period): string
    {
        if (!$isSaving) {
            return "Oops! You used more carbon than usual. Let's try to walk or bike more tomorrow!";
        }

        $periodText = match($period) {
            'today' => 'today',
            'week' => 'this week',
            'month' => 'this month',
            default => 'today',
        };

        $savingsRounded = round($savings, 1);

        if ($savingsRounded > 5) {
            return "Amazing job $periodText! You're a planet-saving superhero! 🦸";
        } elseif ($savingsRounded > 1) {
            return "Great job $periodText! The Earth is smiling because of you! 🌍";
        } else {
            return "Good job $periodText! Every little bit helps protect our planet! 🌱";
        }
    }

    /**
     * Convert to tree equivalent (days of CO2 absorption)
     */
    private function treesEquivalent(float $savings): int
    {
        // A tree absorbs about 22kg of CO2 per year or 0.06kg per day
        return max(0, round($savings / 0.06));
    }

    /**
     * Convert to car kilometers equivalent
     */
    private function carKilometersEquivalent(float $savings): int
    {
        // Using car emission factor 0.2118934 kg/km
        return max(0, round($savings / 0.2118934));
    }

    /**
     * Convert to ice saved equivalent (kg of arctic ice)
     */
    private function iceSavedEquivalent(float $savings): int
    {
        // Rough estimate: 1kg CO2 = 3kg of arctic ice saved from melting
        return max(0, round($savings * 3));
    }

    /**
     * Calculate superhero points (gamification element)
     */
    private function superheroPoints(float $savings): int
    {
        // 1 kg CO2 saved = 10 superhero points
        return max(0, round($savings * 10));
    }

    /**
     * Response when user has no baseline
     */
    private function noBaselineResponse(): array
    {
        return [
            'is_saving' => null,
            'savings' => 0,
            'trees_saved' => 0,
            'car_kilometers' => 0,
            'ice_saved' => 0,
            'superhero_points' => 0,
            'days_tracked' => 0,
            'message' => "Complete your baseline assessment to see how you're helping the planet!"
        ];
    }
}
