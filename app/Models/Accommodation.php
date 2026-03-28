<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'company_id',
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'gallery',
        'property_type',
        'location_text',
        'province',
        'city',
        'address',
        'price_per_night',
        'currency',
        'max_guests',
        'bedrooms',
        'beds',
        'bathrooms',
        'size_m2',
        'check_in_time',
        'check_out_time',
        'rating',
        'reviews_count',
        'amenities',
        'house_rules',
        'includes',
        'latitude',
        'longitude',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'short_description' => 'array',
        'description' => 'array',
        'gallery' => 'array',
        'property_type' => 'array',
        'location_text' => 'array',
        'amenities' => 'array',
        'house_rules' => 'array',
        'includes' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
        'rating' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function getTranslated(string $field, string $fallback = 'es'): string
    {
        $value = $this->{$field} ?? null;

        if (is_array($value)) {
            return $value[app()->getLocale()]
                ?? $value[$fallback]
                ?? '';
        }

        return $value ?? '';
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/default-accommodation.jpg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset($this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}