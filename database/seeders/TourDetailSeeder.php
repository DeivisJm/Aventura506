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
                'duration' => [
                    'es' => '2 horas',
                    'en' => '2 hours',
                ],
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

                // 🔥 NUEVA ESTRUCTURA COMPATIBLE
                'location_name' => 'La Fortuna',
                
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
                'duration' => [
                    'es' => '2 horas',
                    'en' => '2 hours',
                ],
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

                'location_name' => 'Natura Eco Park, La Fortuna',
               
            ],

            'poza-el-salto' => [
                'full_description' => [
                    'es' => 'Poza El Salto es un punto natural gratuito ubicado en las afueras de La Fortuna. Perfecto para nadar, relajarse y disfrutar del entorno del río.

No cuenta con parqueo oficial; la mayoría de visitantes dejan sus vehículos en las orillas de la carretera o en pequeños espacios disponibles si hay suerte.

En el área normalmente encontrarás ventas locales de pinchos, gallos de carne y otros snacks típicos costarricenses.

Es un lugar ideal para disfrutar con amigos o familia sin costo alguno.',
                    'en' => 'El Salto River Pool is a free natural swimming spot located just outside La Fortuna. It is perfect for swimming, relaxing, and enjoying the river environment.

There is no official parking area; most visitors park along the roadside or in small available spaces if they find one.

You will often find local vendors selling grilled skewers, traditional Costa Rican snacks, and small street food options nearby.

It is an ideal place to enjoy with friends and family at no cost.',
                ],
                'duration' => [
                    'es' => 'Libre',
                    'en' => 'Flexible',
                ],
                'start_hours_text' => [
                    'es' => 'Acceso libre',
                    'en' => 'Open access',
                ],
                'includes' => [
                    'es' => [
                        'Acceso gratuito',
                        'Zona natural de río',
                        'Ambiente local',
                    ],
                    'en' => [
                        'Free access',
                        'Natural river area',
                        'Local atmosphere',
                    ],
                ],
                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Viajeros con presupuesto limitado',
                        'Grupos de amigos',
                    ],
                    'en' => [
                        'Families',
                        'Budget travelers',
                        'Groups of friends',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',
                
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