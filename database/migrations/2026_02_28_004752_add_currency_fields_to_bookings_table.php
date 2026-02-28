<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            if (!Schema::hasColumn('bookings', 'currency')) {
                $table->string('currency')->default('USD');
            }

            if (!Schema::hasColumn('bookings', 'exchange_rate')) {
                $table->decimal('exchange_rate', 10, 2)->default(500);
            }

            if (!Schema::hasColumn('bookings', 'total_usd')) {
                $table->decimal('total_usd', 10, 2)->nullable();
            }

            if (!Schema::hasColumn('bookings', 'total_crc')) {
                $table->decimal('total_crc', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('bookings', 'total_display')) {
                $table->decimal('total_display', 12, 2)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn([
                'currency',
                'exchange_rate',
                'total_usd',
                'total_crc',
                'total_display'
            ]);
        });
    }
};
