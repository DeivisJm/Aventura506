<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    protected $fillable = [
        'tour_id',
        'start_time',
        'active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'active' => 'boolean'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
