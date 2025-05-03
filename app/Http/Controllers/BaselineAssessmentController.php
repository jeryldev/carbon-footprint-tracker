<?php

namespace App\Http\Controllers;

use App\Models\BaselineAssessment;
use App\Models\EmissionFactor;
use Illuminate\Http\Request;

class BaselineAssessmentController extends Controller
{
    /**
     * Show the form for creating a new baseline assessment.
     */
    public function create()
    {
        $user = auth()->user();
        $transportTypes = EmissionFactor::getTransportTypes();

        return view('baseline-assessment.create', [
            'user' => $user,
            'transportTypes' => $transportTypes,
        ]);
    }

    /**
     * Store a newly created baseline assessment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'typical_commute_type' => ['required', 'string'],
            'typical_commute_distance' => ['required', 'numeric', 'min:0'],
            'commute_days_per_week' => ['required', 'integer', 'min:0', 'max:7'],
            'average_electricity_usage' => ['nullable', 'numeric', 'min:0'],
            'average_waste_generation' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = auth()->user();
        $baselineAssessment = $user->baselineAssessment ?? new BaselineAssessment();
        $baselineAssessment->user_id = $user->id;
        $baselineAssessment->typical_commute_type = $validated['typical_commute_type'];
        $baselineAssessment->typical_commute_distance = $validated['typical_commute_distance'];
        $baselineAssessment->commute_days_per_week = $validated['commute_days_per_week'];
        $baselineAssessment->average_electricity_usage = $validated['average_electricity_usage'] ?? 0;
        $baselineAssessment->average_waste_generation = $validated['average_waste_generation'] ?? 0;
        $baselineAssessment->calculateBaseline();

        return redirect()->route('dashboard')->with('success', 'Your planet-saving journey has begun!');
    }

    /**
     * Show the form for editing the baseline assessment.
     */
    public function edit()
    {
        $user = auth()->user();
        $baselineAssessment = $user->baselineAssessment;
        $transportTypes = EmissionFactor::getTransportTypes();

        return view('baseline-assessment.edit', [
            'user' => $user,
            'baselineAssessment' => $baselineAssessment,
            'transportTypes' => $transportTypes,
        ]);
    }

    /**
     * Update the specified baseline assessment.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'typical_commute_type' => ['required', 'string'],
            'typical_commute_distance' => ['required', 'numeric', 'min:0'],
            'commute_days_per_week' => ['required', 'integer', 'min:0', 'max:7'],
            'average_electricity_usage' => ['nullable', 'numeric', 'min:0'],
            'average_waste_generation' => ['nullable', 'numeric', 'min:0'],
        ]);

        $user = auth()->user();
        $baselineAssessment = $user->baselineAssessment;

        if (!$baselineAssessment) {
            return redirect()->route('baseline-assessment.create');
        }

        $baselineAssessment->typical_commute_type = $validated['typical_commute_type'];
        $baselineAssessment->typical_commute_distance = $validated['typical_commute_distance'];
        $baselineAssessment->commute_days_per_week = $validated['commute_days_per_week'];
        $baselineAssessment->average_electricity_usage = $validated['average_electricity_usage'] ?? 0;
        $baselineAssessment->average_waste_generation = $validated['average_waste_generation'] ?? 0;
        $baselineAssessment->calculateBaseline();

        return redirect()->route('dashboard')->with('success', 'Your planet-saving profile has been updated!');
    }
}
