<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api/admin')
                ->name('api.admin.')
                ->group(base_path('routes/api/admin.php'));

            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api/client')
                ->name('api.client.')
                ->group(base_path('routes/api/client.php'));

            Route::middleware(['api'])
                ->prefix('api')
                ->group(base_path('routes/api/shared.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Shared\Middlewares\MetricsMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
