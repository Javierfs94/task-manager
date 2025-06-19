<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(EncryptCookies::class);
        $middleware->append(\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class);
        $middleware->append(\Illuminate\Session\Middleware\StartSession::class);
        $middleware->append(\Illuminate\View\Middleware\ShareErrorsFromSession::class);
        $middleware->append(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $middleware->append(SetLocale::class);
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
