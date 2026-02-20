<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    // Campos asignables
    protected $fillable = [
        'company_name',
        'name',
        'slug',
        'category',
        'description',
        'price',
        'distance_km',
        'distance_miles',
        'location_text',
        'image',
        'map_embed_url',
        'map_directions_url',
        'short_description',
        'is_active'
    ];

    // 🔥 Cast JSON correctamente para permitir insertar arrays desde seeders
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'short_description' => 'array',
    ];

    // 🔥 Helper profesional para obtener campo traducido
    public function getTranslated($field)
    {
        $value = $this->$field;

        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['es'] ?? reset($value);
        }

        return $value;
    }

    public function detail()
    {
        return $this->hasOne(TourDetail::class);
    }

    public function prices()
    {
        return $this->hasMany(TourPrice::class);
    }

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class);
    }
}