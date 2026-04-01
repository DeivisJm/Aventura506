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
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Public content
            |--------------------------------------------------------------------------
            */
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('short_description');
            $table->json('location')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Administrative fields
            |--------------------------------------------------------------------------
            */
            $table->string('host_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('external_url', 2048);

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */
            $table->string('main_image')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Basic card information
            |--------------------------------------------------------------------------
            */
            $table->unsignedInteger('guests')->nullable();
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('beds')->nullable();
            $table->unsignedInteger('bathrooms')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Feature tags
            |--------------------------------------------------------------------------
            */
            $table->json('amenities')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Display control
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};