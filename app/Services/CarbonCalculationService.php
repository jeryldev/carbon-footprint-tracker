<?php

namespace App\Services;

use App\Models\EmissionFactor;

class CarbonCalculationService
{
    /**
     * Calculate carbon emission from transportation
     *
     * @param string $transportType
     * @param float $distance in kilometers
     * @return float Carbon emission in kg CO2e
     */
    public function calculateTransportEmission(string $transportType, float $distance): float
    {
        $emissionFactor = EmissionFactor::where('category', 'transportation')
            ->where('type', $transportType)
            ->first();

        if (!$emissionFactor) {
            // Default to public_transit if specific transport type not found
            $emissionFactor = EmissionFactor::where('category', 'transportation')
                ->where('type', 'public_transit')
                ->first();
        }

        // Formula: CE = AD × EF × GWP₁₀₀
        // Where CE is carbon emission, AD is distance, EF is emission factor
        return $distance * $emissionFactor->value;
    }

    /**
     * Calculate carbon emission from electricity usage
     *
     * @param float $electricityUsage in kWh
     * @return float Carbon emission in kg CO2e
     */
    public function calculateElectricityEmission(float $electricityUsage): float
    {
        $emissionFactor = EmissionFactor::where('category', 'electricity')
            ->where('type', 'grid')
            ->first();

        return $electricityUsage * $emissionFactor->value;
    }

    /**
     * Calculate carbon emission from waste generation
     *
     * @param float $wasteGeneration in kg
     * @return float Carbon emission in kg CO2e
     */
    public function calculateWasteEmission(float $wasteGeneration): float
    {
        $emissionFactor = EmissionFactor::where('category', 'waste')
            ->where('type', 'general')
            ->first();

        return $wasteGeneration * $emissionFactor->value;
    }

    /**
     * Calculate total carbon footprint from all sources
     *
     * @param string $transportType
     * @param float $distance
     * @param float $electricityUsage
     * @param float $wasteGeneration
     * @return float Total carbon footprint in kg CO2e
     */
    public function calculateTotalFootprint(
        string $transportType,
        float $distance,
        float $electricityUsage = 0,
        float $wasteGeneration = 0
    ): float {
        $transportEmission = $this->calculateTransportEmission($transportType, $distance);
        $electricityEmission = $this->calculateElectricityEmission($electricityUsage);
        $wasteEmission = $this->calculateWasteEmission($wasteGeneration);

        return $transportEmission + $electricityEmission + $wasteEmission;
    }

    /**
     * Calculate what the carbon footprint would be using baseline transportation
     *
     * @param string $baselineTransportType
     * @param float $distance
     * @param float $electricityUsage
     * @param float $wasteGeneration
     * @return float Expected carbon footprint in kg CO2e
     */
    public function calculateBaselineFootprint(
        string $baselineTransportType,
        float $distance,
        float $electricityUsage = 0,
        float $wasteGeneration = 0
    ): float {
        $transportEmission = $this->calculateTransportEmission($baselineTransportType, $distance);
        $electricityEmission = $this->calculateElectricityEmission($electricityUsage);
        $wasteEmission = $this->calculateWasteEmission($wasteGeneration);

        return $transportEmission + $electricityEmission + $wasteEmission;
    }
}
