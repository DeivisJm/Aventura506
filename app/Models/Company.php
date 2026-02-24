<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'location_name',
        'latitude',
        'longitude',
        'map_embed_url',
        'map_directions_url'
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}