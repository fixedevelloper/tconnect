<?php

use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureRemoteApiAvailable;
use App\Http\Middleware\EnsureRemoteSandboxApiAvailable;
use App\Http\Middleware\LogFilteredApiRequests;
use App\Http\Middleware\VerifyUserJwt;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'logs.api' => LogFilteredApiRequests::class,
        'remote.api' => EnsureRemoteApiAvailable::class,
        'sandbox.api' => EnsureRemoteSandboxApiAvailable::class,
        'isAdmin' => EnsureIsAdmin::class,
        'user.jwt' => VerifyUserJwt::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
