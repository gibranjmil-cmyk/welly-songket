<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Load Autoloader
|--------------------------------------------------------------------------
| Prefer Composer vendor autoload. If not present (e.g. after fresh clone
| without running `composer install`), fall back to a minimal PSR-4
| autoloader so the app can still boot.
*/

$composerAutoload = BASE_PATH . '/vendor/autoload.php';

if (is_file($composerAutoload)) {
    require $composerAutoload;
} else {
    // Minimal PSR-4 fallback: WellySongket\ → app/
    spl_autoload_register(static function (string $class): void {
        $prefix = 'WellySongket\\';
        $baseDir = BASE_PATH . '/app/';

        if (!str_starts_with($class, $prefix)) {
            return;
        }

        $relative = substr($class, strlen($prefix));
        $file = $baseDir . str_replace('\\', '/', $relative) . '.php';

        if (is_file($file)) {
            require $file;
        }
    });

    // Load helpers manually (Composer would handle this via files autoload)
    require BASE_PATH . '/app/Helpers/helpers.php';
}

/*
|--------------------------------------------------------------------------
| Bootstrap Application
|--------------------------------------------------------------------------
*/

$app = require BASE_PATH . '/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run Application
|--------------------------------------------------------------------------
*/

$app->run();
