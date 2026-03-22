<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo 'APP_ENV=' . config('app.env') . PHP_EOL;
echo 'APP_KEY=' . (config('app.key') ? 'set' : 'missing') . PHP_EOL;
