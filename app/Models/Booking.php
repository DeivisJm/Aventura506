<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
    'tour_id',
    'name',
    'email',
    'phone',
    'nationality',
    'persons',
    'date',
    'time',
    'total',
    'status',
];


    /**
     * Booking belongs to a tour.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    /**
     * Booking has many detail rows (Adult, Child, etc)
     */
    public function details()
    {
        return $this->hasMany(\App\Models\BookingDetail::class);
    }
}
