<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourDetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [

            'natura-plus' => [
                'full_description' => [
                    'es' => 'Acércate a las salvajes, extrañas y maravillosas criaturas de Costa Rica en un recorrido por el Natura Eco Park. Recorre senderos naturales junto a un guía experto y descubre la increíble biodiversidad que hace única a La Fortuna.',
                    'en' => 'Get up close to the wild, strange, and wonderful creatures of Costa Rica on a guided tour through Natura Eco Park. Walk scenic trails with an expert naturalist and discover the incredible biodiversity that makes La Fortuna unique.',
                ],
                'duration' => '2 horas',
                'start_hours_text' => '8 a.m. – 9:30 a.m. - 10:00 a.m. - 12:30 p.m. - 2:30 p.m. - 3:30 p.m.',
                'includes' => [
                    'es' => [
                        'Guía naturalista certificado',
                        'Entrada al parque',
                        'Senderos ecológicos',
                    ],
                    'en' => [
                        'Certified naturalist guide',
                        'Park entrance',
                        'Ecological walking trails',
                    ],
                ],
                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Parejas',
                        'Amantes de la naturaleza',
                    ],
                    'en' => [
                        'Families',
                        'Couples',
                        'Nature lovers',
                    ],
                ],
                'location_text' => 'La Fortuna',
                'distance_km' => 5,
                'distance_miles' => 3.1,
            ],

            'caminata-nocturna' => [
                'full_description' => [
                    'es' => 'Cuando cae la noche, la selva revela su lado más fascinante y misterioso. Esta experiencia nocturna te invita a explorar una reserva privada mientras más del 90% de sus especies despiertan y el bosque cobra vida a tu alrededor.

Acompañado por un guía naturalista experto, recorrerás senderos bajo la oscuridad en busca de perezosos, armadillos, aves nocturnas y múltiples especies de ranas.

Exclusiva, envolvente e inolvidable. Una aventura diseñada para quienes desean vivir la selva en su estado más puro.',

                    'en' => 'As night falls, the rainforest reveals its most fascinating and mysterious side. This exclusive nighttime experience invites you to explore a private reserve where over 90% of its species come to life.

Guided by an expert naturalist, you will walk through forest trails in search of sloths, armadillos, nocturnal birds, and multiple frog species.

Exclusive, immersive, and unforgettable. An adventure designed for those who want to experience the rainforest in its purest form.',
                ],
                'duration' => '2 horas',
                'start_hours_text' => '6:00 p.m.',
                'includes' => [
                    'es' => [
                        'Guía naturalista certificado',
                        'Recorrido nocturno guiado',
                        'Observación de fauna nocturna',
                        'Acceso a reserva privada',
                    ],
                    'en' => [
                        'Certified naturalist guide',
                        'Guided night walk',
                        'Nocturnal wildlife observation',
                        'Private reserve access',
                    ],
                ],
                'ideal_for' => [
                    'es' => [
                        'Amantes de la naturaleza',
                        'Fotógrafos',
                        'Familias',
                        'Viajeros en busca de experiencias únicas',
                    ],
                    'en' => [
                        'Nature lovers',
                        'Photographers',
                        'Families',
                        'Travelers seeking unique experiences',
                    ],
                ],
                'location_text' => 'Natura Eco Park, La Fortuna',
                'distance_km' => 5,
                'distance_miles' => 3.1,
            ],
        ];

        foreach ($details as $slug => $data) {
            $tour = Tour::where('slug', $slug)->first();

            if ($tour) {
                $tour->detail()->updateOrCreate(
                    ['tour_id' => $tour->id],
                    $data
                );
            }
        }
    }
}
