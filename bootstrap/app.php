<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function ($router) {
            if (file_exists($forms = __DIR__.'/../routes/forms.php')) {
                require $forms;
            }
            if (file_exists($frontend = __DIR__.'/../routes/frontend.php')) {
                require $frontend;
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Exclude payment webhook routes from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'payment/webhook/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
