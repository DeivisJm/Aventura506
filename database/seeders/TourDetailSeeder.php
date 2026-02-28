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
                'start_hours_text' => [
                    'es' => '8:00 a.m. a 3:30 p.m.',
                    'en' => '8:00 a.m. to 3:30 p.m.',
                ],
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
                'recommendations' => [
                    'es' => [
                        'Usar ropa ligera y cómoda para caminatas en senderos naturales.',
                        'Calzado cerrado antideslizante recomendado.',
                        'Aplicar bloqueador solar y repelente biodegradable.',
                        'Llevar botella de agua para mantenerse hidratado.',
                        'Traer cámara para capturar la biodiversidad del parque.',
                        'Seguir siempre las indicaciones del guía naturalista.',
                        'Evitar tocar o alimentar a los animales.',
                    ],
                    'en' => [
                        'Wear light and comfortable clothing suitable for nature trails.',
                        'Closed-toe, non-slip shoes are recommended.',
                        'Use biodegradable sunscreen and insect repellent.',
                        'Bring a water bottle to stay hydrated.',
                        'Carry a camera to capture the park’s biodiversity.',
                        'Always follow the naturalist guide’s instructions.',
                        'Avoid touching or feeding wildlife.',
                    ],
                ],

                // 🔥 NUEVA ESTRUCTURA COMPATIBLE
                'location_name' => 'La Fortuna, San Carlos',

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
                'recommendations' => [
                    'es' => [
                        'Usar ropa oscura y cómoda para caminata nocturna.',
                        'Zapatos cerrados antideslizantes obligatorios.',
                        'Aplicar repelente de insectos antes del tour.',
                        'Evitar el uso de luces fuertes o flash sin autorización del guía.',
                        'Mantener silencio para facilitar la observación de fauna.',
                        'No tocar animales ni vegetación.',
                    ],
                    'en' => [
                        'Wear dark and comfortable clothing for the night walk.',
                        'Closed-toe, non-slip shoes are mandatory.',
                        'Apply insect repellent before the tour.',
                        'Avoid using strong lights or flash without guide authorization.',
                        'Remain quiet to improve wildlife observation.',
                        'Do not touch animals or vegetation.',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',

            ],
            'entrada-admision-natura' => [

                'full_description' => [
                    'es' => 'Disfrute de un pase de un día para vivir una aventura ecológica autoguiada en Natura Eco Park, ideal para explorar a su propio ritmo. Diseñe su itinerario perfecto junto a su familia o amigos mientras recorre senderos naturales rodeados de exuberante biodiversidad tropical.

Con su entrada tendrá acceso a todos los hábitats del parque, hogar de coloridas especies costarricenses. Descubra el estanque de tortugas, observe el lago de cocodrilos y explore el jardín de ranas más grande del país. Mantenga la mirada en lo alto para avistar aves tropicales y admire mariposas vibrantes y delicadas orquídeas en cada rincón.

Una experiencia biológica interactiva, flexible y perfecta para todas las edades.',

                    'en' => 'Enjoy a one-day pass for a self-guided ecological adventure at Natura Eco Park, designed for exploring at your own pace. Create your perfect itinerary with family or friends as you walk scenic rainforest trails surrounded by rich tropical biodiversity.

Your admission grants access to all natural habitats within the park, home to Costa Rica’s colorful wildlife. Discover the turtle pond, observe the crocodile lake, and explore the country’s largest frog garden. Look up to spot tropical birds and admire vibrant butterflies and delicate orchids along the way.

A flexible, interactive biological experience perfect for all ages.',
                ],

                'duration' => [
                    'es' => 'Personalizado',
                    'en' => 'Flexible',
                ],

                'start_hours_text' => [
                    'es' => '8:30 a.m. a 4:30 p.m.',
                    'en' => '8:30 a.m. to 4:30 p.m.',
                ],

                'includes' => [
                    'es' => [
                        'Pase de un día',
                        'Acceso a todos los hábitats naturales',
                        'Senderos ecológicos',
                        'Estanque de tortugas',
                        'Lago de cocodrilos',
                        'Jardín de ranas más grande del país',
                    ],
                    'en' => [
                        'One-day pass',
                        'Access to all natural habitats',
                        'Ecological walking trails',
                        'Turtle pond',
                        'Crocodile lake',
                        'Largest frog garden in the country',
                    ],
                ],

                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Viajeros independientes',
                        'Amantes de la naturaleza',
                        'Todas las edades',
                    ],
                    'en' => [
                        'Families',
                        'Independent travelers',
                        'Nature lovers',
                        'All ages',
                    ],
                ],
                'recommendations' => [
                    'es' => [
                        'Usar ropa fresca y cómoda para explorar el parque.',
                        'Zapatos adecuados para senderos naturales.',
                        'Aplicar protector solar y repelente biodegradable.',
                        'Mantener supervisión constante de niños pequeños.',
                        'Respetar la señalización y normas del parque.',
                    ],
                    'en' => [
                        'Wear light and comfortable clothing for park exploration.',
                        'Proper footwear for natural trails is recommended.',
                        'Apply biodegradable sunscreen and insect repellent.',
                        'Supervise young children at all times.',
                        'Respect park signage and regulations.',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',
            ],
            'photography-tour' => [

                'full_description' => [
                    'es' => 'Capture imágenes dignas de portada en un exclusivo recorrido fotográfico por el Parque Ecológico Natura en La Fortuna. Durante 3 horas, explore una reserva privada de selva tropical acompañado por un guía naturalista experto que le llevará a los mejores puntos para fotografiar fauna y flora en su entorno natural.

                    una experiencia diseñada para fotógrafos apasionados y amantes de la naturaleza que desean convertir momentos inolvidables en verdaderas obras de arte.',

                    'en' => 'Capture frame-worthy images on an exclusive photography tour at Natura Eco Park in La Fortuna. During this 3-hour experience, explore a private rainforest reserve guided by an expert naturalist who will lead you to the best locations for photographing wildlife and tropical flora in their natural habitat.

                    Get close to fascinating species such as crocodiles, tree frogs, snakes, butterflies, and tropical birds, along with delicate orchids and lush vegetation. Every trail offers unique opportunities for stunning shots with natural lighting and authentic rainforest scenery.

                    A premium experience designed for passionate photographers and nature lovers who want to turn unforgettable moments into true works of art.',
                ],

                'duration' => [
                    'es' => '3 horas',
                    'en' => '3 hours',
                ],

                'start_hours_text' => [
                    'es' => '9:00 a.m. a 3:00 p.m.',
                    'en' => '9:00 a.m. to 3:00 p.m.',
                ],

                'includes' => [
                    'es' => [
                        'Guía naturalista profesional',
                        'Acceso a reserva privada',
                        'Recorrido por múltiples hábitats',
                        'Oportunidades fotográficas de fauna y flora',
                    ],
                    'en' => [
                        'Professional naturalist guide',
                        'Private reserve access',
                        'Multiple habitat exploration',
                        'Wildlife and flora photo opportunities',
                    ],
                ],


                'ideal_for' => [
                    'es' => [
                        'Fotógrafos aficionados y profesionales',
                        'Amantes de la naturaleza',
                        'Viajeros creativos',
                    ],
                    'en' => [
                        'Amateur and professional photographers',
                        'Nature lovers',
                        'Creative travelers',
                    ],
                ],
                'recommendations' => [
                    'es' => [
                        'Llevar cámara profesional o equipo fotográfico adecuado.',
                        'Portar baterías y tarjetas de memoria adicionales.',
                        'Usar ropa cómoda en colores neutros.',
                        'Zapatos cerrados para senderos naturales.',
                        'Evitar el uso de flash para no alterar la fauna.',
                        'Seguir siempre las indicaciones del guía.',
                    ],
                    'en' => [
                        'Bring professional camera equipment if available.',
                        'Carry extra batteries and memory cards.',
                        'Wear comfortable clothing in neutral colors.',
                        'Closed-toe shoes for natural trails are recommended.',
                        'Avoid using flash to prevent disturbing wildlife.',
                        'Always follow the guide’s instructions.',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',
            ],
            'bird-watching-tour' => [

                'full_description' => [
                    'es' => 'Viva una experiencia exclusiva de observación de aves al amanecer en el Parque Ecológico Natura. De 6:00 a.m. a 9:00 a.m., el parque abre sus puertas únicamente para usted y otros apasionados observadores, brindándole privacidad total en la mejor hora del día para avistar aves tropicales.

                    Acompañado por guías naturalistas profesionales, caminará en silencio por senderos rodeados de exuberante selva mientras descubre coloridas especies que habitan y migran por nuestra región. Disfrute de los cantos matutinos, capture fotografías espectaculares y conecte con la biodiversidad en su momento más activo.

                    Un tour diseñado para verdaderos amantes de la naturaleza que entienden que “el pájaro madrugador se queda con el gusano”.',

                    'en' => 'Experience an exclusive sunrise bird watching tour at Natura Eco Park. From 6:00 a.m. to 9:00 a.m., the park opens exclusively for you and fellow bird enthusiasts, offering complete privacy during the best time of day for spotting tropical species.

                    Guided by professional naturalists, you will walk quietly through lush rainforest trails while discovering colorful resident and migratory birds. Enjoy the morning chorus, capture stunning photographs, and connect with biodiversity at its most active moment.

                    A tour designed for true nature lovers who understand that “the early bird catches the worm.”',
                ],

                'duration' => [
                    'es' => '3 horas',
                    'en' => '3 hours',
                ],

                'start_hours_text' => [
                    'es' => '6:00 a.m. a 9:00 a.m.',
                    'en' => '6:00 a.m. to 9:00 a.m.',
                ],

                'includes' => [
                    'es' => [
                        'Apertura exclusiva del parque',
                        'Guía naturalista profesional',
                        'Observación de aves tropicales',
                        'Recorrido por senderos ecológicos',
                    ],
                    'en' => [
                        'Exclusive early park access',
                        'Professional naturalist guide',
                        'Tropical bird observation',
                        'Ecological trail walk',
                    ],
                ],

                'ideal_for' => [
                    'es' => [
                        'Amantes de la naturaleza',
                        'Fotógrafos',
                        'Observadores de aves',
                        'Viajeros madrugadores',
                    ],
                    'en' => [
                        'Nature lovers',
                        'Photographers',
                        'Bird watchers',
                        'Early risers',
                    ],
                ],
                'recommendations' => [
                    'es' => [
                        'Usar ropa cómoda en colores neutros.',
                        'Llevar binoculares si dispone de ellos.',
                        'Aplicar repelente biodegradable.',
                        'Evitar ruidos fuertes durante el recorrido.',
                        'Llegar puntual debido al horario exclusivo de apertura.',
                        'Llevar cámara si desea fotografías.',
                    ],
                    'en' => [
                        'Wear comfortable clothing in neutral colors.',
                        'Bring binoculars if available.',
                        'Use biodegradable insect repellent.',
                        'Avoid loud noises during the tour.',
                        'Arrive on time due to exclusive early access.',
                        'Bring camera if planning to take photos.',
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
                'recommendations' => [
                    'es' => [
                        'Usar calzado antideslizante para zonas húmedas.',
                        'Supervisar siempre a los niños.',
                        'No dejar objetos de valor sin supervisión.',
                        'Llevar efectivo si desea comprar alimentos locales.',
                        'Respetar el entorno natural y no dejar basura.',
                        'Revisar condiciones climáticas antes de visitar.',
                    ],
                    'en' => [
                        'Wear non-slip footwear for wet areas.',
                        'Always supervise children.',
                        'Do not leave valuables unattended.',
                        'Bring cash if you plan to buy local food.',
                        'Respect the natural environment and do not litter.',
                        'Check weather conditions before visiting.',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',

            ],
            'catarata-rio-fortuna' => [

                'full_description' => [
                    'es' => 'Descubra la elegancia natural de la majestuosa Catarata Río Fortuna, uno de los destinos más exclusivos de La Fortuna, Costa Rica.

                    Esta impresionante caída de más de 70 metros, rodeada de exuberante selva tropical, desciende hacia una piscina natural de aguas cristalinas creando un escenario verdaderamente icónico. El recorrido autoguiado le permite explorar a su propio ritmo, disfrutando de vistas panorámicas, aire puro y una conexión auténtica con la naturaleza.

                    Descienda aproximadamente 530 escalones hasta la base de la catarata y viva una experiencia inolvidable entre paisajes de postal y tranquilidad absoluta. Su visita incluye parqueo gratuito, vestidores, duchas, casilleros, miradores estratégicos, un jardín de orquídeas y el exclusivo restaurante Río Lounge para completar una experiencia de primer nivel.

                    Una experiencia natural sofisticada que combina aventura, comodidad y la majestuosidad incomparable de Costa Rica.',

                    'en' => 'Discover the refined natural beauty of the majestic La Fortuna Waterfall, one of the most exclusive destinations in La Fortuna, Costa Rica.

                        This breathtaking 70-meter cascade, surrounded by lush tropical rainforest, flows into a crystal-clear natural pool, creating a truly iconic setting. The self-guided trail allows you to explore at your own pace while enjoying panoramic views, fresh mountain air, and an authentic connection with nature.

                        Descend approximately 530 steps to the base of the waterfall and immerse yourself in postcard-worthy scenery and absolute tranquility. Your visit includes complimentary parking, changing rooms, showers, lockers, scenic viewpoints, an orchid garden, and the exclusive Río Lounge restaurant for a premium experience.

                        A sophisticated nature escape blending adventure, comfort, and the incomparable majesty of Costa Rica.'
                ],
                'duration' => [
                    'es' => '2 – 3 horas',
                    'en' => '2 – 3 hours',
                ],

                'start_hours_text' => [
                    'es' => '7:00 a.m. a 5:00 p.m.',
                    'en' => '7:00 a.m. to 5:00 p.m.',
                ],

                'includes' => [
                    'es' => [
                        'Acceso a la Catarata',
                        'Parqueo gratuito',
                        'Servicios sanitarios',
                        'Vestidores y duchas',
                        'Miradores',
                        'Jardín de orquídeas',
                    ],
                    'en' => [
                        'Waterfall access',
                        'Free parking',
                        'Restrooms',
                        'Changing rooms and showers',
                        'Viewpoints',
                        'Orchid garden',
                    ],
                ],

                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Parejas',
                        'Amantes de la naturaleza',
                        'Fotógrafos',
                    ],
                    'en' => [
                        'Families',
                        'Couples',
                        'Nature lovers',
                        'Photographers',
                    ],
                ],
                'recommendations' => [
                    'es' => [
                        'Utilizar calzado cerrado y cómodo adecuado para caminatas en senderos naturales.',
                        'Vestir ropa ligera y confortable, ideal para clima tropical.',
                        'Llevar traje de baño y toalla para disfrutar de la piscina natural.',
                        'Portar agua o bebidas hidratantes para mantenerse bien hidratado durante el recorrido.',
                        'Aplicar bloqueador solar y repelente de insectos biodegradables para proteger tanto su piel como el entorno.',
                        'Traer cámara fotográfica o dispositivo móvil para capturar vistas panorámicas inolvidables.',
                        'Mantenerse siempre dentro de los senderos señalizados para su seguridad.',
                        'Evitar tocar la vegetación o alterar el ecosistema protegido.',
                        'En caso de visitar con niños pequeños, se recomienda portar cargadores adecuados para mayor comodidad.',
                    ],
                    'en' => [
                        'Wear closed-toe, comfortable footwear suitable for natural trails.',
                        'Choose light, breathable clothing appropriate for tropical weather.',
                        'Bring swimwear and a towel to enjoy the natural pool.',
                        'Carry water or hydrating beverages to stay refreshed during the visit.',
                        'Use biodegradable sunscreen and insect repellent to protect both your skin and the environment.',
                        'Bring a camera or mobile device to capture unforgettable panoramic views.',
                        'Stay on designated trails at all times for your safety.',
                        'Avoid touching plants or disturbing the protected ecosystem.',
                        'When visiting with small children, appropriate carriers are recommended for added comfort.',
                    ],
                ],

                'location_name' => 'La Fortuna, San Carlos',

            ],
            'catarata-rio-celeste' => [

                'full_description' => [
                    'es' => 'Descubra una de las maravillas naturales más impresionantes de Costa Rica: la Catarata Río Celeste, ubicada dentro del Parque Nacional Volcán Tenorio. Este impresionante atractivo natural se encuentra a lo largo del sendero Misterios del Tenorio, un recorrido lineal de 3 km (6 km ida y vuelta) que permite explorar los principales puntos del parque en aproximadamente 3 horas.

                    Durante el recorrido podrá visitar la icónica catarata de 20 metros de altura, famosa por su intensa coloración azul turquesa producto de un fenómeno natural único. También podrá disfrutar del Mirador con vista a tres de los cuatro conos volcánicos del macizo Tenorio (Tenorio I, Tenorio II y Cerro Montezuma), la Laguna Azul, los Borbollones —fumarolas de alta temperatura producto de la actividad volcánica— y el Teñidero, el punto exacto donde ocurre el fenómeno que da origen al característico color celeste del río.

                    Una experiencia ideal para amantes de la naturaleza, fotografía y aventura en un entorno protegido de extraordinaria biodiversidad.',

                    'en' => 'Discover one of Costa Rica’s most breathtaking natural wonders: the Rio Celeste Waterfall, located inside Tenorio Volcano National Park. This extraordinary attraction is part of the Misterios del Tenorio trail, a 3 km linear trail (6 km round trip) that allows visitors to explore the park’s main highlights in approximately 3 hours.

                    Along the trail you will visit the iconic 20-meter-high waterfall, famous for its striking turquoise-blue color created by a unique natural phenomenon. You will also enjoy the scenic viewpoint overlooking three of the four volcanic cones of the Tenorio massif (Tenorio I, Tenorio II, and Montezuma Hill), the Blue Lagoon, the Borbollones —high-temperature volcanic gas vents— and El Teñidero, the exact point where the river changes color.

                    An unforgettable experience for nature lovers, photographers, and adventure seekers exploring Costa Rica’s protected wilderness.'
                ],

                'duration' => [
                    'es' => '3 horas ',
                    'en' => '3 hours ',
                ],

                'start_hours_text' => [
                    'es' => '8:00 a.m. a 13:45 p.m.',
                    'en' => '8:00 a.m. to 13:45 p.m.',
                ],

                'location_name' => 'Guatuso, Costa Rica',

                'includes' => [
                    'es' => [
                        'Sendero Misterios del Tenorio (6 km ida y vuelta)',
                        'Acceso a la Catarata Río Celeste',
                        'Mirador volcánico',
                        'Laguna Azul',
                        'Borbollones',
                        'El Teñidero',
                        'Agua potable',
                        'Sanitarios',
                        'Estacionamiento privado disponible (servicio con costo adicional).'
                    ],
                    'en' => [
                        'Misterios del Tenorio Trail (6 km round trip)',
                        'Access to Rio Celeste Waterfall',
                        'Volcanic viewpoint',
                        'Blue Lagoon',
                        'Borbollones (volcanic vents)',
                        'El Teñidero',
                        'Drinking water',
                        'Restrooms',
                        'Private parking available (additional fee required).'
                    ]
                ],
                'ideal_for' => [
                    'es' => [
                        'Amantes del senderismo en entornos naturales protegidos',
                        'Fotógrafos de paisajes y naturaleza',
                        'Viajeros que buscan experiencias auténticas',
                        'Aventureros interesados en fenómenos naturales únicos',
                        'Parejas y grupos que disfrutan exploraciones escénicas',
                    ],
                    'en' => [
                        'Hiking enthusiasts exploring protected natural areas',
                        'Landscape and nature photographers',
                        'Travelers seeking authentic outdoor experiences',
                        'Adventurers interested in unique natural phenomena',
                        'Couples and groups who enjoy scenic explorations',
                    ],
                ],

                'recommendations' => [
                    'es' => [
                        'Usar ropa y calzado cómodo para caminata.',
                        'No se permite el ingreso de plásticos de un solo uso.',
                        'No se permite el ingreso de mascotas.',
                        'No se permite ingresar al río.',
                        'No se permite el uso de drones.',
                        'Prohibido el ingreso de bebidas alcohólicas.',
                        'Prohibido fumar.',
                        'Mantenerse siempre dentro del sendero oficial.',
                    ],
                    'en' => [
                        'Wear comfortable hiking clothes and shoes.',
                        'Single-use plastics are not allowed.',
                        'Pets are not allowed.',
                        'Swimming in the river is not permitted.',
                        'Drones are not allowed.',
                        'Alcoholic beverages are prohibited.',
                        'Smoking is prohibited.',
                        'Stay on designated trails at all times.',
                    ]
                ],
            ],
            'horseback-riding-tour' => [

                'full_description' => [
                    'es' => 'Descubra la esencia auténtica de Costa Rica a caballo en una experiencia inolvidable de aproximadamente dos horas, diseñada para conectar con la naturaleza de una forma tranquila y emocionante a la vez.
                        Desde el primer momento será recibido con un refrigerio ligero de frutas frescas o productos locales, acompañado de degustaciones de jugos naturales o licores típicos, según disponibilidad. Luego comenzará su aventura recorriendo senderos naturales, disfrutando pausas estratégicas para admirar el paisaje, relajarse junto a los ríos y familiarizarse con su caballo.
                        El recorrido combina amplios caminos de grava con senderos más íntimos rodeados de bosque exuberante. Durante el trayecto atravesará fincas locales donde podrá observar vida silvestre y paisajes rurales auténticos.
                        Ofrecemos diferentes rutas según el clima y el nivel de experiencia del grupo: desde trayectos suaves y relajados hasta secciones más aventureras con terreno lodoso. Cuando las condiciones lo permiten, tendrá la oportunidad de cruzar ríos y explorar senderos adicionales.
                        • Rutas tranquilas  
                        • Escenarios de bosque exuberante  
                        • Cruces de río (según el clima)

                        Una experiencia perfecta para todas las edades que combina naturaleza, cultura local y aventura suave en un entorno espectacular.',

                    'en' => 'Discover the authentic essence of Costa Rica on horseback in an unforgettable two-hour experience designed to connect you with nature in a peaceful yet adventurous way.

                    From the very beginning, you will be welcomed with a light snack of fresh fruit or local treats, along with tastings of natural juices or traditional local liqueurs, depending on availability. Your adventure then begins as you ride along scenic natural trails, with relaxing stops to admire the landscape, unwind by the rivers, and comfortably connect with your horse.

                    The journey blends wide gravel paths with narrower forest trails surrounded by lush scenery. Along the way, you will pass through local farms where you may observe wildlife and authentic rural landscapes.

                    We offer different route options depending on weather conditions and group experience level — from relaxed, easy rides to slightly more adventurous sections with muddier terrain. When conditions allow, you may even cross rivers and explore additional trails.

                    • Peaceful routes  
                    • Lush forest scenery  
                    • River crossings (weather permitting)

                    A perfect experience for all ages, combining nature, local culture, and soft adventure in a breathtaking setting.',
                ],

                'duration' => [
                    'es' => '2 horas',
                    'en' => '2 hours',
                ],

                'start_hours_text' => [
                    'es' => '6:00 a.m. a 4:00 p.m.',
                    'en' => '6:00 a.m. to 4:00 p.m.',
                ],
                'includes' => [
                    'es' => [
                        'Guía local especializado',
                        'Caballo asignado según experiencia',
                        'Refrigerio ligero o degustación local',
                        'Recorrido por senderos naturales y fincas locales',
                        'Cruces de río (según condiciones climáticas)',
                    ],
                    'en' => [
                        'Specialized local guide',
                        'Horse assigned based on experience level',
                        'Light snack or local tasting',
                        'Ride through natural trails and local farms',
                        'River crossings (weather permitting)',
                    ],
                ],

                'ideal_for' => [
                    'es' => [
                        'Familias',
                        'Parejas',
                        'Amantes de la naturaleza',
                        'Viajeros que buscan aventura suave',
                        'Personas sin experiencia previa en cabalgata',
                    ],
                    'en' => [
                        'Families',
                        'Couples',
                        'Nature lovers',
                        'Travelers seeking soft adventure',
                        'Beginners with no previous riding experience',
                    ],
                ],

                'recommendations' => [
                    'es' => [
                        'Protección solar',
                        'Bloqueador solar y sombrero si lo desea.',
                        'Repelente de insectos',
                        'Especialmente útil en áreas boscosas.',
                        'Zapatos cerrados',
                        'Botas o zapatos de senderismo para mayor seguridad.',
                        'Pantalón largo recomendado',
                        'Jeans o leggins para mayor comodidad.',
                        'Botella de agua',
                        'Lleve agua para mantenerse hidratado durante el tour.',
                        'Cambio de ropa extra',
                        'Recomendado en caso de lluvia o cruces de río.',
                    ],
                    'en' => [
                        'Sun protection',
                        'Sunscreen and a hat if you wish.',
                        'Insect repellent',
                        'Especially useful in forested areas.',
                        'Closed-toe shoes',
                        'Hiking shoes or boots for added safety.',
                        'Long pants recommended',
                        'Jeans or leggings for better comfort.',
                        'Water bottle',
                        'Bring water to stay hydrated during the tour.',
                        'Extra change of clothes',
                        'Recommended for rain or river crossings.',
                    ],
                ],

                'location_name' => 'La Pechuga, Chachagua',
            ],
            'sky-adventures-zipline' => [

                'full_description' => [
                    'es' => 'Sienta el latir de su corazón al vivir el circuito de tirolesas a través del dosel del bosque costarricense. Aventúrese por cables suspendidos entre montañas y admire vistas únicas del Volcán Arenal y el Lago Arenal.

                        Su experiencia comienza con un pintoresco paseo en teleférico que lo llevará hasta un mirador exclusivo con la icónica escultura “Mano del Arenal”. Desde la cima inicia el canopy tour donde viajará de montaña en montaña a través de siete cables de gran altura.

                        El cable más largo supera los 750 metros y el más alto alcanza los 200 metros, permitiéndole volar a velocidades de hasta 70 km/h mientras disfruta de vistas panorámicas incomparables.

                        • Experiencia orientada a la seguridad  
                        • Sistemas de frenado certificados  
                        • Más de 800m de teleférico panorámico  
                        • Sin caminatas entre cables  
                        • Vistas espectaculares del volcán y el lago  

                        Una aventura extrema diseñada para quienes buscan adrenalina pura en el corazón de Costa Rica.',

                    'en' => 'Feel your heart race as you experience the zipline circuit through the Costa Rican rainforest canopy. Glide along cables suspended between mountains while admiring unique views of Arenal Volcano and Lake Arenal.

                        Your adventure begins with a scenic gondola ride leading to an exclusive viewpoint featuring the iconic “Arenal Hand”. From the top, the canopy tour begins as you travel from mountain to mountain across seven high-altitude cables.

                        The longest cable exceeds 750 meters and the highest reaches 200 meters, allowing you to soar at speeds of up to 70 km/h while enjoying breathtaking panoramic views.

                        • Safety-oriented experience  
                        • Certified braking systems  
                        • Over 800m gondola ride  
                        • No walking between cables  
                        • Spectacular volcano and lake views  

                        An extreme adventure designed for true adrenaline seekers in the heart of Costa Rica.',
                ],

                'duration' => [
                    'es' => '2 – 3 horas',
                    'en' => '2 – 3 hours',
                ],

                'start_hours_text' => [
                    'es' => '8:00 a.m. a 3:00 p.m.',
                    'en' => '8:00 a.m. to 3:00 p.m.',
                ],
                'includes' => [
                    'es' => [
                        'Recorrido completo de canopy con 7 cables',
                        'Teleférico panorámico',
                        'Equipo de seguridad certificado',
                        'Guías profesionales especializados',
                        'Sistemas de frenado automáticos',
                    ],
                    'en' => [
                        'Full canopy circuit with 7 cables',
                        'Scenic gondola ride',
                        'Certified safety equipment',
                        'Professional specialized guides',
                        'Automatic braking systems',
                    ],
                ],

                'ideal_for' => [
                    'es' => [
                        'Amantes de la adrenalina',
                        'Aventureros',
                        'Viajeros activos',
                        'Parejas y grupos de amigos',
                        'Personas que buscan experiencias extremas',
                    ],
                    'en' => [
                        'Adrenaline seekers',
                        'Adventure enthusiasts',
                        'Active travelers',
                        'Couples and groups of friends',
                        'Guests seeking extreme experiences',
                    ],
                ],

                'recommendations' => [
                    'es' => [
                        'Traer el Id o pasaporte para registro de seguridad',
                        'Peso máximo: 136 kg (300 lb)',
                        'Estatura mínima: 1.10 m',
                        'Edad mínima: 5 años',
                        'No apto para embarazadas',
                        'No se permiten cámaras ni objetos sueltos',
                        'Use ropa cómoda y zapatos cerrados',
                        'Protector solar recomendado',
                        'Repelente de insectos recomendado',
                    ],
                    'en' => [
                        'Bring ID or passport for safety registration',
                        'Maximum weight: 136 kg (300 lb)',
                        'Minimum height: 1.10 m',
                        'Minimum age: 5 years',
                        'Not suitable for pregnant guests',
                        'No cameras or loose items allowed',
                        'Wear comfortable clothing and closed shoes',
                        'Sunscreen recommended',
                        'Insect repellent recommended',
                    ],
                ],

                'location_name' => 'Sky Adventures Arenal, La Fortuna',
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
