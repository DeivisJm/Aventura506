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
                'location_text' => 'Natura Eco Park, La Fortuna',
                'distance_km' => 5,
                'distance_miles' => 3.1,
            ],
            'entrada-admision-natura' => [
                'full_description' => [
                    'es' => 'Descubre Natura Eco Park a tu propio ritmo con un pase de día completo. Diseña tu propio itinerario y explora senderos naturales que conducen a impresionantes hábitats.

Visita el estanque de tortugas, el lago de cocodrilos y el jardín de ranas más grande del país. Observa aves coloridas, mariposas vibrantes y delicadas orquídeas en esta experiencia biológica perfecta para todas las edades.

Libertad total, naturaleza auténtica y una aventura ideal para compartir en familia.',

                    'en' => 'Discover Natura Eco Park at your own pace with a full-day pass. Create your own itinerary and explore scenic trails leading to stunning wildlife habitats.

Visit the turtle pond, crocodile lake, and the largest frog garden in the country. Spot colorful birds, vibrant butterflies, and delicate orchids in this biological adventure perfect for all ages.

Total freedom, authentic nature, and the perfect experience to enjoy with family and friends.',
                ],
                'duration' => [
                    'es' => 'Personalizado',
                    'en' => 'Flexible Duration',
                ],
                'start_hours_text' => '8:30 a.m. – 4:30 p.m.',
                'includes' => [
                    'es' => [
                        'Acceso completo al parque',
                        'Mapa del parque',
                        'Acceso a todos los hábitats',
                    ],
                    'en' => [
                        'Full park access',
                        'Park map',
                        'Access to all habitats',
                    ],
                ],
                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Viajeros independientes',
                        'Amantes de la naturaleza',
                    ],
                    'en' => [
                        'Families',
                        'Independent travelers',
                        'Nature lovers',
                    ],
                ],
                'location_text' => 'Natura Eco Park, La Fortuna',
                'distance_km' => 5,
                'distance_miles' => 3.1,
            ],

            'photography-tour' => [
                'full_description' => [
                    'es' => 'Tome fotos dignas de un cuadro en la magnífica selva tropical de Costa Rica durante un recorrido fotográfico en el Parque Ecológico Natura en La Fortuna.

Traiga su cámara y capture imágenes en el entorno natural virgen de esta reserva privada. Un guía naturalista lo llevará por senderos y diversos hábitats donde podrá observar especies exóticas listas para sus primeros planos.

Fotografíe cocodrilos, ranas arborícolas, serpientes, mariposas y delicadas orquídeas en esta experiencia diseñada para amantes de la fotografía. Convierta sus mejores tomas en recuerdos inolvidables de su viaje.',

                    'en' => 'Take frame-worthy photos of Costa Rica’s magnificent rainforest on a photography tour at Natura Eco Park in La Fortuna.

Bring your camera and capture stunning shots in the untouched environment of this private reserve. A naturalist guide will lead you through jungle trails and diverse habitats where exotic wildlife is ready for close-ups.

Photograph crocodiles, tree frogs, snakes, butterflies, delicate orchids, and tropical flora in this experience designed for photography lovers. Turn your best shots into unforgettable travel memories.',
                ],
                'duration' => [
                    'es' => '3 horas',
                    'en' => '3 hours',
                ],
                'start_hours_text' => [
                    'es' => '9:00 a.m. y 3:00 p.m.',
                    'en' => '9:00 a.m. and 3:00 p.m.',
                ],
                'includes' => [
                    'es' => [
                        'Guía naturalista certificado',
                        'Acceso completo al parque',
                        'Recorrido especializado en fotografía',
                    ],
                    'en' => [
                        'Certified naturalist guide',
                        'Full park access',
                        'Specialized photography experience',
                    ],
                ],
                'ideal_for' => [
                    'es' => [
                        'Fotógrafos',
                        'Amantes de la naturaleza',
                        'Viajeros que buscan experiencias únicas',
                    ],
                    'en' => [
                        'Photographers',
                        'Nature lovers',
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
