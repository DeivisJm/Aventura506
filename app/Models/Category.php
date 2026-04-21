<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function getTranslatedNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->name[$locale]
            ?? $this->name['es']
            ?? $this->name['en']
            ?? '';
    }
}