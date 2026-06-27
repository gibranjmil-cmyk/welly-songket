<?php

declare(strict_types=1);

use WellySongket\Controllers\Front\HomeController;

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
*/

$router->get(
    '/',
    HomeController::class,
    'index',
    'home'
);