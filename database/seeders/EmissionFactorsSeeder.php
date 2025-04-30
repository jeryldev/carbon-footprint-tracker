<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionFactorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * These emission factors are based on the following study:
     *
     * Cortes, A. C. (2022). Greenhouse Gas Emissions Inventory of a University in the Philippines:
     * the Case of UP Cebu. Philippine Journal of Science, 151(3), 901-912.
     * https://doi.org/10.56899/151.03.10
     */
    public function run(): void
    {
        DB::table('emission_factors')->insert([
            // Transportation emission factors (kg CO2/km)
            [
                'category' => 'transportation',
                'type' => 'walk',
                'value' => 0.0,
                'unit' => 'kg_co2_per_km',
                'description' => 'Walking - Zero emissions',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'transportation',
                'type' => 'bicycle',
                'value' => 0.0,
                'unit' => 'kg_co2_per_km',
                'description' => 'Bicycle - Zero emissions',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'transportation',
                'type' => 'motorcycle',
                'value' => 0.1174424,
                'unit' => 'kg_co2_per_km',
                'description' => 'Motorcycle emissions factor',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'transportation',
                'type' => 'car',
                'value' => 0.2118934,
                'unit' => 'kg_co2_per_km',
                'description' => 'Car emissions factor (average)',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'transportation',
                'type' => 'public_transit',
                'value' => 0.2883241,
                'unit' => 'kg_co2_per_km',
                'description' => 'Public transit (bus, jeepney) emissions factor',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Electricity emissions (kg CO2/kWh)
            [
                'category' => 'electricity',
                'type' => 'grid',
                'value' => 0.5070,
                'unit' => 'kg_co2_per_kwh',
                'description' => 'Electricity grid emissions factor (Visayas grid)',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Waste emissions (kg CO2/kg waste)
            [
                'category' => 'waste',
                'type' => 'general',
                'value' => 1.84,
                'unit' => 'kg_co2_per_kg_waste',
                'description' => 'General waste emissions factor',
                'source_reference' => 'https://doi.org/10.56899/151.03.10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
