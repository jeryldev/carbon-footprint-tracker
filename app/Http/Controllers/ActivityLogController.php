<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\CarbonCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    protected $carbonCalculationService;

    public function __construct(CarbonCalculationService $carbonCalculationService)
    {
        $this->carbonCalculationService = $carbonCalculationService;
    }

    /**
     * Show the form for creating a new activity log.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $transportTypes = [
            'walking' => 'Walking/Cycling (0 emission)',
            'motorcycle' => 'Motorcycle',
            'car' => 'Car (private)',
            'taxi' => 'Taxi/Grab',
            'jeepney' => 'Jeepney',
            'bus' => 'Bus',
            'train' => 'Train/Metro',
        ];

        return view('activity-logs.create', [
            'transportTypes' => $transportTypes,
            'today' => now()->toDateString(),
        ]);
    }

    /**
     * Store a newly created activity log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'transport_type' => 'required|string',
            'transport_distance' => 'required|numeric|min:0',
            'electricity_usage' => 'nullable|numeric|min:0',
            'waste_generation' => 'nullable|numeric|min:0',
        ]);

        // Calculate carbon footprint
        $carbonFootprint = $this->carbonCalculationService->calculateTotalFootprint(
            $validated['transport_type'],
            $validated['transport_distance'],
            $validated['electricity_usage'] ?? 0,
            $validated['waste_generation'] ?? 0
        );

        // Create activity log
        Auth::user()->activityLogs()->create([
            'date' => $validated['date'],
            'transport_type' => $validated['transport_type'],
            'transport_distance' => $validated['transport_distance'],
            'electricity_usage' => $validated['electricity_usage'] ?? 0,
            'waste_generation' => $validated['waste_generation'] ?? 0,
            'carbon_footprint' => $carbonFootprint,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Activity log saved successfully!');
    }

    /**
     * Display the user's activity history.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $activityLogs = Auth::user()->activityLogs()
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('activity-logs.index', [
            'activityLogs' => $activityLogs,
        ]);
    }

    /**
     * Show the form for editing the specified activity log.
     *
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\View\View
     */
    public function edit(ActivityLog $activityLog)
    {
        $this->authorize('update', $activityLog);

        $transportTypes = [
            'walking' => 'Walking/Cycling (0 emission)',
            'motorcycle' => 'Motorcycle',
            'car' => 'Car (private)',
            'taxi' => 'Taxi/Grab',
            'jeepney' => 'Jeepney',
            'bus' => 'Bus',
            'train' => 'Train/Metro',
        ];

        return view('activity-logs.edit', [
            'activityLog' => $activityLog,
            'transportTypes' => $transportTypes,
        ]);
    }

    /**
     * Update the specified activity log.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        $this->authorize('update', $activityLog);

        $validated = $request->validate([
            'date' => 'required|date',
            'transport_type' => 'required|string',
            'transport_distance' => 'required|numeric|min:0',
            'electricity_usage' => 'nullable|numeric|min:0',
            'waste_generation' => 'nullable|numeric|min:0',
        ]);

        // Recalculate carbon footprint
        $carbonFootprint = $this->carbonCalculationService->calculateTotalFootprint(
            $validated['transport_type'],
            $validated['transport_distance'],
            $validated['electricity_usage'] ?? 0,
            $validated['waste_generation'] ?? 0
        );

        // Update activity log
        $activityLog->update([
            'date' => $validated['date'],
            'transport_type' => $validated['transport_type'],
            'transport_distance' => $validated['transport_distance'],
            'electricity_usage' => $validated['electricity_usage'] ?? 0,
            'waste_generation' => $validated['waste_generation'] ?? 0,
            'carbon_footprint' => $carbonFootprint,
        ]);

        return redirect()->route('activity-logs.index')
            ->with('success', 'Activity log updated successfully!');
    }

    /**
     * Remove the specified activity log.
     *
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ActivityLog $activityLog)
    {
        $this->authorize('delete', $activityLog);

        $activityLog->delete();

        return redirect()->route('activity-logs.index')
            ->with('success', 'Activity log deleted successfully!');
    }
}
