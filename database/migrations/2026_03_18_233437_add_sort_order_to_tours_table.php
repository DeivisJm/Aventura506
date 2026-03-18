<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->nullable()->after('active');
        });

        $tours = DB::table('tours')->orderBy('id')->get();

        foreach ($tours as $index => $tour) {
            DB::table('tours')
                ->where('id', $tour->id)
                ->update(['sort_order' => $index + 1]);
        }
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};