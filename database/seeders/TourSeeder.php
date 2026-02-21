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
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410373!2d-84.69038492631479!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771645171910!5m2!1ses-419!2scr',
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
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410373!2d-84.69038492631479!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771645171910!5m2!1ses-419!2scr',
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
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410373!2d-84.69038492631479!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771645171910!5m2!1ses-419!2scr',
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
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410373!2d-84.69038492631479!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771645171910!5m2!1ses-419!2scr',
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
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3923.0068449410373!2d-84.69038492631479!3d10.50012598963233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00be24fb9cb8d%3A0x88ad54fe810999!2sNatura%20Eco%20Park%20-%20Costa%20Rica!5e0!3m2!1ses-419!2scr!4v1771645171910!5m2!1ses-419!2scr',
                'image' => 'images/tours/bird-watching-tour.jpg',
            ],
            [
                'company_name' => 'Natural Public Spot',
                'name' => [
                    'es' => 'Poza El Salto',
                    'en' => 'El Salto River Pool',
                ],
                'slug' => 'poza-el-salto',
                'category' => 'water',
                'description' => [
                    'es' => 'Un espacio natural gratuito ideal para refrescarse y disfrutar del río en La Fortuna.',
                    'en' => 'A free natural river spot perfect for cooling off and enjoying nature in La Fortuna.',
                ],
                'price' => 0,
                'distance_km' => 4,
                'distance_miles' => 2.5,
                'location_text' => 'La Fortuna, San Carlos',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1961.7663149585128!2d-84.64486245557248!3d10.45861250000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa00d64b670b961%3A0x176ede279f5f79cf!2sParqueo%20Hijos%20del%20agua%2C%20Poza%20El%20Salto!5e0!3m2!1ses-419!2scr!4v1771648312967!5m2!1ses-419!2scr',
                'image' => 'images/tours/poza-el-salto.jpg',
            ],

        ];

        foreach ($tours as $tour) {

            $tour['map_directions_url'] = null;
            $tour['is_active'] = true;

            Tour::updateOrCreate(
                ['slug' => $tour['slug']],
                $tour
            );
        }
    }
}
