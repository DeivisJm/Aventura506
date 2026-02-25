<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourPrice extends Model
{
    protected $fillable = [
        'tour_id',
        'type_key',
        'type',
        'category_type',
        'min_age',
        'max_age',
        'price',
        'is_free',
    ];

    protected $casts = [
        'type' => 'array',
        'is_free' => 'boolean',
        'price' => 'decimal:2'
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getTranslatedType()
    {
        if (is_array($this->type)) {
            return $this->type[app()->getLocale()]
                ?? $this->type['es']
                ?? reset($this->type);
        }

        return $this->type;
    }
}
