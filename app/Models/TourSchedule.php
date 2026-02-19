<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    protected $fillable = [
        'tour_id',
        'start_time'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i'
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
