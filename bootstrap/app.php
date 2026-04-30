<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Hub gate: use `approved` on authenticated route groups in routes/web.php
        $middleware->alias([
            'approved' => \App\Http\Middleware\EnsureAccountIsApproved::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'redirect.auth' => \App\Http\Middleware\RedirectAuthenticatedUsers::class,
        ]);

        $middleware->redirectTo(
            guests: '/login',
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();