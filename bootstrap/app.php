<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\EnsureEmailIsNotVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user' => UserMiddleware::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
            'verified' =>\Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'EnsureEmailIsNotVerified'=>EnsureEmailIsNotVerified::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
