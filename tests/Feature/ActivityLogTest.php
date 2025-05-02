<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\BaselineAssessment;
use App\Models\EmissionFactor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Create emission factors
        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'car',
            'value' => 0.2118934,
            'unit' => 'kg_co2_per_km',
            'description' => 'Car (private)',
            'source_reference' => 'Cortes, 2022',
        ]);

        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'walk',
            'value' => 0.0,
            'unit' => 'kg_co2_per_km',
            'description' => 'Walking - Zero emissions',
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

        // Create a baseline assessment for the user for testing
        BaselineAssessment::create([
            'user_id' => $this->user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000,
        ]);
    }

    #[Test]
    public function user_can_view_activity_log_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('activity-logs.create'));

        $response->assertStatus(200);
        $response->assertViewIs('activity-logs.create');
    }

    #[Test]
    public function user_can_create_activity_log()
    {
        $response = $this->actingAs($this->user)
            ->post(route('activity-logs.store'), [
                'date' => '2025-05-01',
                'transport_type' => 'car',
                'transport_distance' => 10,
                'electricity_usage' => 5,
                'waste_generation' => 2,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
        ]);
    }

    #[Test]
    public function user_can_create_activity_log_with_unknown_transport_type()
    {
        $response = $this->actingAs($this->user)
            ->post(route('activity-logs.store'), [
                'date' => '2025-05-01',
                'transport_type' => 'unknown_vehicle',
                'transport_distance' => 10,
                'electricity_usage' => 5,
                'waste_generation' => 2,
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'transport_type' => 'unknown_vehicle',
        ]);
    }

    #[Test]
    public function user_can_view_activity_logs()
    {
        // We'll need to mock the months query since it's causing issues in tests
        $this->mock(\App\Services\ActivityLogService::class, function ($mock) {
            $mock->shouldReceive('getMonthlyLogs')->andReturn(collect());
        });

        // Create an activity log
        ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => Carbon::today()->format('Y-m-d'),
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
            'carbon_footprint' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('activity-logs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('activity-logs.index');
    }

    #[Test]
    public function user_can_edit_activity_log()
    {
        // Create an activity log
        $activityLog = ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => '2025-05-01',
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
            'carbon_footprint' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('activity-logs.edit', $activityLog));

        $response->assertStatus(200);
        $response->assertViewIs('activity-logs.edit');
    }

    #[Test]
    public function user_can_update_activity_log()
    {
        // Create an activity log
        $activityLog = ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => '2025-05-01',
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
            'carbon_footprint' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('activity-logs.update', $activityLog), [
                'transport_type' => 'walk',
                'transport_distance' => 5,
                'electricity_usage' => 3,
                'waste_generation' => 1,
            ]);

        $response->assertRedirect(route('activity-logs.index'));

        $this->assertDatabaseHas('activity_logs', [
            'id' => $activityLog->id,
            'transport_type' => 'walk',
            'transport_distance' => 5,
            'electricity_usage' => 3,
            'waste_generation' => 1,
        ]);
    }

    #[Test]
    public function user_can_delete_activity_log()
    {
        // Create an activity log
        $activityLog = ActivityLog::create([
            'user_id' => $this->user->id,
            'date' => '2025-05-01',
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
            'carbon_footprint' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('activity-logs.destroy', $activityLog));

        $response->assertRedirect(route('activity-logs.index'));

        $this->assertDatabaseMissing('activity_logs', [
            'id' => $activityLog->id,
        ]);
    }
}
