<?php

namespace App\Http\Controllers;

use App\Models\EmissionFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BaselineAssessmentController extends Controller
{
    /**
     * Display the baseline assessment form.
     */
    public function create(): View
    {
        $user = Auth::user();
        $assessment = $user->getOrCreateBaselineAssessment();
        $transportTypes = EmissionFactor::getTransportTypes();

        return view('baseline-assessment.create', [
            'assessment' => $assessment,
            'transportTypes' => $transportTypes,
        ]);
    }

    /**
     * Store the baseline assessment data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'typical_commute_type' => 'required|string|in:walk,bicycle,motorcycle,car,public_transit',
            'typical_commute_distance' => 'required|numeric|min:0',
            'commute_days_per_week' => 'required|integer|min:0|max:7',
            'average_electricity_usage' => 'required|numeric|min:0',
            'average_waste_generation' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $assessment = $user->getOrCreateBaselineAssessment();

        $assessment->fill($validated);

        // Calculate the baseline carbon footprint
        $baseline = $assessment->calculateBaseline();
        $assessment->baseline_carbon_footprint = $baseline;

        $assessment->save();

        return redirect()->route('dashboard')->with('status', 'baseline-saved');
    }
}
