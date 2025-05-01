<?php

namespace Tests\Unit;

use App\Models\EmissionFactor;
use App\Services\CarbonCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarbonCalculationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        // Create test emission factors
        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'public_transit',
            'value' => 0.2883241,
            'unit' => 'kg_co2_per_km',
            'description' => 'Public transit emissions factor',
            'source_reference' => 'Cortes, 2022',
        ]);

        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'car',
            'value' => 0.2118934,
            'unit' => 'kg_co2_per_km',
            'description' => 'Car (private)',
            'source_reference' => 'Cortes, 2022',
        ]);

        EmissionFactor::create([
            'category' => 'electricity',
            'type' => 'grid',
            'value' => 0.5070000,
            'unit' => 'kg_co2_per_kwh',
            'description' => 'Philippine grid electricity',
            'source_reference' => 'Cortes, 2022',
        ]);

        EmissionFactor::create([
            'category' => 'waste',
            'type' => 'general',
            'value' => 1.84,
            'unit' => 'kg_co2_per_kg_waste',
            'description' => 'General waste to landfill',
            'source_reference' => 'Cortes, 2022',
        ]);

        $this->service = new CarbonCalculationService();
    }

    #[Test]
    public function it_calculates_transport_emission_correctly()
    {
        $emission = $this->service->calculateTransportEmission('car', 10);
        $this->assertEquals(2.118934, $emission);
    }

    #[Test]
    public function it_uses_public_transit_as_default_when_transport_type_not_found()
    {
        $emission = $this->service->calculateTransportEmission('unknown_type', 10);
        $this->assertEquals(2.883241, $emission); // Using public_transit value
    }

    #[Test]
    public function it_calculates_electricity_emission_correctly()
    {
        $emission = $this->service->calculateElectricityEmission(5);
        $this->assertEquals(2.535, $emission);
    }

    #[Test]
    public function it_calculates_waste_emission_correctly()
    {
        $emission = $this->service->calculateWasteEmission(2);
        $this->assertEquals(3.68, $emission);
    }

    #[Test]
    public function it_calculates_total_footprint_correctly()
    {
        $emission = $this->service->calculateTotalFootprint('car', 10, 5, 2);
        $expectedTotal = 2.118934 + 2.535 + 3.68;
        $this->assertEquals($expectedTotal, $emission);
    }
}
