<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This defines which mailer transport Laravel will use.
    | We are using SMTP (Gmail) powered by Symfony Mailer.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env(
                'MAIL_EHLO_DOMAIN',
                parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)
            ),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        /*
        |--------------------------------------------------------------------------
        | Failover configuration
        | If SMTP fails, fallback to log
        |--------------------------------------------------------------------------
        */
        'failover' => [
            'transport' => 'failover',
            'mailers' => ['smtp', 'log'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-reply@aventura506.com'),
        'name' => env('MAIL_FROM_NAME', 'Aventura506'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Booking Receiver Email
    |--------------------------------------------------------------------------
    | Used to receive booking notifications.
    */

    'booking_receiver' => env('BOOKING_RECEIVER_EMAIL', null),

];
