<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware dengan nama alias 'is_admin'
        $middleware->alias([
            'is_admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

// Filesystem Vercel bersifat read-only kecuali /tmp, jadi storage Laravel
// (view cache, session file, log) dialihkan ke /tmp saat berjalan di sana.
if (getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;