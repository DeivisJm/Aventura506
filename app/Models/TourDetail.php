<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourDetail extends Model
{
    protected $fillable = [
        'tour_id',
        'full_description',
        'duration',
        'start_hours_text',
        'includes',
        'ideal_for',
        'location_name',
    ];

    protected $casts = [
        'full_description' => 'array',
        'duration' => 'array',
        'start_hours_text' => 'array',
        'includes' => 'array',
        'ideal_for' => 'array',
        'recommendations' => 'array',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getTranslated($field)
    {
        $value = $this->$field;

        if (is_array($value)) {
            return $value[app()->getLocale()]
                ?? $value['es']
                ?? reset($value);
        }

        return $value;
    }
}