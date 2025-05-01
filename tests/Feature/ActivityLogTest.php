<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EmissionFactor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

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
            'description' => 'Public transit (bus, jeepney) emissions factor',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'transportation',
            'type' => 'car',
            'value' => 0.2118934,
            'unit' => 'kg_co2_per_km',
            'description' => 'Car (private)',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'electricity',
            'type' => 'grid',
            'value' => 0.5070000,
            'unit' => 'kg_co2_per_kwh',
            'description' => 'Philippine grid electricity',
            'source_reference' => 'Test',
        ]);

        EmissionFactor::create([
            'category' => 'waste',
            'type' => 'general',
            'value' => 1.84,
            'unit' => 'kg_co2_per_kg_waste',
            'description' => 'General waste to landfill',
            'source_reference' => 'Test',
        ]);
    }

    /** @test */
    public function user_can_view_activity_log_form()
    {
        $response = $this->actingAs($this->user)
            ->get(route('activity-logs.create'));

        $response->assertStatus(200);
        $response->assertViewIs('activity-logs.create');
    }

    /** @test */
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
            'date' => '2025-05-01',
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
        ]);
    }

    /** @test */
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

        // The activity should be stored with the unknown transport type
        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $this->user->id,
            'transport_type' => 'unknown_vehicle',
        ]);

        // But the carbon calculation should have used public_transit as the default
        $activityLog = $this->user->activityLogs()->where('transport_type', 'unknown_vehicle')->first();
        $expectedEmission = (0.2883241 * 10) + (0.5070000 * 5) + (1.84 * 2);
        $this->assertEquals($expectedEmission, $activityLog->carbon_footprint);
    }

    /** @test */
    public function user_can_view_activity_logs()
    {
        // Create an activity log for the user
        $this->user->activityLogs()->create([
            'date' => '2025-05-01',
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
        $response->assertViewHas('activityLogs');
    }

    /** @test */
    public function user_can_edit_activity_log()
    {
        // Create an activity log for the user
        $activityLog = $this->user->activityLogs()->create([
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

    /** @test */
    public function user_can_update_activity_log()
    {
        // Create an activity log for the user
        $activityLog = $this->user->activityLogs()->create([
            'date' => '2025-05-01',
            'transport_type' => 'car',
            'transport_distance' => 10,
            'electricity_usage' => 5,
            'waste_generation' => 2,
            'carbon_footprint' => 10,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('activity-logs.update', $activityLog), [
                'date' => '2025-05-02',
                'transport_type' => 'public_transit',
                'transport_distance' => 15,
                'electricity_usage' => 7,
                'waste_generation' => 3,
            ]);

        $response->assertRedirect(route('activity-logs.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('activity_logs', [
            'id' => $activityLog->id,
            'date' => '2025-05-02',
            'transport_type' => 'public_transit',
            'transport_distance' => 15,
            'electricity_usage' => 7,
            'waste_generation' => 3,
        ]);
    }

    /** @test */
    public function user_can_delete_activity_log()
    {
        // Create an activity log for the user
        $activityLog = $this->user->activityLogs()->create([
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
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('activity_logs', [
            'id' => $activityLog->id,
        ]);
    }
}
