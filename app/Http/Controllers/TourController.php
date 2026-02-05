<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * ------------------------------------------------------
     * LISTADO DE TOURS
     * ------------------------------------------------------
     * Por ahora solo devuelve la vista.
     * Más adelante este método traerá los tours desde BD
     * para el filtro dinámico y el CRUD del administrador.
     */
    public function index()
    {
        return view('pages.tours');
    }

    /**
     * ------------------------------------------------------
     * DETALLE DE TOUR (PÁGINA ÚNICA)
     * ------------------------------------------------------
     * Esta página sirve para TODOS los tours.
     * El contenido se carga según el slug.
     *
     * Más adelante será:
     * Tour::where('slug', $slug)->firstOrFail();
     */
    public function show(string $slug)
    {
        /*
        |------------------------------------------------------
        | MOCK TEMPORAL (SIMULACIÓN DE BASE DE DATOS)
        |------------------------------------------------------
        | ⚠️ NO tocar la estructura
        | Esta misma estructura pasará a una tabla en BD
        */
        $tours = [

            'nature-tours-la-fortuna' => [
                'name' => 'Nature Tours La Fortuna',
                'slug' => 'nature-tours-la-fortuna',
                'category' => 'Naturaleza',
                'description' => 'Experiencias guiadas de naturaleza en La Fortuna.',
                'image' => 'https://source.unsplash.com/1200x600/?rainforest,waterfall,costa-rica',

                // -----------------------------
                // CONTENIDO DEL TOUR
                // -----------------------------
                'includes' => [
                    'Caminatas guiadas',
                    'Observación de flora y fauna',
                    'Guías certificados',
                    'Experiencia educativa',
                ],

                'ideal_for' => [
                    'Amantes de la naturaleza',
                    'Familias',
                    'Parejas',
                    'Turismo responsable',
                ],

                // -----------------------------
                // 📍 UBICACIÓN / CÓMO LLEGAR
                // -----------------------------

                // Texto descriptivo
                'location_text' => 'Nature Tours La Fortuna se encuentra a pocos minutos del centro de La Fortuna, San Carlos, cerca del Volcán Arenal. Fácil acceso desde la Ruta 702.',

                // ✅ MAPA EMBEBIDO (iframe)
                // Regla: SIEMPRE usar output=embed 
                'map_embed_url' => 'https://www.google.com/maps?q=10.406555,-84.580452&hl=es&z=14&output=embed',

                // ✅ LINK EXTERNO PARA DIRECCIONES
                'map_directions_url' => 'https://www.google.com/maps/dir/La+Fortuna,+Provincia+de+Alajuela/10.406555,-84.580452',

                // Distancia informativa (visual)
                'distance_km' => '14.4',
                'distance_miles' => '9.0',
            ],

        ];

        /*
        |------------------------------------------------------
        | VALIDACIÓN DEL SLUG
        |------------------------------------------------------
        | Si el tour no existe → 404 automático
        */
        abort_unless(isset($tours[$slug]), 404);

        /*
        |------------------------------------------------------
        | RETORNO A LA VISTA ÚNICA DE DETALLE
        |------------------------------------------------------
        */
        return view('pages.tour_detail', [
            'tour' => $tours[$slug],
        ]);
    }
}
