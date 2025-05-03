<?php

namespace Database\Seeders;

use App\Models\EcoRecommendation;
use Illuminate\Database\Seeder;

class EcoRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * These friendly tips help users find easy ways to protect our planet in their everyday activities.
     */
    public function run(): void
    {
        $recommendations = [
            // Transportation recommendations
            [
                'category' => 'transportation',
                'tip' => 'Walk or ride a bike for short trips instead of going by car',
                'impact_description' => 'Cars use a lot more energy for short trips and create more pollution.',
                'potential_savings' => 500, // grams of CO2 per trip
            ],
            [
                'category' => 'transportation',
                'tip' => 'Do all your errands in one trip instead of making separate trips',
                'impact_description' => 'Planning your trips can cut down your travel pollution by almost half!',
                'potential_savings' => 800,
            ],
            [
                'category' => 'transportation',
                'tip' => 'Make sure your car tires have enough air in them',
                'impact_description' => 'Tires with the right amount of air help your car use less fuel.',
                'potential_savings' => 300,
            ],
            [
                'category' => 'transportation',
                'tip' => 'Share rides with friends, family or classmates',
                'impact_description' => 'When more people ride in one car, less pollution is made per person.',
                'potential_savings' => 1000,
            ],
            [
                'category' => 'transportation',
                'tip' => 'Take the bus or train instead of driving alone',
                'impact_description' => 'Public transportation creates less pollution than everyone driving separate cars.',
                'potential_savings' => 1200,
            ],

            // Electricity recommendations
            [
                'category' => 'electricity',
                'tip' => 'Unplug chargers and devices when you\'re not using them',
                'impact_description' => 'Even when turned off, plugged-in devices still use some electricity.',
                'potential_savings' => 200,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Open curtains during the day instead of turning on lights',
                'impact_description' => 'Sunlight is free and doesn\'t use any electricity!',
                'potential_savings' => 150,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Wash clothes in cold water instead of hot water',
                'impact_description' => 'Most of the energy your washing machine uses goes to heating water.',
                'potential_savings' => 250,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Use a laptop instead of a desktop computer when you can',
                'impact_description' => 'Laptops use much less electricity than big desktop computers.',
                'potential_savings' => 180,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Hang clothes to dry instead of using a dryer',
                'impact_description' => 'Clothes dryers use lots of electricity, but the sun and air are free!',
                'potential_savings' => 300,
            ],

            // Waste recommendations
            [
                'category' => 'waste',
                'tip' => 'Turn food scraps into compost instead of throwing them in the trash',
                'impact_description' => 'Food waste in landfills creates methane, a harmful gas that warms our planet.',
                'potential_savings' => 700,
            ],
            [
                'category' => 'waste',
                'tip' => 'Use reusable containers instead of plastic bags or wrap',
                'impact_description' => 'Making and throwing away plastic creates pollution.',
                'potential_savings' => 400,
            ],
            [
                'category' => 'waste',
                'tip' => 'Try to fix broken things instead of buying new ones',
                'impact_description' => 'Making new products takes lots of energy and materials.',
                'potential_savings' => 900,
            ],
            [
                'category' => 'waste',
                'tip' => 'Give away things you don\'t need anymore instead of throwing them away',
                'impact_description' => 'When others reuse your items, they don\'t need to buy new ones.',
                'potential_savings' => 500,
            ],
            [
                'category' => 'waste',
                'tip' => 'Use digital documents instead of printing on paper',
                'impact_description' => 'Making paper uses trees and lots of energy.',
                'potential_savings' => 350,
            ],

            // Additional mixed recommendations
            [
                'category' => 'transportation',
                'tip' => 'Plan your route before you leave to avoid getting lost',
                'impact_description' => 'Driving around lost uses extra fuel and creates more pollution.',
                'potential_savings' => 450,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Use LED light bulbs instead of old-style bulbs',
                'impact_description' => 'LED lights use way less electricity and last much longer!',
                'potential_savings' => 420,
            ],
            [
                'category' => 'waste',
                'tip' => 'Choose products with less packaging when shopping',
                'impact_description' => 'Extra packaging just becomes trash that has to be thrown away.',
                'potential_savings' => 380,
            ],
            [
                'category' => 'electricity',
                'tip' => 'Use power strips to turn off many devices at once',
                'impact_description' => 'With one switch, you can stop several devices from using electricity.',
                'potential_savings' => 270,
            ],
            [
                'category' => 'waste',
                'tip' => 'Bring your own bags when you go shopping',
                'impact_description' => 'Reusable bags can be used hundreds of times instead of plastic bags that get thrown away.',
                'potential_savings' => 330,
            ],
        ];

        foreach ($recommendations as $recommendation) {
            EcoRecommendation::create($recommendation);
        }
    }
}
