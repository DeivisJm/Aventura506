<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourDetail extends Model
{
    protected $fillable = [
        'tour_id',
        'full_description',
        'duration',
        'start_hours_text',
        'includes',
        'ideal_for',
        'location_text',
        'distance_km',
        'distance_miles',
        'map_embed_url',
        'map_directions_url',
    ];

    protected $casts = [
        'full_description' => 'array',
        'duration' => 'array',
        'start_hours_text' => 'array',
        'includes' => 'array',
        'ideal_for' => 'array',
    ];

    // Helper traducido
    public function getTranslated($field)
    {
        $value = $this->$field;

        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['es'] ?? reset($value);
        }

        return $value;
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}