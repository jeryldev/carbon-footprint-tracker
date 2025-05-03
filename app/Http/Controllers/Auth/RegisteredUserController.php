<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create locked achievements for the new user
        $this->createAchievementsForUser($user);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('baseline-assessment.create');
    }

    /**
     * Create default achievements for a user
     */
    private function createAchievementsForUser(User $user): void
    {
        $achievements = [
            [
                'type' => 'activity',
                'name' => 'Planet Protector Rookie',
                'description' => 'Log your first planet-saving activity',
                'icon' => '🌱',
                'points' => 10,
            ],
            [
                'type' => 'activity',
                'name' => 'Eco Warrior',
                'description' => 'Log activities for 7 days in a row',
                'icon' => '🛡️',
                'points' => 50,
            ],
            [
                'type' => 'activity',
                'name' => 'Climate Champion',
                'description' => 'Log activities for 30 days in a row',
                'icon' => '🏆',
                'points' => 200,
            ],
            [
                'type' => 'transport',
                'name' => 'Walking Wonder',
                'description' => 'Choose walking 10 times',
                'icon' => '🚶',
                'points' => 50,
            ],
            [
                'type' => 'transport',
                'name' => 'Cycling Star',
                'description' => 'Choose bicycling 10 times',
                'icon' => '🚲',
                'points' => 50,
            ],
            [
                'type' => 'emission',
                'name' => 'Carbon Crusher',
                'description' => 'Save 50kg of CO2 emissions',
                'icon' => '🌟',
                'points' => 100,
            ],
            [
                'type' => 'emission',
                'name' => 'Tree Guardian',
                'description' => 'Save the equivalent of 100 tree days',
                'icon' => '🌳',
                'points' => 150,
            ],
        ];

        foreach ($achievements as $achievement) {
            $user->achievements()->create([
                'type' => $achievement['type'],
                'name' => $achievement['name'],
                'description' => $achievement['description'],
                'icon' => $achievement['icon'],
                'points' => $achievement['points'],
                'is_unlocked' => false,
                'unlocked_at' => null,
            ]);
        }
    }
}
