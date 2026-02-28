<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

return new class extends Migration {
    public function up(): void
    {
        $exchangeRate = (float) DB::table('settings')
            ->where('key', 'usd_to_crc')
            ->value('value') ?? 500;

        $prices = DB::table('tour_prices')->get();

        foreach ($prices as $price) {

            if ($price->currency === 'CRC') {

                $priceInUsd = round($price->price / $exchangeRate, 2);

                DB::table('tour_prices')
                    ->where('id', $price->id)
                    ->update([
                        'price' => $priceInUsd,
                        'currency' => 'USD'
                    ]);
            }
        }
    }

    public function down(): void
    {
        // no revertimos
    }
};
