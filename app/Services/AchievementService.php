<?php

namespace App\Services;

use App\Models\User;

class AchievementService
{
    /**
     * Check and unlock achievements for a user
     */
    public function checkAchievements(User $user): void
    {
        $user = User::with(['activityLogs', 'baselineAssessment', 'achievements'])
            ->find($user->id);

        $this->checkFirstActivityAchievement($user);
        $this->checkStreakAchievements($user);
        $this->checkTransportAchievements($user);
        $this->checkEmissionAchievements($user);
    }

    /**
     * Check if user has logged their first activity
     */
    private function checkFirstActivityAchievement(User $user): void
    {
        $logsCount = $user->activityLogs()->count();

        if ($logsCount > 0) {
            $this->unlockAchievement($user, 'Planet Protector Rookie');
        }
    }

    /**
     * Check for streaks of activity
     */
    private function checkStreakAchievements(User $user): void
    {
        $uniqueDaysCount = $user->activityLogs()
            ->select('date')
            ->distinct()
            ->count();

        if ($uniqueDaysCount >= 7) {
            $this->unlockAchievement($user, 'Eco Warrior');
        }

        if ($uniqueDaysCount >= 30) {
            $this->unlockAchievement($user, 'Climate Champion');
        }
    }

    /**
     * Check for transport type achievements
     */
    private function checkTransportAchievements(User $user): void
    {
        $walkingCount = $user->activityLogs()
            ->where('transport_type', 'walk')
            ->count();

        $cyclingCount = $user->activityLogs()
            ->where('transport_type', 'bicycle')
            ->count();

        if ($walkingCount >= 10) {
            $this->unlockAchievement($user, 'Walking Wonder');
        }

        if ($cyclingCount >= 10) {
            $this->unlockAchievement($user, 'Cycling Star');
        }
    }

    /**
     * Check emission-based achievements
     */
    private function checkEmissionAchievements(User $user): void
    {
        if (!$user->baselineAssessment || !$user->baselineAssessment->baseline_carbon_footprint) {
            return;
        }

        $baselineYearlyFootprint = $user->baselineAssessment->baseline_carbon_footprint;
        $baselineDailyFootprint = $baselineYearlyFootprint / 365;
        $logs = $user->activityLogs()->get();
        $totalSavedEmissions = 0;
        $totalTreeDays = 0;

        foreach ($logs as $log) {

            $expectedFootprint = $this->calculateExpectedDailyFootprint(
                $user->baselineAssessment->typical_commute_type,
                $log->transport_distance,
                $baselineDailyFootprint
            );

            $saving = $expectedFootprint - $log->carbon_footprint;

            if ($saving > 0) {
                $totalSavedEmissions += $saving;
                $treeDaysForThisLog = $saving / 0.06;
                $totalTreeDays += $treeDaysForThisLog;
            }
        }

        if ($totalSavedEmissions >= 50) {
            $this->unlockAchievement($user, 'Carbon Crusher');
        }

        if ($totalTreeDays >= 100) {
            $this->unlockAchievement($user, 'Tree Guardian');
        }
    }

    /**
     * Calculate expected footprint using baseline for transport but actual distance
     */
    private function calculateExpectedDailyFootprint(string $baselineTransportType, float $actualDistance, float $baselineDailyTotal): float
    {
        $transportFactor = \App\Models\EmissionFactor::where('category', 'transportation')
            ->where('type', $baselineTransportType)
            ->first();

        if (!$transportFactor) {
            $transportFactor = \App\Models\EmissionFactor::where('category', 'transportation')
                ->where('type', 'public_transit')
                ->first();
        }

        $expectedTransportEmissions = $actualDistance * $transportFactor->value;
        $baselineNonTransport = $baselineDailyTotal * 0.3;

        return $expectedTransportEmissions + $baselineNonTransport;
    }

    /**
     * Unlock an achievement if not already unlocked
     */
    private function unlockAchievement(User $user, string $achievementName): void
    {
        $achievement = $user->achievements()
            ->where('name', $achievementName)
            ->first();

        $achievement->update([
            'is_unlocked' => true,
            'unlocked_at' => now(),
        ]);
    }
}
