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
        'includes' => 'array',
        'ideal_for' => 'array',
    ];

    /**
     * Relation with Tour
     */
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
