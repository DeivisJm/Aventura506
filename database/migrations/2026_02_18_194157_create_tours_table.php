<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {

            $table->id();

            // Basic tour information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');

            $table->text('description');
            $table->decimal('price', 10, 2);

            // Location data
            $table->integer('distance_km')->nullable();
            $table->integer('distance_miles')->nullable();
            $table->text('location_text')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->text('map_directions_url')->nullable();

            // Image path
            $table->string('image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
