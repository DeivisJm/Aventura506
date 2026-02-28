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
    ->withMiddleware(function (Middleware $middleware) {

        // Define web middleware group
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetLocale::class,
        ]);

        // Register middleware aliases
        $middleware->alias([
            'auth' => \App\Http\Middleware\AdminAuthenticate::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
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
