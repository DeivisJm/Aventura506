<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'tour_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'guest_nationality',
        'date',
        'time',
        'total',
        'status',
        'notes',
        'currency',
    ];

    protected $casts = [
        'date'  => 'date:Y-m-d',
        'time'  => 'string',
        'total' => 'decimal:2',
    ];
    public function getFormattedDateAttribute()
    {
        return $this->date
            ? \Carbon\Carbon::parse($this->date)
            ->locale(app()->getLocale())
            ->translatedFormat('F d, Y')
            : null;
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(\App\Models\BookingDetail::class);
    }
}
