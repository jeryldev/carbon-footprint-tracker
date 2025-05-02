<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\EmissionFactor;
use App\Models\BaselineAssessment;
use App\Models\User;
use Carbon\Carbon;

class CarbonReportingService
{
    protected $calculationService;

    public function __construct(CarbonCalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * Get carbon savings for a time period
     *
     * @param User $user
     * @param string $period 'today', 'week', or 'month'
     * @return array
     */
    public function getSavings(User $user, string $period = 'today'): array
    {
        // Get baseline assessment
        $baseline = $user->baselineAssessment;
        if (!$baseline || !$baseline->baseline_carbon_footprint) {
            return $this->noBaselineResponse();
        }

        // Force fresh query to avoid stale data
        $logs = $this->getLogsForPeriod($user->fresh(), $period);

        if ($logs->isEmpty()) {
            return $this->noActivityResponse($period);
        }

        // Calculate actual footprint
        $actualFootprint = $logs->sum('carbon_footprint');

        // Calculate what the footprint would have been using baseline patterns
        $expectedFootprint = $this->calculateExpectedFootprint($logs, $baseline);

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
     * Calculate the expected footprint if the user had used their baseline transportation
     * for the actual distances they traveled
     *
     * @param \Illuminate\Support\Collection $logs
     * @param BaselineAssessment $baseline
     * @return float
     */
    private function calculateExpectedFootprint($logs, $baseline): float
    {
        $expectedFootprint = 0;

        // Get emission factors
        $transportFactor = EmissionFactor::where('category', 'transportation')
            ->where('type', $baseline->typical_commute_type)
            ->first()->value;

        $electricityFactor = EmissionFactor::where('category', 'electricity')
            ->where('type', 'grid')
            ->first()->value;

        $wasteFactor = EmissionFactor::where('category', 'waste')
            ->where('type', 'general')
            ->first()->value;

        // Calculate baseline daily values
        $baselineElectricityDaily = ($baseline->average_electricity_usage * 12) / 365;
        $baselineWasteDaily = $baseline->average_waste_generation;

        foreach ($logs as $log) {
            // Calculate baseline transport emissions for the actual traveled distance
            $transportEmission = $log->transport_distance * $transportFactor;

            // Add daily electricity and waste from baseline
            $electricityEmission = $baselineElectricityDaily * $electricityFactor;
            $wasteEmission = $baselineWasteDaily * $wasteFactor;

            $logExpectedFootprint = $transportEmission + $electricityEmission + $wasteEmission;
            $expectedFootprint += $logExpectedFootprint;
        }

        return $expectedFootprint;
    }

    /**
     * Get activity logs for the specified period
     */
    private function getLogsForPeriod(User $user, string $period): object
    {
        // Create a fresh query to avoid any caching issues
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
            return "Oops! Carbon usage was higher than usual during this period. Try walking or biking more tomorrow!";
        }

        $periodText = match($period) {
            'today' => 'today',
            'week' => 'this week',
            'month' => 'this month',
            default => 'today',
        };

        $savingsRounded = round($savings, 1);

        if ($savingsRounded > 20) {
            return "Amazing result $periodText! A true planet-saving achievement! 🦸";
        } elseif ($savingsRounded > 5) {
            return "Great progress $periodText! The Earth is smiling at these savings! 🌍";
        } else {
            return "Good effort $periodText! Every little bit helps protect our planet! 🌱";
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
            'message' => "Complete your baseline assessment to see your planet-saving impact!"
        ];
    }

    /**
     * Response when user has no activity logs in the period
     */
    private function noActivityResponse(string $period): array
    {
        $periodText = match($period) {
            'today' => 'today',
            'week' => 'this week',
            'month' => 'this month',
            default => 'today',
        };

        return [
            'is_saving' => null,
            'savings' => 0,
            'trees_saved' => 0,
            'car_kilometers' => 0,
            'ice_saved' => 0,
            'superhero_points' => 0,
            'days_tracked' => 0,
            'message' => "No activity logs for $periodText yet. Start tracking to see your impact!"
        ];
    }
}
