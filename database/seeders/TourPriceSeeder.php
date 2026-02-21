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
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 54.99,
                    'age_range' => '12+',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 32.99,
                    'age_range' => '5-11',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'age_range' => '0-4',
                    'is_free' => true
                ],
            ],

            'caminata-nocturna' => [
                [
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 55.99,
                    'age_range' => '12+',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 32.99,
                    'age_range' => '5-11',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'age_range' => '0-4',
                    'is_free' => true
                ],
            ],

            'entrada-admision-natura' => [
                [
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 41.99,
                    'age_range' => '12+',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 24.99,
                    'age_range' => '5-11',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'age_range' => '0-4',
                    'is_free' => true
                ],
            ],

            'photography-tour' => [
                [
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 129.99,
                    'age_range' => '12+',
                    'is_free' => false
                ],
            ],
            'bird-watching-tour' => [
                [
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'price' => 62.99,
                    'age_range' => '12+',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño', 'en' => 'Child'],
                    'price' => 37.99,
                    'age_range' => '5-11',
                    'is_free' => false
                ],
                [
                    'type' => ['es' => 'Niño pequeño', 'en' => 'Young Child'],
                    'price' => 0,
                    'age_range' => '0-4',
                    'is_free' => true
                ],
            ],
            'poza-el-salto' => [
                [
                    'type' => ['es' => 'Entrada General', 'en' => 'General Access'],
                    'price' => 0,
                    'age_range' => 'Todas las edades / All ages',
                    'is_free' => true
                ],
            ],

        ];

        foreach ($prices as $slug => $tourPrices) {

            $tour = Tour::where('slug', $slug)->first();

            if (!$tour) {
                continue;
            }

            // Limpia precios anteriores
            $tour->prices()->delete();

            // Inserta uno por uno (más seguro que createMany)
            foreach ($tourPrices as $price) {
                $tour->prices()->create($price);
            }
        }
    }
}
