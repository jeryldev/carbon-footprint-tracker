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
        Schema::create('emission_factors', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // transportation, electricity, waste
            $table->string('type'); // specific type within category (car, motorcycle, etc.)
            $table->float('value', 12, 8); // the emission factor value (allowing for precision)
            $table->string('unit'); // e.g., kg_co2_per_km
            $table->text('description')->nullable();
            $table->string('source_reference')->nullable(); // Reference to source study
            $table->timestamps();

            // Index for faster lookups
            $table->index(['category', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_factors');
    }
};
