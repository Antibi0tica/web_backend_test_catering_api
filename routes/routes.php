<?php

/** @var Bramus\Router\Router $router */

// Define routes here
$router->get('/test', App\Controllers\IndexController::class . '@test');
$router->get('/', App\Controllers\IndexController::class . '@test');
$router->get('/menu', App\Controllers\MenuController::class . '@getMenu');
$router->post('/facility', App\Controllers\FacilityController::class . '@FacilityController');
$router->get('/readtest', App\Controllers\FacilityController::class . '@readtest');