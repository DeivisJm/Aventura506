<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'short_description',
        'image',
        'is_active'
    ];
    protected $casts = [
        'description' => 'array',
        'short_description' => 'array',
    ];


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
