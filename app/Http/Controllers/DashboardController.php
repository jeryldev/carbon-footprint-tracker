<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CarbonReportingService;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $reportingService;
    protected $recommendationService;

    public function __construct(
        CarbonReportingService $reportingService,
        RecommendationService $recommendationService
    ) {
        $this->reportingService = $reportingService;
        $this->recommendationService = $recommendationService;
    }

    public function index(Request $request): View
    {
        $user = User::with(['activityLogs', 'baselineAssessment', 'achievements'])
            ->find($request->user()->id);

        $period = $request->query('period', 'today');
        $savings = $this->reportingService->getSavings($user, $period);
        $recentLogs = $user->activityLogs()
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $recommendations = $this->recommendationService->getPersonalizedRecommendations($user, 1);

        return view('dashboard', [
            'user' => $user,
            'savings' => $savings,
            'period' => $period,
            'hasBaseline' => $user->hasCompletedBaselineAssessment(),
            'recentLogs' => $recentLogs,
            'refresh' => $request->query('refresh', null),
            'recommendation' => $recommendations[0] ?? null,
        ]);
    }
}
