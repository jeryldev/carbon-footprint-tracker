<?php

namespace Database\Seeders;

use App\Models\EcoRecommendation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmissionFactorSeeder::class,
            AchievementSeeder::class,
            EcoRecommendationSeeder::class
        ]);
    }
}
