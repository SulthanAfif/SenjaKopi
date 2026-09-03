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
        // VIEW_COMPILED_PATH di vercel.json menunjuk ke /tmp/views (bukan
        // /tmp/storage/framework/views), jadi folder ini juga wajib dibuat,
        // kalau tidak Blade gagal menulis compiled view -> fatal error 500.
        '/tmp/views',
    ];

    foreach ($dirs as $dir) {
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
    }

    // Database (Aiven MySQL) mewajibkan koneksi SSL. Sertifikat CA-nya
    // ikut di-commit ke repo (storage/certs/aiven-ca.pem, bukan rahasia),
    // dan path-nya dihitung otomatis dari lokasi file ini supaya tidak
    // tergantung struktur folder absolut di runtime serverless Vercel.
    // Env var MYSQL_ATTR_SSL_CA di Vercel dashboard TIDAK PERLU diisi manual.
    $caPath = __DIR__.'/../storage/certs/aiven-ca.pem';
    if (is_file($caPath) && ! getenv('MYSQL_ATTR_SSL_CA')) {
        putenv('MYSQL_ATTR_SSL_CA='.$caPath);
        $_ENV['MYSQL_ATTR_SSL_CA'] = $caPath;
        $_SERVER['MYSQL_ATTR_SSL_CA'] = $caPath;
    }
}

require __DIR__.'/../public/index.php';
