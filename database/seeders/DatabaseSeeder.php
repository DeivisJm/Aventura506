<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExchangeRate;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            CategorySeeder::class,
            TourSeeder::class,
            TourDetailSeeder::class,
            TourPriceSeeder::class,
            TourScheduleSeeder::class,
            SuperAdminSeeder::class,
            AccommodationSeeder::class,
        ]);

        ExchangeRate::updateOrCreate(
            ['key' => 'usd_to_crc'],
            ['value' => 500]
        );
    }
}
