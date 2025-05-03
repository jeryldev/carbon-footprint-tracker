<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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

        // For each user, check if they have achievements already
        User::all()->each(function ($user) use ($achievements) {
            // Only create achievements if user doesn't have any
            if ($user->achievements()->count() === 0) {
                foreach ($achievements as $achievement) {
                    Achievement::create([
                        'user_id' => $user->id,
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
        });
    }
}
