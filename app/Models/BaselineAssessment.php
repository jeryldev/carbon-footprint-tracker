<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\EmissionFactor;

class BaselineAssessment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'typical_commute_type',
        'typical_commute_distance',
        'commute_days_per_week',
        'average_electricity_usage',
        'average_waste_generation',
        'baseline_carbon_footprint',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'typical_commute_distance' => 'float',
        'commute_days_per_week' => 'integer',
        'average_electricity_usage' => 'float',
        'average_waste_generation' => 'float',
        'baseline_carbon_footprint' => 'float',
    ];

    /**
     * Get the user that owns the baseline assessment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate the baseline carbon footprint based on provided data.
     *
     * @return float
     */
    public function calculateBaseline(): float
    {
        $total = 0;

        // Calculate transportation emissions
        if ($this->typical_commute_type && $this->typical_commute_distance) {
            $emissionFactor = $this->getTransportEmissionFactor($this->typical_commute_type);
            // Daily commute distance * 2 (round trip) * days per week * 52 weeks per year
            $yearlyDistance = $this->typical_commute_distance * 2 * $this->commute_days_per_week * 52;
            $commuteEmissions = $yearlyDistance * $emissionFactor;
            $total += $commuteEmissions;
        }

        // Calculate electricity emissions
        if ($this->average_electricity_usage) {
            $electricityFactor = $this->getElectricityEmissionFactor();
            // Monthly usage * 12 months per year
            $yearlyElectricity = $this->average_electricity_usage * 12;
            $electricityEmissions = $yearlyElectricity * $electricityFactor;
            $total += $electricityEmissions;
        }

        // Calculate waste emissions
        if ($this->average_waste_generation) {
            $wasteFactor = $this->getWasteEmissionFactor();
            // Daily waste * 365 days per year
            $yearlyWaste = $this->average_waste_generation * 365;
            $wasteEmissions = $yearlyWaste * $wasteFactor;
            $total += $wasteEmissions;
        }

        return $total;
    }

    /**
     * Get emission factor for transportation mode.
     *
     * @param string $transportType
     * @return float
     */
    private function getTransportEmissionFactor(string $transportType): float
    {
        $factor = EmissionFactor::where('category', 'transportation')
            ->where('type', $transportType)
            ->value('value');

        return $factor ?? 0.0;
    }

    /**
     * Get emission factor for electricity.
     *
     * @return float
     */
    private function getElectricityEmissionFactor(): float
    {
        $factor = EmissionFactor::where('category', 'electricity')
            ->where('type', 'grid')
            ->value('value');

        return $factor ?? 0.0;
    }

    /**
     * Get emission factor for waste.
     *
     * @return float
     */
    private function getWasteEmissionFactor(): float
    {
        $factor = EmissionFactor::where('category', 'waste')
            ->where('type', 'general')
            ->value('value');

        return $factor ?? 0.0;
    }
}
