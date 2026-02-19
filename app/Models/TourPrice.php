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
        'is_free' => 'boolean'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
