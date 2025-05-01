<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\BaselineAssessment;
use App\Models\EmissionFactor;
use App\Services\CarbonReportingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarbonReportingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Create test emission factors
        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'public_transit',
            'value' => 0.2883241,
            'unit' => 'kg_co2_per_km',
            'description' => 'Public transit emissions factor',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'car',
            'value' => 0.2118934,
            'unit' => 'kg_co2_per_km',
            'description' => 'Car emissions factor',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'electricity',
            'type' => 'grid',
            'value' => 0.5070000,
            'unit' => 'kg_co2_per_kwh',
            'description' => 'Electricity grid emissions factor',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'waste',
            'type' => 'general',
            'value' => 1.84,
            'unit' => 'kg_co2_per_kg_waste',
            'description' => 'General waste emissions factor',
            'source_reference' => 'Test',
        ]);

        // Create the service
        $this->service = new CarbonReportingService();

        // Freeze time to ensure consistent test results
        Carbon::setTestNow(Carbon::create(2025, 5, 1, 12, 0, 0));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow(); // Clear the mock
        parent::tearDown();
    }

    /** @test */
    public function it_returns_no_baseline_response_when_user_has_no_baseline()
    {
        $savings = $this->service->getSavings($this->user, 'today');

        $this->assertNull($savings['is_saving']);
        $this->assertEquals(0, $savings['savings']);
        $this->assertEquals(0, $savings['trees_saved']);
        $this->assertEquals(0, $savings['car_kilometers']);
        $this->assertEquals(0, $savings['ice_saved']);
        $this->assertEquals(0, $savings['superhero_points']);
        $this->assertEquals(0, $savings['days_tracked']);
        $this->assertEquals("Complete your baseline assessment to see how you're helping the planet!", $savings['message']);
    }

    /** @test */
    public function it_calculates_savings_correctly_when_under_baseline_for_today()
    {
        // Create baseline assessment (1000 kg per year = ~2.74 kg per day)
        $baseline = BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000, // 1000 kg CO2e per year
        ]);

        // Create activity log for today with less emissions than baseline
        ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => Carbon::today(),
            'transport_type' => 'public_transit',
            'transport_distance' => 5,
            'electricity_usage' => 2,
            'waste_generation' => 0.5,
            'carbon_footprint' => 1.5, // Less than daily baseline (2.74 kg)
        ]);

        $savings = $this->service->getSavings($this->user, 'today');

        // Expected savings ~1.24 kg (2.74 - 1.5)
        $this->assertTrue($savings['is_saving']);
        $this->assertGreaterThan(1, $savings['savings']);
        $this->assertLessThan(1.5, $savings['savings']);

        // Check tree days calculation (savings / 0.06)
        $expectedTreeDays = round($savings['savings'] / 0.06);
        $this->assertEquals($expectedTreeDays, $savings['trees_saved']);

        // Check car kilometers (savings / 0.2118934)
        $expectedCarKm = round($savings['savings'] / 0.2118934);
        $this->assertEquals($expectedCarKm, $savings['car_kilometers']);

        // Check ice saved (savings * 3)
        $expectedIceSaved = round($savings['savings'] * 3);
        $this->assertEquals($expectedIceSaved, $savings['ice_saved']);

        // Check superhero points (savings * 10)
        $expectedPoints = round($savings['savings'] * 10);
        $this->assertEquals($expectedPoints, $savings['superhero_points']);

        $this->assertEquals(1, $savings['days_tracked']);
        $this->assertStringContainsString('Great job today', $savings['message']);
    }

    /** @test */
    public function it_calculates_negative_savings_correctly_when_over_baseline_for_today()
    {
        // Create baseline assessment (1000 kg per year = ~2.74 kg per day)
        $baseline = BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000, // 1000 kg CO2e per year
        ]);

        // Create activity log for today with more emissions than baseline
        ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => Carbon::today(),
            'transport_type' => 'car',
            'transport_distance' => 20,
            'electricity_usage' => 10,
            'waste_generation' => 2,
            'carbon_footprint' => 10, // More than daily baseline (2.74 kg)
        ]);

        $savings = $this->service->getSavings($this->user, 'today');

        // Should show not saving
        $this->assertFalse($savings['is_saving']);
        // Savings should be positive (the absolute difference)
        $this->assertGreaterThan(7, $savings['savings']);
        // All the positive metrics should be 0
        $this->assertEquals(0, $savings['trees_saved']);
        $this->assertEquals(0, $savings['car_kilometers']);
        $this->assertEquals(0, $savings['ice_saved']);
        $this->assertEquals(0, $savings['superhero_points']);
        $this->assertEquals(1, $savings['days_tracked']);
        $this->assertStringContainsString('Oops! You used more carbon than usual', $savings['message']);
    }

    /** @test */
    public function it_calculates_weekly_savings_correctly()
    {
        // Create baseline assessment (1000 kg per year = ~2.74 kg per day, ~19.18 kg per week)
        $baseline = BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000, // 1000 kg CO2e per year
        ]);

        // Create activity logs for this week (5 days with 1.5 kg each = 7.5 kg)
        for ($i = 0; $i < 5; $i++) {
            ActivityLog::create([
                'user_id' => $this->user->id,
                'date' => Carbon::now()->startOfWeek()->addDays($i),
                'transport_type' => 'public_transit',
                'transport_distance' => 5,
                'electricity_usage' => 2,
                'waste_generation' => 0.5,
                'carbon_footprint' => 1.5,
            ]);
        }

        $savings = $this->service->getSavings($this->user, 'week');

        // Expected weekly savings ~11.68 kg (19.18 - 7.5)
        $this->assertTrue($savings['is_saving']);
        $this->assertGreaterThan(11, $savings['savings']);
        $this->assertLessThan(12, $savings['savings']);
        $this->assertEquals(5, $savings['days_tracked']);
        $this->assertStringContainsString('this week', $savings['message']);
    }

    /** @test */
    public function it_calculates_monthly_savings_correctly()
    {
        // Create baseline assessment (1000 kg per year = ~2.74 kg per day, ~82.19 kg per month)
        $baseline = BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000, // 1000 kg CO2e per year
        ]);

        // Create activity logs for this month (20 days with 1.5 kg each = 30 kg)
        for ($i = 0; $i < 20; $i++) {
            ActivityLog::create([
                'user_id' => $this->user->id,
                'date' => Carbon::now()->startOfMonth()->addDays($i),
                'transport_type' => 'public_transit',
                'transport_distance' => 5,
                'electricity_usage' => 2,
                'waste_generation' => 0.5,
                'carbon_footprint' => 1.5,
            ]);
        }

        $savings = $this->service->getSavings($this->user, 'month');

        // Expected monthly savings ~52.19 kg (82.19 - 30)
        $this->assertTrue($savings['is_saving']);
        $this->assertGreaterThan(52, $savings['savings']);
        $this->assertLessThan(53, $savings['savings']);
        $this->assertEquals(20, $savings['days_tracked']);
        $this->assertStringContainsString('this month', $savings['message']);
        // High savings should get the superhero message
        $this->assertStringContainsString('superhero', $savings['message']);
    }

    /** @test */
    public function it_handles_unknown_period_by_defaulting_to_today()
    {
        // Create baseline assessment
        $baseline = BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000,
        ]);

        // Create activity log for today
        ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => Carbon::today(),
            'transport_type' => 'public_transit',
            'transport_distance' => 5,
            'electricity_usage' => 2,
            'waste_generation' => 0.5,
            'carbon_footprint' => 1.5,
        ]);

        // Test with invalid period
        $savings = $this->service->getSavings($this->user, 'invalid_period');

        // Should default to today's metrics
        $this->assertTrue($savings['is_saving']);
        $this->assertEquals(1, $savings['days_tracked']);
        $this->assertStringContainsString('today', $savings['message']);
    }
}
