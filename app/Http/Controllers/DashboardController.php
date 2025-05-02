<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CarbonReportingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected $reportingService;

    public function __construct(CarbonReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {

        // Force fresh data by getting a new instance of the user with relationships
        $user = User::with(['activityLogs', 'baselineAssessment', 'achievements'])
            ->find($request->user()->id);

        $period = $request->query('period', 'today');

        // Get carbon savings with fresh calculations
        $savings = $this->reportingService->getSavings($user, $period);

        // Get recent activity logs with fresh data
        $recentLogs = $user->activityLogs()
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'savings' => $savings,
            'period' => $period,
            'hasBaseline' => $user->hasCompletedBaselineAssessment(),
            'recentLogs' => $recentLogs,
            'refresh' => $request->query('refresh', null), // Pass refresh parameter to view
        ]);
    }
}
