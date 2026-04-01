<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            if (Route::has('login')) {
                return;
            }

            Route::middleware('web')->group(function () {
                Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
                Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Railway / nginx 等のリバースプロキシの X-Forwarded-* を信頼しないと
        // HTTPS 判定・セッション Cookie・リダイレクト先 URL が壊れる
        $middleware->trustProxies(at: '*');
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn () => route('books.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
