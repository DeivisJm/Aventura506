<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            // Relation to tour
            $table->foreignId('tour_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Booking data (guest booking allowed)
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('nationality');
            $table->integer('persons');

            $table->date('date');
            $table->string('time');

            $table->decimal('total', 10, 2);

            // Booking workflow status
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])
                  ->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
