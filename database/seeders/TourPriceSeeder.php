<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourPriceSeeder extends Seeder
{
    public function run(): void
    {
        $prices = [

            'natura-plus' => [
                ['type' => 'Adultos', 'price' => 54.99, 'age_range' => '12+', 'is_free' => false],
                ['type' => 'Niño', 'price' => 32.99, 'age_range' => '5-11', 'is_free' => false],
                ['type' => 'Infante', 'price' => 0, 'age_range' => '0-4', 'is_free' => true],
            ],

            'caminata-nocturna' => [
                ['type' => 'Adultos', 'price' => 55.99, 'age_range' => '12+', 'is_free' => false],
                ['type' => 'Niño', 'price' => 32.99, 'age_range' => '5-11', 'is_free' => false],
                ['type' => 'Infante', 'price' => 0, 'age_range' => '0-4', 'is_free' => true],
            ],
        ];

        foreach ($prices as $slug => $tourPrices) {
            $tour = Tour::where('slug', $slug)->first();

            if ($tour) {
                $tour->prices()->delete(); // limpia antes
                $tour->prices()->createMany($tourPrices);
            }
        }
    }
}
