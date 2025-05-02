<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class AchievementService
{
    /**
     * Check and unlock achievements for a user
     */
    public function checkAchievements(User $user): void
    {
        // Force fresh calculation with latest data
        $user = User::with('activityLogs', 'baselineAssessment', 'achievements')
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
        $logs = $user->activityLogs()
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($log) {
                return $log->date->format('Y-m-d');
            });

        $uniqueDays = $logs->count();

        if ($uniqueDays >= 7) {
            $this->unlockAchievement($user, 'Eco Warrior');
        }

        if ($uniqueDays >= 30) {
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
        $baselineDailyFootprint = 0;
        if ($user->baselineAssessment) {
            $baselineDailyFootprint = $user->baselineAssessment->baseline_carbon_footprint / 365;
        } else {
            return;
        }

        $logs = $user->activityLogs()->get();
        $totalSavedEmissions = 0;
        $totalTreeDays = 0;

        foreach ($logs as $log) {
            $saving = $baselineDailyFootprint - $log->carbon_footprint;
            if ($saving > 0) {
                $totalSavedEmissions += $saving;
                $totalTreeDays += $saving / 0.06; // A tree absorbs ~60g CO2 per day
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
     * Unlock an achievement for a user
     */
    private function unlockAchievement(User $user, string $achievementName): void
    {
        $achievement = $user->achievements()
            ->where('name', $achievementName)
            ->where('is_unlocked', false)
            ->first();

        if ($achievement) {
            $achievement->update([
                'is_unlocked' => true,
                'unlocked_at' => now(),
            ]);
        }
    }
}
