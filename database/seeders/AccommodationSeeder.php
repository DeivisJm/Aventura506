<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use Illuminate\Database\Seeder;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accommodation::updateOrCreate(
            ['slug' => 'lake-view-cabin-near-la-fortuna'],
            [
                'name' => [
                    'es' => 'Cabaña con vista al lago cerca de La Fortuna',
                    'en' => 'Lake View Cabin Near La Fortuna',
                ],
                'short_description' => [
                    'es' => 'Hospedaje privado rodeado de naturaleza, ideal para descansar cerca de La Fortuna y disfrutar una experiencia tranquila con acceso cómodo a la zona.',
                    'en' => 'A private nature-surrounded stay, perfect for relaxing near La Fortuna and enjoying a peaceful experience with easy access to the area.',
                ],
                'location' => [
                    'es' => 'San Carlos, Costa Rica',
                    'en' => 'San Carlos, Costa Rica',
                ],
                'host_name' => 'Jorge Mario',
                'phone' => null,
                'external_url' => 'https://www.airbnb.mx/rooms/1648667304664452468?unique_share_id=0f32b737-7353-4990-b6b6-b65567dd5d9c&viralityEntryPoint=1&s=76&source_impression_id=p3_1774752295_P3kBSiiRXnTCpA_k',

                'main_image' => 'images/accommodations/jmario1.jpg',

                'gallery_images' => [
                    'images/accommodations/jmario2.jpg',
                    'images/accommodations/jmario3.jpg',
                    'images/accommodations/jmario4.jpg',
                    'images/accommodations/jmario5.jpg',
                ],

                'guests' => 8,
                'bedrooms' => 3,
                'beds' => 4,
                'bathrooms' => 1,
                'amenities' => [
                    'wifi',
                    'kitchen',
                    'free_parking',
                    'lake_access',
                    'workspace',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ]
        );
    }
}