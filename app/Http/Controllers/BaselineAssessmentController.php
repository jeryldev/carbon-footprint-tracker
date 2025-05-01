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

        // Create or update the baseline assessment
        $baselineAssessment = $user->baselineAssessment ?? new BaselineAssessment();
        $baselineAssessment->user_id = $user->id;
        $baselineAssessment->fill($validated);

        // Calculate baseline carbon footprint
        $baselineAssessment->calculateBaseline();
        $baselineAssessment->save();

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
        $baselineAssessment->fill($validated);

        // Recalculate baseline carbon footprint
        $baselineAssessment->calculateBaseline();
        $baselineAssessment->save();

        return redirect()->route('dashboard')->with('success', 'Your planet-saving profile has been updated!');
    }
}
