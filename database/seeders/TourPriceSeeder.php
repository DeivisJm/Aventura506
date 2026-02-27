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
                    'currency' => 'USD',
                    'price' => 54.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 32.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'USD',
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
                    'currency' => 'USD',
                    'price' => 55.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 32.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'USD',
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
                    'currency' => 'USD',
                    'price' => 41.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 24.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'USD',
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
                    'currency' => 'USD',
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
                    'currency' => 'USD',
                    'price' => 62.99,
                    'min_age' => 12,
                    'max_age' => null,
                    'is_free' => false
                ],
                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 37.99,
                    'min_age' => 5,
                    'max_age' => 11,
                    'is_free' => false
                ],
                [
                    'type_key' => 'young_child',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'USD',
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
                    'currency' => 'USD',
                    'price' => 0,
                    'min_age' => null,
                    'max_age' => null,
                    'is_free' => true
                ],
            ],
            'catarata-rio-fortuna' => [
                // 🇨🇷 Nacionales
                [
                    'type_key' => 'adult_national',
                    'type' => ['es' => 'Adultos Nacionales', 'en' => 'National Adults'],
                    'price' => 10,
                    'currency' => 'CRC',
                    'min_age' => 9,
                    'max_age' => null,
                    'is_free' => false,
                    'category_type' => 'national',
                ],

                [
                    'type_key' => 'child_national',
                    'type' => ['es' => 'Niños Nacionales', 'en' => 'National Children'],
                    'currency' => 'CRC',
                    'price' => 5,
                    'min_age' => 0,
                    'max_age' => 8,
                    'is_free' => false,
                    'category_type' => 'national',
                ],


                [
                    'type_key' => 'senior_national',
                    'type' => ['es' => 'Adultos Mayores Nacionales', 'en' => 'National Seniors'],
                    'currency' => 'CRC',
                    'price' => 5,
                    'min_age' => 65,
                    'max_age' => null,
                    'is_free' => false,
                    'category_type' => 'national',
                ],

                // Extranjeros
                [
                    'type_key' => 'adult_international',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'currency' => 'USD',
                    'price' => 20,
                    'min_age' => 9,
                    'max_age' => null,
                    'is_free' => false,
                    'category_type' => 'international',
                ],

                [
                    'type_key' => 'child_international',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 8,
                    'is_free' => true,
                    'category_type' => 'international',
                ],

            ],
            'catarata-rio-celeste' => [

                // 🇨🇷 RESIDENTES
                [
                    'type_key' => 'adult_national',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'currency' => 'CRC',
                    'price' => 800,
                    'min_age' => 13,
                    'max_age' => 64,
                    'is_free' => false,
                    'category_type' => 'national',
                ],

                [
                    'type_key' => 'child_national',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'CRC',
                    'price' => 500,
                    'min_age' => 2,
                    'max_age' => 12,
                    'is_free' => false,
                    'category_type' => 'national',
                ],

                [
                    'type_key' => 'young_child_national',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'CRC',
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 1,
                    'is_free' => true,
                    'category_type' => 'national',
                ],

                [
                    'type_key' => 'senior_national',
                    'type' => ['es' => 'Adultos mayores', 'en' => 'Senior Adults'],
                    'currency' => 'CRC',
                    'price' => 0,
                    'min_age' => 65,
                    'max_age' => null,
                    'is_free' => true,
                    'category_type' => 'national',
                ],

                // 🌎 NO RESIDENTES
                [
                    'type_key' => 'adult_international',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'currency' => 'USD',
                    'price' => 12,
                    'min_age' => 13,
                    'max_age' => null,
                    'is_free' => false,
                    'category_type' => 'international',
                ],

                [
                    'type_key' => 'child_international',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 5,
                    'min_age' => 2,
                    'max_age' => 12,
                    'is_free' => false,
                    'category_type' => 'international',
                ],

                [
                    'type_key' => 'young_child_international',
                    'type' => ['es' => 'Niños pequeños', 'en' => 'Young Children'],
                    'currency' => 'USD',
                    'price' => 0,
                    'min_age' => 0,
                    'max_age' => 1,
                    'is_free' => true,
                    'category_type' => 'international',
                ],
            ],
            'horseback-riding-tour' => [
                [
                    'type_key' => 'general',
                    'type' => ['es' => 'Precio por Persona', 'en' => 'Price for Person'],
                    'currency' => 'USD',
                    'price' => 30,
                    'min_age' => null,
                    'max_age' => null,
                    'is_free' => false
                ],
            ],
            'sky-adventures-zipline' => [

                [
                    'type_key' => 'adult',
                    'type' => ['es' => 'Adultos', 'en' => 'Adults'],
                    'currency' => 'USD',
                    'price' => 106,
                    'min_age' => 18,
                    'max_age' => null,
                    'is_free' => false
                ],

                [
                    'type_key' => 'child',
                    'type' => ['es' => 'Niños', 'en' => 'Children'],
                    'currency' => 'USD',
                    'price' => 74,
                    'min_age' => 5,
                    'max_age' => 12,
                    'is_free' => false
                ],

                [
                    'type_key' => 'student',
                    'type' => ['es' => 'Estudiantes', 'en' => 'Students'],
                    'currency' => 'USD',
                    'price' => 90,
                    'min_age' => 13,
                    'max_age' => 25,
                    'is_free' => false
                ],

                [
                    'type_key' => 'national',
                    'type' => ['es' => 'Nacionales', 'en' => 'Nationals'],
                    'currency' => 'USD',
                    'price' => 74,
                    'min_age' => null,
                    'max_age' => null,
                    'is_free' => false,
                    'category_type' => 'national'
                ],
            ],
        ];

        foreach ($prices as $slug => $tourPrices) {

            $tour = Tour::where('slug', $slug)->first();

            if (!$tour) {
                continue;
            }

            foreach ($tourPrices as $price) {

                $tour->prices()->updateOrCreate(
                    [
                        'type_key' => $price['type_key'],
                    ],
                    $price
                );
            }
        }
    }
}
