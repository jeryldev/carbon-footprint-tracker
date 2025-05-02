<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\EmissionFactor;
use App\Services\CarbonCalculationService;
use App\Services\CarbonReportingService;
use App\Services\AchievementService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    protected $carbonCalculationService;
    protected $achievementService;

    public function __construct(CarbonCalculationService $carbonCalculationService, AchievementService $achievementService)
    {
        $this->carbonCalculationService = $carbonCalculationService;
        $this->achievementService = $achievementService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the user with fresh data
        $user = User::with(['activityLogs', 'baselineAssessment', 'achievements'])
            ->find($request->user()->id);

        $month = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();

        // Get activity logs for the selected month
        $activityLogs = $user->activityLogs()
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->orderBy('date', 'desc')
            ->get();

        // Get available months for the selector
        $months = $user->activityLogs()
            ->select(DB::raw('DISTINCT EXTRACT(YEAR FROM date) as year, EXTRACT(MONTH FROM date) as month'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromDate($item->year, $item->month, 1);
                return [
                    'label' => $date->format('F Y'),
                    'value' => $date->format('Y-m'),
                ];
            });

        // Get total footprint for the month
        $totalFootprint = $activityLogs->sum('carbon_footprint');

        // Calculate daily average
        $daysWithLogs = $activityLogs->pluck('date')->unique()->count();
        $dailyAverage = $daysWithLogs > 0 ? $totalFootprint / $daysWithLogs : 0;

        // Initialize savings calculations
        $isSaving = false;
        $savingsAmount = 0;
        $treeDays = 0;
        $iceSaved = 0;
        $heroPoints = 0;

        // Check if user has a baseline assessment
        if ($user->baselineAssessment) {
            // Use carbon reporting service to calculate savings
            $carbonReportingService = app(CarbonReportingService::class);
            $savings = $carbonReportingService->getSavings($user, 'month');

            $isSaving = $savings['is_saving'];
            $savingsAmount = $savings['savings'];
            $treeDays = $savings['trees_saved'];
            $iceSaved = $savings['ice_saved'];
            $heroPoints = $savings['superhero_points'];
        }

        // Get unlocked achievements
        $unlockedAchievements = $user->achievements()
            ->where('is_unlocked', true)
            ->get();

        return view('activity-logs.index', [
            'activityLogs' => $activityLogs,
            'months' => $months,
            'currentMonth' => $month->format('Y-m'),
            'currentMonthName' => $month->format('F Y'),
            'totalFootprint' => $totalFootprint,
            'dailyAverage' => $dailyAverage,
            'daysWithLogs' => $daysWithLogs,
            'daysInMonth' => $month->daysInMonth,
            'isSaving' => $isSaving,
            'savingsAmount' => $savingsAmount,
            'treeDays' => $treeDays,
            'iceSaved' => $iceSaved,
            'heroPoints' => $heroPoints,
            'unlockedAchievements' => $unlockedAchievements,
            'baseline' => $user->baselineAssessment,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $transportTypes = EmissionFactor::getTransportTypes();

        return view('activity-logs.create', [
            'user' => $user,
            'transportTypes' => $transportTypes,
            'today' => Carbon::today()->format('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'transport_type' => ['required', 'string'],
            'transport_distance' => ['required', 'numeric', 'min:0'],
            'electricity_usage' => ['nullable', 'numeric', 'min:0'],
            'waste_generation' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = $request->user();

        // Check if log already exists for this date
        $existingLog = ActivityLog::where('user_id', $user->id)
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existingLog) {
            return redirect()->back()->with('error', 'You already have an activity logged for this day!');
        }

        // Calculate carbon footprint
        $carbonFootprint = $this->carbonCalculationService->calculateTotalFootprint(
            $validated['transport_type'],
            $validated['transport_distance'],
            $validated['electricity_usage'] ?? 0,
            $validated['waste_generation'] ?? 0
        );

        // Create the activity log
        ActivityLog::create([
            'user_id' => $user->id,
            'date' => $validated['date'],
            'transport_type' => $validated['transport_type'],
            'transport_distance' => $validated['transport_distance'],
            'electricity_usage' => $validated['electricity_usage'] ?? 0,
            'waste_generation' => $validated['waste_generation'] ?? 0,
            'carbon_footprint' => $carbonFootprint,
        ]);

        // Check for achievements
        $this->achievementService->checkAchievements($user);

        return redirect()->route('activity-logs.index')
            ->with('success', 'Hooray! Your planet-saving activity has been logged!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityLog $activityLog)
    {
        $this->authorize('update', $activityLog);

        $transportTypes = EmissionFactor::getTransportTypes();

        return view('activity-logs.edit', [
            'activityLog' => $activityLog,
            'transportTypes' => $transportTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        $this->authorize('update', $activityLog);

        $validated = $request->validate([
            'transport_type' => ['required', 'string'],
            'transport_distance' => ['required', 'numeric', 'min:0'],
            'electricity_usage' => ['nullable', 'numeric', 'min:0'],
            'waste_generation' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Calculate carbon footprint
        $carbonFootprint = $this->carbonCalculationService->calculateTotalFootprint(
            $validated['transport_type'],
            $validated['transport_distance'],
            $validated['electricity_usage'] ?? 0,
            $validated['waste_generation'] ?? 0
        );

        // Update the activity log
        $activityLog->update([
            'transport_type' => $validated['transport_type'],
            'transport_distance' => $validated['transport_distance'],
            'electricity_usage' => $validated['electricity_usage'] ?? 0,
            'waste_generation' => $validated['waste_generation'] ?? 0,
            'carbon_footprint' => $carbonFootprint,
        ]);

        // Check for achievements - force refresh user data
        $user = $request->user()->fresh();
        $this->achievementService->checkAchievements($user);

        return redirect()->route('activity-logs.index', ['refresh' => time()])
            ->with('success', 'Your planet-saving activity has been updated! Great job!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        $this->authorize('delete', $activityLog);

        $user = request()->user()->fresh();
        $activityLog->delete();

        // Recalculate achievements after deletion
        $this->achievementService->checkAchievements($user);

        return redirect()->route('activity-logs.index', ['refresh' => time()])
            ->with('success', 'Activity log removed successfully!');
    }
}
