<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn() => route('login'));
        $middleware->redirectUsersTo(function () {
            $user = Illuminate\Support\Facades\Auth::user();
            if ($user) {
                if ($user->rol_id == 5) { // Acudiente
                    return route('mis_hijos');
                }
                // Administrador y otros roles de personal
                return route('listaAprendiz');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
