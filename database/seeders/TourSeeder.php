<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'company_name' => 'Natura Costa Rica',
                'name' => 'Natura Plus',
                'slug' => 'natura-plus',
                'category' => 'nature',
                'description' => [
                    'es' => 'Recorrido ecológico por Natura Eco Park en La Fortuna.',
                    'en' => 'Ecological tour through Natura Eco Park in La Fortuna.',
                ],

                'price' => 54.99,
                'distance_km' => 5,
                'distance_miles' => 3.1,
                'location_text' => 'La Fortuna, San Carlos',
                'image' => 'images/tours/natura-plus.jpg',
            ],
            [
                'company_name' => 'Natura Costa Rica',
                'name' => 'Caminata Nocturna',
                'slug' => 'caminata-nocturna',
                'category' => 'nature',
                'description' => [
                    'es' => 'Una experiencia nocturna exclusiva en la selva tropical.',
                    'en' => 'An exclusive nighttime experience in the tropical rainforest.',
                ],
                'price' => 65.00,
                'distance_km' => 5,
                'distance_miles' => 3.1,
                'location_text' => 'La Fortuna, San Carlos',
                'image' => 'images/tours/caminata-nocturna.jpg',
            ]
        ];

        foreach ($tours as $tour) {
            Tour::updateOrCreate(
                ['slug' => $tour['slug']],
                array_merge($tour, [
                    'map_embed_url' => null,
                    'map_directions_url' => null,
                    'is_active' => true,
                ])
            );
        }
    }
}
