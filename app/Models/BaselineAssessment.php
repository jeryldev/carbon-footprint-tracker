<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaselineAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'typical_commute_type',
        'typical_commute_distance',
        'commute_days_per_week',
        'average_electricity_usage',
        'average_waste_generation',
        'baseline_carbon_footprint',
    ];

    protected $casts = [
        'typical_commute_distance' => 'float',
        'commute_days_per_week' => 'integer',
        'average_electricity_usage' => 'float',
        'average_waste_generation' => 'float',
        'baseline_carbon_footprint' => 'float',
    ];

    /**
     * Calculate and set the baseline carbon footprint.
     *
     * @return float The calculated baseline carbon footprint
     */
    public function calculateBaseline(): float
    {
        $transportFactor = EmissionFactor::where('category', 'transportation')
            ->where('type', $this->typical_commute_type)
            ->value('value') ?? 0;

        $electricityFactor = EmissionFactor::where('category', 'electricity')
            ->where('type', 'grid')
            ->value('value') ?? 0;

        $wasteFactor = EmissionFactor::where('category', 'waste')
            ->where('type', 'general')
            ->value('value') ?? 0;

        // Calculate annual transportation emissions
        // Daily commute distance * 2 (round trip) * days per week * 52 weeks per year
        $yearlyDistance = $this->typical_commute_distance * 2 * $this->commute_days_per_week * 52;
        $transportEmissions = $yearlyDistance * $transportFactor;

        // Calculate annual electricity emissions
        // Monthly usage * 12 months
        $yearlyElectricity = $this->average_electricity_usage * 12;
        $electricityEmissions = $yearlyElectricity * $electricityFactor;

        // Calculate annual waste emissions
        // Daily waste * 365 days
        $yearlyWaste = $this->average_waste_generation * 365;
        $wasteEmissions = $yearlyWaste * $wasteFactor;

        // Calculate total annual emissions
        $totalEmissions = $transportEmissions + $electricityEmissions + $wasteEmissions;

        // Save the calculated baseline
        $this->baseline_carbon_footprint = $totalEmissions;
        $this->save();

        return $totalEmissions;
    }
}
