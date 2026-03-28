<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();

            $table->json('name');
            $table->string('slug')->unique();

            $table->json('short_description')->nullable();
            $table->json('description')->nullable();

            $table->string('image')->nullable();
            $table->json('gallery')->nullable();

            $table->json('property_type')->nullable();
            $table->json('location_text')->nullable();

            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            $table->decimal('price_per_night', 10, 2)->default(0);
            $table->string('currency', 10)->default('USD');

            $table->unsignedInteger('max_guests')->default(1);
            $table->unsignedInteger('bedrooms')->default(1);
            $table->unsignedInteger('beds')->default(1);
            $table->unsignedInteger('bathrooms')->default(1);
            $table->unsignedInteger('size_m2')->nullable();

            $table->string('check_in_time')->nullable();
            $table->string('check_out_time')->nullable();

            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('reviews_count')->default(0);

            $table->json('amenities')->nullable();
            $table->json('house_rules')->nullable();
            $table->json('includes')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};