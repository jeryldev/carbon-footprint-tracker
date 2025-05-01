<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('baseline_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Transportation
            $table->string('typical_commute_type')->nullable(); // car, bike, walk, public transit, etc.
            $table->float('typical_commute_distance')->nullable(); // in kilometers
            $table->integer('commute_days_per_week')->nullable()->default(5); // number of days commuting per week

            // Energy consumption
            $table->float('average_electricity_usage')->nullable(); // in kWh per month

            // Waste generation
            $table->float('average_waste_generation')->nullable(); // in kg per day

            // Calculated baseline carbon footprint
            $table->float('baseline_carbon_footprint')->nullable(); // total annual kg CO2e

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baseline_assessments');
    }
};
