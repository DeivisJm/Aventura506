<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ExchangeRate extends Model
{
    protected $fillable = [
        'key',
        'value'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {

            // limpia cache cuando cambie el tipo de cambio
            Cache::forget('usd_to_crc');
        });
    }

    /**
     * Obtener tipo de cambio por clave
     */
    public static function getValue($key)
    {
        return Cache::rememberForever($key, function () use ($key) {

            return self::where('key', $key)
                ->value('value');
        });
    }

    /**
     * Shortcut para USD → CRC
     */
    public static function usd()
    {
        return self::getValue('usd_to_crc');
    }
}
