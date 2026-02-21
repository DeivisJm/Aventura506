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
                'company_name' => 'Natura Eco Park Costa Rica',
                'name' => [
                    'es' => 'Natura Plus',
                    'en' => 'Natura Plus Admission',
                ],
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
                'company_name' => 'Natura Eco Park Costa Rica',
                'name' => [
                    'es' => 'Caminata Nocturna - Experiencia ',
                    'en' => 'Night Walk Experience Tour',
                ],

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
            ],
            [
                'company_name' => 'Natura Eco Park Costa Rica',
                'name' => [
                    'es' => 'Entrada – Admisión Natura (Autoguiado)',
                    'en' => 'Natura Admission – Self-Guided',
                ],
                'slug' => 'entrada-admision-natura',
                'category' => 'nature',
                'description' => [
                    'es' => 'Pase de un día para explorar Natura Eco Park a tu propio ritmo.',
                    'en' => 'One-day pass to explore Natura Eco Park at your own pace.',
                ],
                'price' => 41.99,
                'distance_km' => 5,
                'distance_miles' => 3.1,
                'location_text' => 'La Fortuna, San Carlos',
                'image' => 'images/tours/admision-natura.JPG',
            ],
            [
                'company_name' => 'Natura Eco Park Costa Rica',
                'name' => [
                    'es' => 'Tour de Fotografía',
                    'en' => 'Photography Tour',
                ],
                'slug' => 'photography-tour',
                'category' => 'nature',
                'description' => [
                    'es' => 'Recorrido fotográfico guiado en Natura Eco Park para capturar la belleza de la selva tropical.',
                    'en' => 'Guided photography experience at Natura Eco Park to capture the beauty of the rainforest.',
                ],
                'price' => 129.99,
                'distance_km' => 5,
                'distance_miles' => 3.1,
                'location_text' => 'Natura Eco Park, La Fortuna',
                'image' => 'images/tours/photography-tour.jpg',
            ],
            [
                'company_name' => 'Natura Eco Park Costa Rica',
                'name' => [
                    'es' => 'Observación de Aves',
                    'en' => 'Bird Watching Tour',
                ],
                'slug' => 'bird-watching-tour',
                'category' => 'nature',
                'description' => [
                    'es' => 'Descubre aves exóticas al amanecer en una experiencia privada en la selva tropical.',
                    'en' => 'Discover exotic birds at sunrise in a private rainforest experience.',
                ],
                'price' => 62.99,
                'distance_km' => 3,
                'distance_miles' => 1.8,
                'location_text' => 'Natura Eco Park, La Fortuna',
                'image' => 'images/tours/bird-watching-tour.jpg',
            ],

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
