<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_details', function (Blueprint $table) {

            // Store original USD price
            $table->decimal('price_usd', 10, 2)->nullable()->after('price');

            // Store converted CRC price
            $table->decimal('price_crc', 12, 2)->nullable()->after('price_usd');
        });
    }

    public function down(): void
    {
        Schema::table('booking_details', function (Blueprint $table) {

            $table->dropColumn(['price_usd', 'price_crc']);
        });
    }
};
