<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use Illuminate\Database\Seeder;

class AccommodationSeeder extends Seeder
{
    public function run(): void
    {
        Accommodation::create([
            'name' => [
                'es' => 'Cabaña Vista al Volcán',
                'en' => 'Volcano View Cabin',
            ],
            'slug' => 'cabana-vista-al-volcan',
            'short_description' => [
                'es' => 'Una cabaña acogedora con vistas espectaculares al volcán y rodeada de naturaleza.',
                'en' => 'A cozy cabin with spectacular volcano views surrounded by nature.',
            ],
            'description' => [
                'es' => 'Disfruta de una experiencia relajante en una cabaña privada con jacuzzi, terraza y desayuno incluido.',
                'en' => 'Enjoy a relaxing experience in a private cabin with jacuzzi, terrace, and breakfast included.',
            ],
            'image' => 'images/accommodations/cabana-volcan.jpg',
            'gallery' => [
                'images/accommodations/cabana-volcan.jpg',
                'images/accommodations/cabana-volcan-2.jpg',
            ],
            'property_type' => [
                'es' => 'Cabaña completa',
                'en' => 'Entire cabin',
            ],
            'location_text' => [
                'es' => 'La Fortuna, San Carlos',
                'en' => 'La Fortuna, San Carlos',
            ],
            'province' => 'Alajuela',
            'city' => 'La Fortuna',
            'address' => 'Camino al volcán',
            'price_per_night' => 145.00,
            'currency' => 'USD',
            'max_guests' => 4,
            'bedrooms' => 2,
            'beds' => 2,
            'bathrooms' => 1,
            'size_m2' => 65,
            'check_in_time' => '15:00',
            'check_out_time' => '11:00',
            'rating' => 4.90,
            'reviews_count' => 128,
            'amenities' => [
                'es' => ['Wifi', 'Jacuzzi', 'Desayuno', 'Parqueo', 'Aire acondicionado'],
                'en' => ['Wifi', 'Jacuzzi', 'Breakfast', 'Parking', 'Air conditioning'],
            ],
            'house_rules' => [
                'es' => ['No fumar', 'No mascotas', 'No fiestas'],
                'en' => ['No smoking', 'No pets', 'No parties'],
            ],
            'includes' => [
                'es' => ['Toallas', 'Cocina equipada', 'Café'],
                'en' => ['Towels', 'Equipped kitchen', 'Coffee'],
            ],
            'is_featured' => true,
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}