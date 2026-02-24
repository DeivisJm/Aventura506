<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    protected $fillable = [
        'company_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function detail()
    {
        return $this->hasOne(\App\Models\TourDetail::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TourPrice::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TourSchedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper multilenguaje
    |--------------------------------------------------------------------------
    */

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
    // Precio adulto automático (funciona en ES y EN)
    public function getAdultPriceAttribute()
    {
        return $this->prices
            ->first(function ($price) {

                $type = is_array($price->type)
                    ? strtolower(implode(' ', $price->type)) // junta es + en
                    : strtolower($price->type);

                return str_contains($type, 'adult');
            })?->price ?? null;
    }
}
