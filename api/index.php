<?php

// Entry point untuk Vercel serverless function.
// Redirect storage Laravel ke /tmp (satu-satunya folder yang writable
// di runtime serverless Vercel) sebelum aplikasi di-boot.
if (getenv('VERCEL')) {
    $dirs = [
        '/tmp/storage/app/public',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/testing',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}

require __DIR__.'/../public/index.php';
