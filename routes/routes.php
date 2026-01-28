<?php

/** @var Bramus\Router\Router $router */

// Define routes here
$router->get('/test', App\Controllers\IndexController::class . '@test');
$router->get('/', App\Controllers\IndexController::class . '@test');
$router->get('/menu', App\Controllers\MenuController::class . '@getMenu');
$router->post('/facility/create', App\Controllers\FacilityController::class . '@createController');
$router->get('/facility', App\Controllers\FacilityController::class . '@readAllController');
$router->get('/facility/(\d+)', App\Controllers\FacilityController::class . '@readOneController');
$router->put('/update_facility/(\d+)',App\Controllers\FacilityController::class . '@updateController');
$router->delete('/delete_facility/(\d+)',App\Controllers\FacilityController::class . '@deleteController');
$router->get('/facility/search', App\Controllers\FacilityController::class . '@searchController');