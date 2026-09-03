<?php

function mark($msg) {
    echo $msg . "\n";
    if (ob_get_level() > 0) { @ob_flush(); }
    @flush();
}

header('Content-Type: text/plain');
mark('1. START');

require __DIR__.'/../vendor/autoload.php';
mark('2. AUTOLOAD OK');

$app = require __DIR__.'/../bootstrap/app.php';
mark('3. APP CONFIGURED: '.get_class($app));

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
mark('4. KERNEL RESOLVED');

$request = Illuminate\Http\Request::capture();
mark('5. REQUEST CAPTURED');

$response = $kernel->handle($request);
mark('6. REQUEST HANDLED, status='.$response->getStatusCode());

$kernel->terminate($request, $response);
mark('7. DONE');
