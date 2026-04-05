<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accommodation extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'name',
        'slug',
        'short_description',
        'location',
        'host_name',
        'phone',
        'external_url',
        'main_image',
        'gallery_images',
        'guests',
        'bedrooms',
        'beds',
        'bathrooms',
        'amenities',
        'is_active',
        'sort_order',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'gallery_images' => 'array',
        'amenities' => 'array',
        'is_active' => 'boolean',
    ];
    /**
     * Automatically generate slug when missing.
     */
    protected static function booted(): void
    {
        static::creating(function (Accommodation $accommodation) {
            if (empty($accommodation->slug)) {
                $defaultName = is_array($accommodation->name)
                    ? ($accommodation->name['en'] ?? reset($accommodation->name))
                    : $accommodation->name;

                $accommodation->slug = Str::slug($defaultName);
            }
        });
    }

    /**
     * Return translated field value with fallback support.
     */
    public function getTranslated(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if (!is_array($value)) {
            return $value;
        }

        return $value[$locale]
            ?? $value['en']
            ?? $value['es']
            ?? reset($value)
            ?? null;
    }

    /**
     * Return all images for the card slider.
     */
    public function getAllImages(): array
    {
        $images = [];

        if (!empty($this->main_image)) {
            $images[] = $this->main_image;
        }

        if (is_array($this->gallery_images)) {
            foreach ($this->gallery_images as $image) {
                if (is_string($image) && trim($image) !== '') {
                    $images[] = $image;
                }
            }
        }

        $images = array_values(array_unique($images));

        if (empty($images)) {
            $images[] = 'images/default-accommodation.jpg';
        }

        return $images;
    }

    /**
     * Normalize amenities for multilingual display.
     */
    public function getAmenityItems(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $items = [];

        if (!is_array($this->amenities)) {
            return $items;
        }

        foreach ($this->amenities as $amenity) {
            $label = $this->resolveAmenityLabel($amenity, $locale);
            $key = $this->resolveAmenityKey($amenity, $label);

            if (!$label) {
                continue;
            }

            $items[] = [
                'key' => $key,
                'label' => $label,
                'icon' => $this->getAmenityIcon($key),
            ];
        }

        return $items;
    }

    protected function resolveAmenityLabel(mixed $amenity, string $locale): ?string
    {
        if (is_string($amenity)) {
            return $this->translateAmenitySlug($amenity, $locale);
        }

        if (!is_array($amenity)) {
            return null;
        }

        if (isset($amenity['label']) && is_array($amenity['label'])) {
            return $amenity['label'][$locale]
                ?? $amenity['label']['en']
                ?? $amenity['label']['es']
                ?? reset($amenity['label'])
                ?? null;
        }

        if (isset($amenity[$locale])) {
            return $amenity[$locale];
        }

        if (isset($amenity['en'])) {
            return $amenity['en'];
        }

        if (isset($amenity['es'])) {
            return $amenity['es'];
        }

        if (isset($amenity['name']) && is_string($amenity['name'])) {
            return $amenity['name'];
        }

        return null;
    }

    protected function resolveAmenityKey(mixed $amenity, ?string $label): string
    {
        if (is_string($amenity)) {
            return Str::slug($amenity, '_');
        }

        if (is_array($amenity) && !empty($amenity['key'])) {
            return Str::slug((string) $amenity['key'], '_');
        }

        if ($label) {
            return Str::slug($label, '_');
        }

        return 'amenity';
    }

    protected function translateAmenitySlug(string $slug, string $locale): string
    {
        $map = [
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

        $slug = Str::slug($slug, '_');

        return $map[$slug][$locale]
            ?? $map[$slug]['en']
            ?? $map[$slug]['es']
            ?? Str::headline(str_replace('_', ' ', $slug));
    }

    public function getAmenityIcon(string $key): string
    {
        $key = Str::of($key)->lower()->ascii()->replace('-', '_')->value();

        if (str_contains($key, 'wifi') || str_contains($key, 'internet')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 16.5a5 5 0 017 0M5 13a10 10 0 0114 0M2 9.5a15 15 0 0120 0M12 20h.01"/></svg>';
        }

        if (str_contains($key, 'kitchen') || str_contains($key, 'cocina')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 3v18M8 3v18M12 8h8M12 12h8M12 16h8"/></svg>';
        }

        if (str_contains($key, 'parking') || str_contains($key, 'parqueo')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 17V7a2 2 0 012-2h4a4 4 0 010 8H6m0 0v3m0-3h6"/></svg>';
        }

        if (str_contains($key, 'lake') || str_contains($key, 'lago') || str_contains($key, 'water')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2M3 19c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2M12 3v6"/></svg>';
        }

        if (str_contains($key, 'workspace') || str_contains($key, 'work') || str_contains($key, 'office')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M6 7v10h12V7M9 21h6"/></svg>';
        }

        if (str_contains($key, 'jacuzzi')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 13h16M6 17h12M7 9a1 1 0 100-2 1 1 0 000 2zm5-2v2m5-2a1 1 0 100-2 1 1 0 000 2z"/></svg>';
        }

        if (str_contains($key, 'pet') || str_contains($key, 'mascota')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11c-1.5 0-2.5 1.2-2.5 2.5S7.5 16 9 16s2.5-1.2 2.5-2.5S10.5 11 9 11zm6 0c-1.5 0-2.5 1.2-2.5 2.5S13.5 16 15 16s2.5-1.2 2.5-2.5S16.5 11 15 11zM8 8h.01M12 6h.01M16 8h.01M7 18c1.5-1.2 2.9-1.8 5-1.8s3.5.6 5 1.8"/></svg>';
        }

        if (str_contains($key, 'pool') || str_contains($key, 'piscina')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 17c1.5 0 1.5-1 3-1s1.5 1 3 1 1.5-1 3-1 1.5 1 3 1 1.5-1 3-1 1.5 1 3 1M7 13V6a2 2 0 114 0v7"/></svg>';
        }

        if (str_contains($key, 'air') || $key === 'ac' || str_contains($key, 'a_c')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8h18M5 8v5a2 2 0 002 2h10a2 2 0 002-2V8M8 17v2M12 17v3M16 17v2"/></svg>';
        }

        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4"><circle cx="12" cy="12" r="8"/></svg>';
    }
}
