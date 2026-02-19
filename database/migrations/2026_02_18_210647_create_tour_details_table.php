<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_details', function (Blueprint $table) {
            $table->id();

            // Relation to tours table
            $table->foreignId('tour_id')
                ->constrained()
                ->onDelete('cascade');

            // Full marketing description
            $table->longText('full_description')->nullable();

            // Structured info
            $table->string('duration')->nullable();
            $table->string('start_hours_text')->nullable();

            // JSON fields for flexible content
            $table->json('includes')->nullable();
            $table->json('ideal_for')->nullable();

            // Location
            $table->text('location_text')->nullable();
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('distance_miles', 8, 2)->nullable();

            $table->text('map_embed_url')->nullable();
            $table->text('map_directions_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_details');
    }
};
