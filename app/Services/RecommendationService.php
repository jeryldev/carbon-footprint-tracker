<?php

namespace App\Services;

use App\Models\EcoRecommendation;
use App\Models\User;

class RecommendationService
{
    /**
     * Get personalized recommendations based on user's activity logs
     */
    public function getPersonalizedRecommendations(User $user, int $count = 1): array
    {
        $recentLogs = $user->activityLogs()
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $focusCategory = null;

        if ($recentLogs->isNotEmpty()) {
            $highTransport = $recentLogs->where('transport_type', 'car')->count() > 2;
            $highElectricity = $recentLogs->avg('electricity_usage') > 5;
            $highWaste = $recentLogs->avg('waste_generation') > 1;

            if ($highTransport) {
                $focusCategory = 'transportation';
            } elseif ($highElectricity) {
                $focusCategory = 'electricity';
            } elseif ($highWaste) {
                $focusCategory = 'waste';
            }
        }

        $query = EcoRecommendation::query();

        if ($focusCategory) {

            $query->where('category', $focusCategory);
        }

        $recommendations = $query->inRandomOrder()->take($count)->get();

        if ($recommendations->isEmpty()) {
            $recommendations = EcoRecommendation::inRandomOrder()->take($count)->get();
        }

        if ($recommendations->count() < $count) {
            $additionalCount = $count - $recommendations->count();
            $existingIds = $recommendations->pluck('id')->toArray();

            $additionalRecommendations = EcoRecommendation::query()
                ->whereNotIn('id', $existingIds)
                ->inRandomOrder()
                ->take($additionalCount)
                ->get();

            $recommendations = $recommendations->concat($additionalRecommendations);
        }

        return $recommendations->isNotEmpty() ? $recommendations->toArray() : [];
    }

    /**
     * Get a completely random recommendation
     */
    public function getRandomRecommendation(): ?array
    {
        $recommendation = EcoRecommendation::inRandomOrder()->first();
        return $recommendation ? $recommendation->toArray() : null;
    }
}
