<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $achievements = $user->achievements()
            ->orderBy('is_unlocked', 'desc')
            ->orderBy('unlocked_at', 'desc')
            ->get()
            ->groupBy('type');

        $totalPoints = $user->achievements()
            ->where('is_unlocked', true)
            ->sum('points');

        $unlockedCount = $user->achievements()
            ->where('is_unlocked', true)
            ->count();

        $totalCount = $user->achievements()->count();

        return view('achievements.index', [
            'achievements' => $achievements,
            'totalPoints' => $totalPoints,
            'unlockedCount' => $unlockedCount,
            'totalCount' => $totalCount,
        ]);
    }
}
