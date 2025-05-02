<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\BaselineAssessment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        // Users are redirected to baseline-assessment.create if they don't have a baseline assessment
        $response->assertRedirect(route('baseline-assessment.create', absolute: false));
    }

    // Optional: Add a test for users with baseline assessments
    public function test_users_with_baseline_can_authenticate_and_go_to_dashboard(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create a baseline assessment for this user
        BaselineAssessment::create([
            'user_id' => $user->id,
            'typical_commute_type' => 'car',
            'typical_commute_distance' => 10,
            'commute_days_per_week' => 5,
            'average_electricity_usage' => 100,
            'average_waste_generation' => 1,
            'baseline_carbon_footprint' => 1000 // Non-null carbon footprint
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
