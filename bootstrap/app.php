<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    /*
    |--------------------------------------------------------------------------
    | Routing configuration
    |--------------------------------------------------------------------------
    | Here we define the route files used by the application.
    */
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    /*
    |--------------------------------------------------------------------------
    | Middleware configuration
    |--------------------------------------------------------------------------
    | This is the correct place (Laravel 11+) to register middleware.
    | We append SetLocale middleware to the "web" group so it runs
    | on every web request.
    */
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware) {
        $middleware->web(\App\Http\Middleware\SetLocale::class);
    })


    /*
    |--------------------------------------------------------------------------
    | Exception handling
    |--------------------------------------------------------------------------
    */
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
