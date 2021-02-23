<?php

require_once './app/core/autoloader.php';
require_once './app/core/bootstrap.php';

$app = new App\Core\Application();

$app->controllers([
    App\Controllers\MyController::class
]);

$app->start();