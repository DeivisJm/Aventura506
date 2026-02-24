<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'tour_price_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function tourPrice(): BelongsTo
    {
        return $this->belongsTo(TourPrice::class);
    }
}