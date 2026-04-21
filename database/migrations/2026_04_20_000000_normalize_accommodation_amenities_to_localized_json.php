<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $dictionary = [
            'wifi' => ['es' => 'Wi-Fi', 'en' => 'Wi-Fi'],
            'kitchen' => ['es' => 'Cocina', 'en' => 'Kitchen'],
            'free_parking' => ['es' => 'Parqueo gratis', 'en' => 'Free parking'],
            'parking' => ['es' => 'Parqueo', 'en' => 'Parking'],
            'lake_access' => ['es' => 'Acceso al lago', 'en' => 'Lake access'],
            'workspace' => ['es' => 'Espacio de trabajo', 'en' => 'Workspace'],
            'ac' => ['es' => 'A/C', 'en' => 'A/C'],
            'air_conditioning' => ['es' => 'Aire acondicionado', 'en' => 'Air conditioning'],
            'jacuzzi' => ['es' => 'Jacuzzi', 'en' => 'Jacuzzi'],
            'pet_friendly' => ['es' => 'Pet friendly', 'en' => 'Pet friendly'],
            'pool' => ['es' => 'Piscina', 'en' => 'Pool'],
            'hot_water' => ['es' => 'Agua caliente', 'en' => 'Hot water'],
            'tv' => ['es' => 'TV', 'en' => 'TV'],
            'washer' => ['es' => 'Lavadora', 'en' => 'Washer'],
            'dryer' => ['es' => 'Secadora', 'en' => 'Dryer'],
            'balcony' => ['es' => 'Balcón', 'en' => 'Balcony'],
            'garden' => ['es' => 'Jardín', 'en' => 'Garden'],
        ];

        $rows = DB::table('accommodations')
            ->select('id', 'amenities')
            ->get();

        foreach ($rows as $row) {
            if (empty($row->amenities)) {
                continue;
            }

            $decoded = json_decode($row->amenities, true);

            if (!is_array($decoded)) {
                continue;
            }

            $alreadyLocalized = collect($decoded)->contains(function ($item) {
                return is_array($item)
                    && isset($item['label'])
                    && is_array($item['label']);
            });

            if ($alreadyLocalized) {
                continue;
            }

            $normalized = collect($decoded)
                ->filter(fn($item) => is_string($item) && trim($item) !== '')
                ->map(function ($item) use ($dictionary) {
                    $key = Str::slug($item, '_');

                    return [
                        'key' => $key,
                        'label' => [
                            'es' => $dictionary[$key]['es'] ?? Str::headline(str_replace('_', ' ', $key)),
                            'en' => $dictionary[$key]['en'] ?? Str::headline(str_replace('_', ' ', $key)),
                        ],
                    ];
                })
                ->values()
                ->all();

            DB::table('accommodations')
                ->where('id', $row->id)
                ->update([
                    'amenities' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
                ]);
        }
    }

    public function down(): void
    {
        // Intentionally left empty to avoid destructive rollback on translated data.
    }
};