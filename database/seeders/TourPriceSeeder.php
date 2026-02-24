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
                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 54.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 32.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 4,
                    'is_free' => true
                ],
            ],

            'caminata-nocturna' => [
                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 55.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 32.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 4,
                    'is_free' => true
                ],
            ],

            'entrada-admision-natura' => [
                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 41.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 24.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 4,
                    'is_free' => true
                ],
            ],

            'photography-tour' => [
                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 129.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
            ],

            'bird-watching-tour' => [
                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 62.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 37.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 4,
                    'is_free' => true
                ],
            ],

            'poza-el-salto' => [
                [
                    'type_key' => 'general_access',
                    'type' => ['es' => 'Entrada General', 'en' => 'General Access'],
                    'price' => 0,
                    'min_age' => null,
                    'max_age' => null,
                    'is_free' => true
                ],
            ],

        ];

        foreach ($prices as $slug => $tourPrices) {

            $tour = Tour::where('slug', $slug)->first();

            if (!$tour) {
                continue;
            }

            $tour->prices()->delete();

            foreach ($tourPrices as $price) {
                $tour->prices()->create($price);
            }
        }
    }
}
