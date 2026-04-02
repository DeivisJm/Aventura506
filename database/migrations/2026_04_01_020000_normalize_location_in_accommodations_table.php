<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert the location column from JSON to plain text
     * and normalize existing values.
     */
    public function up(): void
    {
        /**
         * Step 1:
         * Read all current values before changing the column type.
         */
        $rows = DB::table('accommodations')
            ->select('id', 'location')
            ->get();

        $normalizedLocations = [];

        foreach ($rows as $row) {
            $location = $row->location;
            $plainLocation = '';

            if (is_string($location) && trim($location) !== '') {
                $decoded = json_decode($location, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $plainLocation = $decoded['es']
                        ?? $decoded['en']
                        ?? reset($decoded)
                        ?? '';
                } else {
                    $plainLocation = $location;
                }
            }

            $normalizedLocations[$row->id] = $plainLocation;
        }

        /**
         * Step 2:
         * Change the column type from JSON to string.
         */
        Schema::table('accommodations', function (Blueprint $table) {
            $table->string('location', 255)->nullable()->change();
        });

        /**
         * Step 3:
         * Save normalized plain text values back into the column.
         */
        foreach ($normalizedLocations as $id => $plainLocation) {
            DB::table('accommodations')
                ->where('id', $id)
                ->update([
                    'location' => $plainLocation,
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('accommodations', function (Blueprint $table) {
            $table->json('location')->nullable()->change();
        });
    }
};