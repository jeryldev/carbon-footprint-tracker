<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EmissionFactor;
use App\Services\CarbonCalculationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    protected $carbonCalculationService;

    public function __construct(CarbonCalculationService $carbonCalculationService)
    {
        $this->carbonCalculationService = $carbonCalculationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $month = $request->query('month') ? Carbon::parse($request->query('month')) : Carbon::now();

        $activityLogs = $user->activityLogs()
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->orderBy('date', 'desc')
            ->get();

        $months = $user->activityLogs()
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM date) as year, EXTRACT(MONTH FROM date) as month')
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

        // Calculate baseline comparison
        $baselineDailyFootprint = 0;
        if ($user->baselineAssessment) {
            $baselineDailyFootprint = $user->baselineAssessment->baseline_carbon_footprint / 365;
        }
        $comparisonToBaseline = $baselineDailyFootprint - $dailyAverage;
        $isSaving = $comparisonToBaseline > 0;

        // Calculate stats for fun metrics
        $treeDays = max(0, round($comparisonToBaseline * $daysWithLogs / 0.06));
        $iceSaved = max(0, round($comparisonToBaseline * $daysWithLogs * 3));
        $heroPoints = max(0, round($comparisonToBaseline * $daysWithLogs * 10));

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
            'savingsAmount' => abs($comparisonToBaseline) * $daysWithLogs,
            'treeDays' => $treeDays,
            'iceSaved' => $iceSaved,
            'heroPoints' => $heroPoints,
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
            return redirect()->back()->withErrors(['date' => 'You already have a planet log for this day!']);
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

        return redirect()->route('dashboard')
            ->with('success', 'Awesome! Your planet-saving activity has been logged!');
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

        return redirect()->route('activity-logs.index')
            ->with('success', 'Your planet-saving log has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        $this->authorize('delete', $activityLog);

        $activityLog->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Activity log removed successfully!');
    }
}
