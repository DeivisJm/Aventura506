<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Company;

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

                'image' => 'images/tours/nature/natura-plus.jpg',
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

                'image' => 'images/tours/nature/caminata-nocturna.jpg',
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

                'image' => 'images/tours/nature/admision-natura.JPG',
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
                'image' => 'images/tours/nature/photography-tour.jpg',
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

                'image' => 'images/tours/nature/bird-watching-tour.jpg',
            ],
            [
                'company_name' => 'Espacio Publico',
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

                'image' => 'images/tours/water/poza-el-salto.jpg',
            ],
            [
                'company_name' => 'Parque Nacional Volcán Arenal',
                'name' => [
                    'es' => 'Catarata Río Fortuna',
                    'en' => 'La Fortuna Waterfall',
                ],
                'slug' => 'catarata-rio-fortuna',
                'category' => 'water',
                'description' => [
                    'es' => 'La icónica Catarata Río Fortuna: más de 70 metros de majestuosidad natural rodeada de selva tropical en Costa Rica.',
                    'en' => 'The iconic La Fortuna Waterfall: over 70 meters of natural majesty surrounded by tropical rainforest in Costa Rica.',
                ],
                'image' => 'images/tours/water/catarata-rio-fortuna.jpg',
            ],
            [
                'company_name' => 'Parque Nacional Volcán Tenorio',

                'name' => [
                    'es' => 'Catarata Río Celeste',
                    'en' => 'Rio Celeste Waterfall',
                ],

                'slug' => 'catarata-rio-celeste',
                'category' => 'water',

                'description' => [
                    'es' => 'Descubra el impresionante Río Celeste y su famosa catarata azul turquesa en el Parque Nacional Volcán Tenorio.',
                    'en' => 'Discover the breathtaking Rio Celeste and its iconic turquoise waterfall in Tenorio Volcano National Park.',
                ],

                'image' => 'images/tours/water/rio-celeste.jpg',
            ],
            [
                'company_name' => 'Nature Tours La Fortuna',
                'name' => [
                    'es' => 'Tour de Cabalgata',
                    'en' => 'Horseback Riding Tour',
                ],
                'slug' => 'horseback-riding-tour',
                'category' => 'horseback',
                'description' => [
                    'es' => 'Vive una cabalgata de 2 horas por senderos naturales, ríos y fincas, rodeado de paisajes exuberantes y tranquilidad.',
                    'en' => 'Experience a 2-hour horseback ride through natural trails, rivers, and farms, surrounded by lush scenery and tranquility.',
                ],

                'image' => 'images/tours/horseback/horseback-riding.jpg',
            ],
            [
                'company_name' => 'Sky Adventures Arenal',
                'name' => [
                    'es' => 'Sky Adventures – Tirolesas',
                    'en' => 'Sky Adventures – Zipline',
                ],
                'slug' => 'sky-adventures-zipline',
                'category' => 'adventure',
                'description' => [
                    'es' => 'Las únicas tirolesas de Costa Rica con vista al Volcán Arenal y al Lago Arenal.',
                    'en' => 'Costa Rica’s only zipline with views of Arenal Volcano and Lake Arenal.',
                ],
                'image' => 'images/tours/adventure/sky-adventures-zipline.jpg',
            ],
        ];

        foreach ($tours as $tourData) {

            $company = Company::firstOrCreate([
                'name' => $tourData['company_name']
            ]);

            $category = Category::firstOrCreate([
                'slug' => $tourData['category']
            ], [
                'name' => ucfirst($tourData['category'])
            ]);

            $tour = Tour::updateOrCreate(
                ['slug' => $tourData['slug']],
                [
                    'company_id' => $company->id,
                    'category_id' => $category->id,
                    'name' => $tourData['name'],
                    'slug' => $tourData['slug'],
                    'description' => $tourData['description'],
                    'image' => $tourData['image'],
                    'active' => true,
                ]
            );
        }
    }
}
