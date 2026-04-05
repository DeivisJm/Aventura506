<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TourDetail extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tour_id',
        'full_description',
        'duration',
        'start_hours_text',
        'includes',
        'ideal_for',
        'location_name',
    ];

    /**
     * Attribute casting.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'full_description' => 'array',
        'duration' => 'array',
        'start_hours_text' => 'array',
        'includes' => 'array',
        'ideal_for' => 'array',
        'recommendations' => 'array',
    ];

    /**
     * Tour relationship.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Return translated field value with locale fallback support.
     */
    public function getTranslated($field)
    {
        $value = $this->$field;

        if (is_array($value)) {
            return $value[app()->getLocale()]
                ?? $value['es']
                ?? $value['en']
                ?? reset($value);
        }

        return $value;
    }

    /**
     * Build normalized icon-ready items for "Ideal For".
     */
    public function getIdealForItems(?string $locale = null): array
    {
        return $this->buildIconItems(
            $this->ideal_for,
            $locale,
            fn(string $key) => $this->getIdealForIcon($key)
        );
    }

    /**
     * Build normalized icon-ready items for "Includes".
     */
    public function getIncludeItems(?string $locale = null): array
    {
        return $this->buildIconItems(
            $this->includes,
            $locale,
            fn(string $key) => $this->getIncludeIcon($key)
        );
    }

    /**
     * Build normalized icon-ready items for "Recommendations".
     */
    public function getRecommendationItems(?string $locale = null): array
    {
        return $this->buildIconItems(
            $this->recommendations,
            $locale,
            fn(string $key) => $this->getRecommendationIcon($key)
        );
    }

    /**
     * Normalize multilingual items and attach an icon.
     */
    protected function buildIconItems(?array $source, ?string $locale, callable $iconResolver): array
    {
        $locale = $locale ?? app()->getLocale();

        $items = $source[$locale]
            ?? $source['es']
            ?? $source['en']
            ?? [];

        if (!is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(function ($item) use ($iconResolver) {
                $label = is_string($item) ? trim($item) : null;

                if (!$label) {
                    return null;
                }

                $normalizedKey = Str::of($label)->lower()->ascii()->value();

                return [
                    'label' => $label,
                    'key'   => Str::slug($label, '_'),
                    'icon'  => $iconResolver($normalizedKey),
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Resolve icon for "Ideal For".
     */
    protected function getIdealForIcon(string $key): string
    {
        $key = Str::of($key)->lower()->ascii()->value();

        // Families / kids
        if (
            str_contains($key, 'famil') ||
            str_contains($key, 'family') ||
            str_contains($key, 'kids') ||
            str_contains($key, 'child') ||
            str_contains($key, 'children') ||
            str_contains($key, 'ninos') ||
            str_contains($key, 'ninas') ||
            str_contains($key, 'nin')
        ) {
            return $this->iconFamily();
        }

        // Couples / romantic
        if (
            str_contains($key, 'pareja') ||
            str_contains($key, 'parejas') ||
            str_contains($key, 'couple') ||
            str_contains($key, 'couples') ||
            str_contains($key, 'romantic') ||
            str_contains($key, 'romantico') ||
            str_contains($key, 'romantica') ||
            str_contains($key, 'honeymoon')
        ) {
            return $this->iconHeart();
        }

        // Photography / camera
        if (
            str_contains($key, 'foto') ||
            str_contains($key, 'fotograf') ||
            str_contains($key, 'photo') ||
            str_contains($key, 'camera') ||
            str_contains($key, 'photographer') ||
            str_contains($key, 'creator') ||
            str_contains($key, 'content')
        ) {
            return $this->iconCamera();
        }

        // Nature / wildlife / eco
        if (
            str_contains($key, 'natur') ||
            str_contains($key, 'nature') ||
            str_contains($key, 'wildlife') ||
            str_contains($key, 'flora') ||
            str_contains($key, 'fauna') ||
            str_contains($key, 'eco') ||
            str_contains($key, 'green')
        ) {
            return $this->iconLeaf();
        }

        // Adventure / hiking / trekking
        if (
            str_contains($key, 'aventur') ||
            str_contains($key, 'adventure') ||
            str_contains($key, 'explorer') ||
            str_contains($key, 'explorador') ||
            str_contains($key, 'trail') ||
            str_contains($key, 'sender') ||
            str_contains($key, 'trek') ||
            str_contains($key, 'hiker') ||
            str_contains($key, 'hik')
        ) {
            return $this->iconMountain();
        }

        // Horseback
        if (
            str_contains($key, 'horse') ||
            str_contains($key, 'horseback') ||
            str_contains($key, 'cabalg') ||
            str_contains($key, 'riding') ||
            str_contains($key, 'equestrian')
        ) {
            return $this->iconHorse();
        }

        // Birds / birdwatching
        if (
            str_contains($key, 'bird') ||
            str_contains($key, 'birds') ||
            str_contains($key, 'aves') ||
            str_contains($key, 'ave') ||
            str_contains($key, 'pajaro') ||
            str_contains($key, 'pajaros') ||
            str_contains($key, 'birdwatch') ||
            str_contains($key, 'ornith')
        ) {
            return $this->iconBird();
        }

        // Groups / adults / friends
        if (
            str_contains($key, 'adult') ||
            str_contains($key, 'adults') ||
            str_contains($key, 'amigo') ||
            str_contains($key, 'friend') ||
            str_contains($key, 'friends') ||
            str_contains($key, 'group') ||
            str_contains($key, 'grupo') ||
            str_contains($key, 'team')
        ) {
            return $this->iconUsers();
        }

        // Relax / wellness / spa / thermal
        if (
            str_contains($key, 'relax') ||
            str_contains($key, 'wellness') ||
            str_contains($key, 'spa') ||
            str_contains($key, 'termal') ||
            str_contains($key, 'hot spring') ||
            str_contains($key, 'hot springs') ||
            str_contains($key, 'peaceful') ||
            str_contains($key, 'quiet')
        ) {
            return $this->iconSteam();
        }

        // Beginners / first timers
        if (
            str_contains($key, 'beginner') ||
            str_contains($key, 'beginners') ||
            str_contains($key, 'first time') ||
            str_contains($key, 'first-time') ||
            str_contains($key, 'sin experiencia') ||
            str_contains($key, 'no experience') ||
            str_contains($key, 'novice') ||
            str_contains($key, 'newbie')
        ) {
            return $this->iconCompass();
        }

        // Walk / soft experience
        if (
            str_contains($key, 'walk') ||
            str_contains($key, 'walking') ||
            str_contains($key, 'caminata') ||
            str_contains($key, 'caminatas') ||
            str_contains($key, 'suave')
        ) {
            return $this->iconHiker();
        }

        // Culture / history / local
        if (
            str_contains($key, 'culture') ||
            str_contains($key, 'cultura') ||
            str_contains($key, 'history') ||
            str_contains($key, 'historia') ||
            str_contains($key, 'local') ||
            str_contains($key, 'heritage')
        ) {
            return $this->iconLandmark();
        }

        // Food / gastronomy
        if (
            str_contains($key, 'food') ||
            str_contains($key, 'foodie') ||
            str_contains($key, 'gastronom') ||
            str_contains($key, 'culinary') ||
            str_contains($key, 'degust') ||
            str_contains($key, 'comida')
        ) {
            return $this->iconFood();
        }

        // Water / river / waterfall / pool / lake
        if (
            str_contains($key, 'water') ||
            str_contains($key, 'rio') ||
            str_contains($key, 'river') ||
            str_contains($key, 'cascada') ||
            str_contains($key, 'waterfall') ||
            str_contains($key, 'pool') ||
            str_contains($key, 'lake') ||
            str_contains($key, 'lago')
        ) {
            return $this->iconWaves();
        }

        // Luxury / premium / exclusive
        if (
            str_contains($key, 'luxury') ||
            str_contains($key, 'premium') ||
            str_contains($key, 'exclusive') ||
            str_contains($key, 'vip') ||
            str_contains($key, 'lujo')
        ) {
            return $this->iconCrown();
        }

        return $this->iconDefault();
    }

    /**
     * Resolve icon for "Includes".
     */
    protected function getIncludeIcon(string $key): string
    {
        $key = Str::of($key)->lower()->ascii()->value();

        if (str_contains($key, 'guia') || str_contains($key, 'guide')) {
            return $this->iconGuide();
        }

        if (
            str_contains($key, 'entrada') ||
            str_contains($key, 'ticket') ||
            str_contains($key, 'admission') ||
            str_contains($key, 'access')
        ) {
            return $this->iconTicket();
        }

        if (
            str_contains($key, 'transporte') ||
            str_contains($key, 'transport') ||
            str_contains($key, 'pickup') ||
            str_contains($key, 'shuttle') ||
            str_contains($key, 'bus')
        ) {
            return $this->iconTransport();
        }

        if (
            str_contains($key, 'almuerzo') ||
            str_contains($key, 'lunch') ||
            str_contains($key, 'breakfast') ||
            str_contains($key, 'dinner') ||
            str_contains($key, 'snack') ||
            str_contains($key, 'food') ||
            str_contains($key, 'meal') ||
            str_contains($key, 'comida') ||
            str_contains($key, 'refrigerio')
        ) {
            return $this->iconFood();
        }

        if (
            str_contains($key, 'agua') ||
            str_contains($key, 'water') ||
            str_contains($key, 'bebida') ||
            str_contains($key, 'drink') ||
            str_contains($key, 'coffee') ||
            str_contains($key, 'tea')
        ) {
            return $this->iconDrop();
        }

        if (
            str_contains($key, 'equipo') ||
            str_contains($key, 'equipment') ||
            str_contains($key, 'gear') ||
            str_contains($key, 'helmet') ||
            str_contains($key, 'casco')
        ) {
            return $this->iconShieldGear();
        }

        if (
            str_contains($key, 'foto') ||
            str_contains($key, 'fotograf') ||
            str_contains($key, 'photo') ||
            str_contains($key, 'camera')
        ) {
            return $this->iconCamera();
        }

        if (
            str_contains($key, 'horse') ||
            str_contains($key, 'cabalg') ||
            str_contains($key, 'horseback')
        ) {
            return $this->iconHorse();
        }

        if (
            str_contains($key, 'sender') ||
            str_contains($key, 'trail') ||
            str_contains($key, 'hiking') ||
            str_contains($key, 'naturaleza') ||
            str_contains($key, 'nature')
        ) {
            return $this->iconMountain();
        }

        if (
            str_contains($key, 'termal') ||
            str_contains($key, 'hot spring') ||
            str_contains($key, 'spa') ||
            str_contains($key, 'wellness')
        ) {
            return $this->iconSteam();
        }

        if (
            str_contains($key, 'seguro') ||
            str_contains($key, 'insurance') ||
            str_contains($key, 'protection')
        ) {
            return $this->iconShield();
        }

        return $this->iconDefault();
    }

    /**
     * Resolve icon for "Recommendations".
     */
    protected function getRecommendationIcon(string $key): string
    {
        $key = Str::of($key)->lower()->ascii()->value();

        if (
            str_contains($key, 'bloqueador') ||
            str_contains($key, 'protector solar') ||
            str_contains($key, 'sunscreen') ||
            str_contains($key, 'sun block')
        ) {
            return $this->iconSun();
        }

        if (
            str_contains($key, 'agua') ||
            str_contains($key, 'water') ||
            str_contains($key, 'hydration')
        ) {
            return $this->iconDrop();
        }

        if (
            str_contains($key, 'ropa') ||
            str_contains($key, 'clothing') ||
            str_contains($key, 'wear') ||
            str_contains($key, 'comfortable')
        ) {
            return $this->iconShirt();
        }

        if (
            str_contains($key, 'calzado') ||
            str_contains($key, 'zapato') ||
            str_contains($key, 'shoe') ||
            str_contains($key, 'shoes') ||
            str_contains($key, 'boots')
        ) {
            return $this->iconShoe();
        }

        if (
            str_contains($key, 'repelente') ||
            str_contains($key, 'repellent') ||
            str_contains($key, 'mosquito')
        ) {
            return $this->iconSpray();
        }

        if (
            str_contains($key, 'sombrero') ||
            str_contains($key, 'hat') ||
            str_contains($key, 'gorra') ||
            str_contains($key, 'cap')
        ) {
            return $this->iconHat();
        }

        if (
            str_contains($key, 'camara') ||
            str_contains($key, 'camera') ||
            str_contains($key, 'foto') ||
            str_contains($key, 'photo')
        ) {
            return $this->iconCamera();
        }

        if (
            str_contains($key, 'efectivo') ||
            str_contains($key, 'cash') ||
            str_contains($key, 'money') ||
            str_contains($key, 'payment')
        ) {
            return $this->iconMoney();
        }

        if (
            str_contains($key, 'puntual') ||
            str_contains($key, 'early') ||
            str_contains($key, 'time') ||
            str_contains($key, 'arrival') ||
            str_contains($key, 'llegar')
        ) {
            return $this->iconClock();
        }

        if (
            str_contains($key, 'documento') ||
            str_contains($key, 'passport') ||
            str_contains($key, 'identification') ||
            str_contains($key, 'id ')
        ) {
            return $this->iconIdCard();
        }

        return $this->iconDefault();
    }

    /**
     * Default versatile fallback icon.
     */
    protected function iconDefault(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/></svg>';
    }

    protected function iconFamily(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M16 19a4 4 0 00-8 0M12 11a3 3 0 100-6 3 3 0 000 6M5 19a3 3 0 013-3M19 19a3 3 0 00-3-3M7.5 10a2.5 2.5 0 110-5 2.5 2.5 0 010 5zm9 0a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>';
    }

    protected function iconHeart(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20s-6.5-4.35-8.5-8A4.85 4.85 0 014.7 5.4 4.9 4.9 0 0112 7.35a4.9 4.9 0 017.3-1.95A4.85 4.85 0 0120.5 12c-2 3.65-8.5 8-8.5 8z"/></svg>';
    }

    protected function iconCamera(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8a2 2 0 012-2h2.2a2 2 0 001.6-.8l.6-.8A2 2 0 0112 4h0a2 2 0 011.6.8l.6.8a2 2 0 001.6.8H18a2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V8z"/><circle cx="12" cy="12" r="3.2"/></svg>';
    }

    protected function iconLeaf(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M19 5c-6.5 0-11 3.5-11 9a5 5 0 005 5c5.5 0 6-7 6-14z"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 14c2-1 4.5-3.5 6-6"/></svg>';
    }

    protected function iconMountain(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 19h18M6 19l4-7 3 4 5-9 3 12"/></svg>';
    }

    protected function iconHorse(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18h10M8 18l1.5-5 3-2 2 1 2 4M10 8c1.5-1.8 3.5-2.8 6-3l1 2-2 1-2 .5-1.2 1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 10l2 1"/></svg>';
    }

    protected function iconBird(): string
    {
        return '<svg viewBox="0 0 512.005 512.005" fill="currentColor" class="w-4 h-4"><path d="M508.001,97.725l-59.092-34.209c-5.144-9.754-12.236-18.473-21.036-25.657c-17.247-14.082-38.945-20.608-61.1-18.365c-19.81,2.001-38.27,11.037-51.976,25.445c-12.821,13.477-20.764,30.853-22.584,49.227L73.681,361.821c-1.667,2.042-2.224,4.772-1.489,7.304s2.668,4.539,5.17,5.371c9.84,3.27,19.728,5.933,29.623,7.985l-20.71,17.58c-3.375,2.865-3.788,7.922-0.923,11.296c2.865,3.375,7.921,3.789,11.296,0.923l31.102-26.402c3.415,0.411,6.827,0.749,10.236,1.013c1.09,0.086,2.179,0.169,3.266,0.239c0.229,0.015,0.456,0.027,0.685,0.041c13.899,0.866,27.517,0.492,40.778-1.125c1.003-0.12,1.999-0.254,2.996-0.388c0.269-0.036,0.539-0.072,0.807-0.11c2,0.415,3.991,0.812,5.969,1.191c-40.287,54.207-103.888,87.841-171.844,90.06l56.005-47.542c3.375-2.865,3.788-7.922,0.923-11.296c-2.863-3.375-7.92-3.787-11.296-0.923L4.76,469.257c-4.345,3.69-5.883,9.531-3.917,14.881c1.965,5.35,6.918,8.807,12.618,8.807c41.391,0,82.28-10.828,118.245-31.314c31.215-17.78,58.057-42.465,78.404-71.939c14.742,2.101,28.822,3.165,42.211,3.165c6.951,0,13.713-0.29,20.292-0.855v42.519l-28.406,20.224c-3.606,2.567-4.447,7.572-1.881,11.177c2.566,3.605,7.569,4.448,11.176,1.881l24.779-17.64l11.069,18.062c1.512,2.467,4.144,3.828,6.84,3.828c1.428,0,2.874-0.381,4.18-1.183c3.774-2.313,4.958-7.247,2.646-11.02l-4.552-7.427l19.116,5.782l12.394,17.979c1.555,2.255,4.058,3.466,6.606,3.466c1.569,0,3.152-0.459,4.541-1.417c3.644-2.512,4.563-7.503,2.049-11.147l-13.986-20.289c-1.031-1.495-2.539-2.597-4.279-3.122l-26.101-7.895l23.334-16.612l11.069,18.062c1.512,2.467,4.144,3.829,6.84,3.828c1.428,0,2.873-0.381,4.18-1.182c3.774-2.313,4.958-7.247,2.645-11.021l-4.552-7.427l19.116,5.782l12.394,17.979c1.555,2.255,4.058,3.466,6.606,3.466c1.569,0,3.152-0.459,4.541-1.417c3.644-2.512,4.563-7.503,2.049-11.147l-13.986-20.289c-1.031-1.495-2.539-2.597-4.279-3.122l-36.265-10.969v-24.95c9.022-4.188,17.481-9.192,25.367-15.01c51.665-38.119,67.715-102.874,72.082-150.485c0.404-4.408-2.841-8.308-7.248-8.713c-4.413-0.407-8.308,2.841-8.713,7.249c-4.068,44.342-18.757,104.461-65.637,139.051c-30.571,22.555-71.257,31.502-121.333,26.732c9.191-3.352,17.986-7.385,26.332-12.077c0.047-0.027,0.095-0.055,0.142-0.081c1.506-0.848,2.995-1.718,4.472-2.609c0.28-0.169,0.558-0.339,0.837-0.509c1.247-0.763,2.483-1.541,3.708-2.334c0.383-0.247,0.766-0.493,1.147-0.743c1.141-0.752,2.271-1.521,3.393-2.3c0.397-0.276,0.8-0.546,1.195-0.825c1.217-0.86,2.419-1.74,3.612-2.631c0.263-0.197,0.532-0.386,0.794-0.583c1.411-1.068,2.804-2.159,4.181-3.27c0.48-0.388,0.949-0.79,1.424-1.182c0.895-0.739,1.789-1.48,2.668-2.238c0.576-0.497,1.142-1.004,1.712-1.51c0.768-0.681,1.536-1.365,2.292-2.059c0.582-0.535,1.158-1.078,1.733-1.621c0.737-0.698,1.469-1.401,2.195-2.114c0.557-0.546,1.11-1.094,1.659-1.648c0.745-0.751,1.48-1.514,2.212-2.281c0.505-0.53,1.013-1.057,1.512-1.593c0.807-0.869,1.6-1.753,2.39-2.639c0.405-0.455,0.816-0.902,1.217-1.362c1.183-1.358,2.35-2.733,3.494-4.133c0.791-0.968,1.57-1.946,2.337-2.93c0.202-0.259,0.398-0.524,0.597-0.783c0.564-0.732,1.126-1.465,1.678-2.206c0.211-0.282,0.414-0.57,0.622-0.854c0.536-0.73,1.071-1.461,1.594-2.199c0.189-0.267,0.373-0.537,0.56-0.806c0.536-0.765,1.07-1.532,1.592-2.306c0.162-0.24,0.321-0.483,0.481-0.725c0.543-0.813,1.082-1.628,1.61-2.451c0.129-0.202,0.256-0.406,0.386-0.609c0.556-0.872,1.104-1.748,1.643-2.631c0.096-0.157,0.189-0.315,0.284-0.472c0.569-0.938,1.128-1.881,1.679-2.831c0.062-0.108,0.124-0.216,0.186-0.324c0.582-1.012,1.155-2.028,1.717-3.052c0.026-0.046,0.05-0.093,0.076-0.139c5.255-9.599,9.572-19.728,12.919-30.293c10.567-32.355,11.47-68.852,2.647-106.025c-5.217-22.251-13.867-44.335-25.747-65.507c-0.022-0.041-0.044-0.081-0.066-0.122c3.009-31.995,28.005-57.281,60.255-60.539c17.89-1.806,35.421,3.461,49.352,14.835c7.611,6.215,13.638,13.853,17.847,22.415c0.014,0.029,0.02,0.059,0.034,0.088c0.852,1.736,1.623,3.505,2.319,5.299c0.041,0.105,0.081,0.208,0.122,0.312c0.293,0.767,0.567,1.541,0.832,2.319c0.085,0.252,0.17,0.504,0.252,0.757c0.22,0.672,0.428,1.347,0.627,2.027c0.11,0.378,0.215,0.76,0.318,1.141c0.16,0.587,0.317,1.174,0.462,1.766c0.121,0.497,0.23,0.998,0.34,1.499c0.11,0.502,0.224,1.004,0.324,1.51c0.125,0.637,0.231,1.279,0.338,1.922c0.065,0.391,0.139,0.779,0.198,1.172c0.154,1.039,0.287,2.083,0.394,3.134c0.001,0.009,0.002,0.017,0.003,0.027c0.104,1.029,0.175,2.056,0.233,3.082c0.013,0.239,0.028,0.48,0.039,0.719c0.043,0.938,0.064,1.875,0.068,2.81c0.001,0.334-0.004,0.669-0.009,1.003c-0.007,0.698-0.028,1.394-0.058,2.09c-0.022,0.53-0.051,1.059-0.087,1.588c-0.039,0.606-0.088,1.211-0.144,1.814c-0.043,0.456-0.087,0.913-0.139,1.368c-0.089,0.779-0.191,1.557-0.309,2.332c-0.065,0.439-0.141,0.876-0.216,1.313c-0.107,0.625-0.222,1.25-0.347,1.873c-0.091,0.453-0.185,0.906-0.285,1.357c-0.167,0.748-0.344,1.494-0.536,2.237c-0.072,0.278-0.142,0.557-0.217,0.833c-0.254,0.933-0.528,1.861-0.824,2.786c-3.898,12.234-11.281,23.282-21.564,31.7c-1.997,1.636-3.085,4.133-2.921,6.71c0.313,4.926,0.655,12.919,0.509,23.017c-0.065,4.426,3.471,8.066,7.897,8.131c0.04,0,0.079,0.001,0.119,0.001c4.371,0,7.948-3.511,8.011-7.897c0.12-8.223-0.069-15.141-0.315-20.263c9.973-9.018,17.471-20.141,22.095-32.371c19.603-6.857,53.317-19.6,53.68-19.736c2.895-1.094,4.9-3.758,5.152-6.843C512.225,102.229,510.679,99.276,508.001,97.725zM288.64,390.004c9.734-1.608,19.014-3.894,27.83-6.863v20.386l-27.83,19.813V390.004zM308.179,133.219c0.686,1.73,1.362,3.461,2.003,5.194l0.309,0.849c22.176,60.748,16.186,123.467-17.626,168.789c-0.062,0.083-0.126,0.166-0.189,0.249c-1.217,1.624-2.466,3.228-3.755,4.806c-0.886,1.085-1.788,2.151-2.7,3.208c-0.278,0.322-0.561,0.638-0.842,0.957c-0.655,0.746-1.314,1.485-1.982,2.216c-0.312,0.342-0.626,0.681-0.941,1.019c-0.684,0.734-1.374,1.461-2.071,2.18c-0.279,0.287-0.556,0.577-0.837,0.862c-0.913,0.926-1.834,1.842-2.768,2.744c-0.061,0.059-0.122,0.121-0.183,0.18c-1.046,1.005-2.108,1.995-3.181,2.97c-0.141,0.128-0.285,0.252-0.426,0.379c-0.904,0.813-1.817,1.617-2.74,2.407c-0.263,0.225-0.528,0.449-0.793,0.672c-0.83,0.702-1.667,1.394-2.512,2.078c-0.278,0.224-0.555,0.45-0.835,0.673c-0.914,0.729-1.836,1.446-2.767,2.153c-0.194,0.147-0.386,0.298-0.58,0.446c-1.137,0.856-2.285,1.697-3.446,2.522c-0.154,0.109-0.312,0.215-0.467,0.324c-0.957,0.674-1.923,1.339-2.897,1.992c-0.448,0.3-0.901,0.594-1.352,0.89c-0.675,0.442-1.354,0.882-2.037,1.314c-0.564,0.357-1.131,0.712-1.7,1.062c-0.543,0.334-1.091,0.662-1.639,0.991c-0.68,0.406-1.358,0.813-2.044,1.21c-0.267,0.154-0.538,0.302-0.806,0.455c-11.282,6.425-23.523,11.537-36.588,15.266c-0.012,0.003-0.023,0.004-0.035,0.007c-3.005,0.86-6.04,1.637-9.097,2.346c-0.868,0.2-1.74,0.391-2.615,0.579c-0.4,0.087-0.801,0.172-1.202,0.256c-3.726,0.775-7.508,1.447-11.348,2.007c-0.212,0.031-0.42,0.073-0.625,0.12c-0.188,0.027-0.377,0.05-0.565,0.077c-1.299,0.183-2.603,0.349-3.91,0.507c-0.919,0.109-1.842,0.208-2.768,0.305c-0.59,0.062-1.18,0.125-1.772,0.182c-1.385,0.131-2.774,0.25-4.171,0.354c-0.146,0.011-0.294,0.022-0.44,0.033c-4.945,0.355-9.963,0.534-15.048,0.534c-3.381,0-6.772-0.088-10.166-0.247c-0.778-0.037-1.555-0.074-2.334-0.12c-0.624-0.036-1.249-0.076-1.874-0.117c-5.116-0.344-10.274-0.86-15.474-1.565c-0.034-0.004-0.069-0.004-0.104-0.009c-10.859-1.477-21.746-3.742-32.604-6.799L298.458,111.86c0.136,0.264,0.279,0.524,0.412,0.788c0.278,0.544,0.537,1.09,0.81,1.634c1.419,2.836,2.783,5.693,4.083,8.565c0.199,0.438,0.406,0.875,0.602,1.313c0.028,0.067,0.056,0.135,0.084,0.201c0.521,1.172,1.027,2.355,1.531,3.538c0.294,0.692,0.589,1.385,0.875,2.077C307.306,131.058,307.749,132.141,308.179,133.219zM457.834,113.21c0.711-5.46,0.869-10.991,0.478-16.557c-0.003-0.043-0.004-0.086-0.007-0.128c-0.059-0.824-0.129-1.649-0.213-2.475c-0.133-1.308-0.298-2.608-0.491-3.902c-0.073-0.494-0.166-0.981-0.247-1.471c-0.108-0.646-0.203-1.296-0.326-1.939l28.278,16.37C477.1,106.165,466.923,109.93,457.834,113.21z"/><circle cx="401.119" cy="80.38" r="10.233"/></svg>';
    }

    protected function iconUsers(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20a4 4 0 00-8 0M12 12a4 4 0 100-8 4 4 0 000 8M21 20a4 4 0 00-3-3.87M16 4.13a4 4 0 010 7.75"/></svg>';
    }

    protected function iconSteam(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M7 14c1.5 0 1.5-1 3-1s1.5 1 3 1 1.5-1 3-1 1.5 1 3 1M5 18c1.5 0 1.5-1 3-1s1.5 1 3 1 1.5-1 3-1 1.5 1 3 1 1.5-1 3-1M9 8c0-1 1-1.5 1-2.5S9 4 9 3M13 8c0-1 1-1.5 1-2.5S13 4 13 3"/></svg>';
    }

    protected function iconCompass(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M14.8 9.2l-1.7 5.6-5.6 1.7 1.7-5.6 5.6-1.7z"/></svg>';
    }

    protected function iconHiker(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM8 21l2-6 2 2 2 4M10 8l2 2 3 1M8 13l3-3"/></svg>';
    }

    protected function iconLandmark(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20h16M6 18V8l6-3 6 3v10M9 11h.01M12 11h.01M15 11h.01"/></svg>';
    }

    protected function iconFood(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4v7M6 4v7M10 4v7M7 11v9M14 4v6a3 3 0 003 3h1v7"/></svg>';
    }

    protected function iconWaves(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2M3 19c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2 2-2 4-2"/></svg>';
    }

    protected function iconCrown(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 17l2-8 5 4 5-4 2 8H5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 9l2-3 3 2 3-2 2 3"/></svg>';
    }

    protected function iconGuide(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14a4 4 0 100-8 4 4 0 000 8zM6 20a6 6 0 0112 0"/></svg>';
    }

    protected function iconTicket(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2a2 2 0 000-4V8z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 8v8"/></svg>';
    }

    protected function iconTransport(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17h8M7 17l-1 2M17 17l1 2M6 14h12M7 5h10a2 2 0 012 2v7H5V7a2 2 0 012-2z"/></svg>';
    }

    protected function iconDrop(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c3 3.6 5 6.2 5 9a5 5 0 11-10 0c0-2.8 2-5.4 5-9z"/></svg>';
    }

    protected function iconShieldGear(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12l1.7 1.7 3.3-3.4"/></svg>';
    }

    protected function iconShield(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v5c0 5-3.5 8.5-7 10-3.5-1.5-7-5-7-10V6l7-3z"/></svg>';
    }

    protected function iconSun(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><circle cx="12" cy="12" r="3.5"/><path stroke-linecap="round" d="M12 2v2.5M12 19.5V22M2 12h2.5M19.5 12H22M4.9 4.9l1.8 1.8M17.3 17.3l1.8 1.8M19.1 4.9l-1.8 1.8M6.7 17.3l-1.8 1.8"/></svg>';
    }

    protected function iconShirt(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4l4 2 4-2 2 4-2 2v10H8V10L6 8l2-4z"/></svg>';
    }

    protected function iconShoe(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16c2 .2 3.8-.1 5.4-1l2.2-1.2 1.4 2.2c.9 1.4 2.4 2 4.5 2H20v2H4v-4z"/></svg>';
    }

    protected function iconSpray(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M10 17h4M9 3h6l1 6a4 4 0 11-8 0l1-6z"/></svg>';
    }

    protected function iconHat(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4 15c2.5-2 5.2-3 8-3s5.5 1 8 3M7 15V9a5 5 0 0110 0v6"/></svg>';
    }

    protected function iconMoney(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/></svg>';
    }

    protected function iconClock(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/></svg>';
    }

    protected function iconIdCard(): string
    {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4"><rect x="4" y="5" width="16" height="14" rx="2"/><circle cx="9" cy="10" r="2"/><path stroke-linecap="round" d="M13 10h3M13 14h4M6.5 15c.8-1.3 1.9-2 3.3-2 1.3 0 2.5.7 3.2 2"/></svg>';
    }
}