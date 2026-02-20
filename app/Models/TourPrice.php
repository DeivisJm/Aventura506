<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPrice extends Model
{
    protected $fillable = [
        'tour_id',
        'type',
        'price',
        'age_range',
        'is_free'
    ];

    protected $casts = [
        'type' => 'array', // 🔥 IMPORTANTE
        'is_free' => 'boolean',
    ];

    // 🔥 Método explícito para JS y Blade
    public function getTranslatedType()
    {
        if (is_array($this->type)) {
            return $this->type[app()->getLocale()]
                ?? $this->type['es']
                ?? reset($this->type);
        }

        return $this->type;
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}