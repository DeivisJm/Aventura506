<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $fillable = [
        'booking_id',
        'tour_price_id',
        'quantity',
        'price',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function price()
    {
        return $this->belongsTo(TourPrice::class, 'tour_price_id');
    }
    public function tourPrice()
    {
        return $this->belongsTo(\App\Models\TourPrice::class);
    }
}
