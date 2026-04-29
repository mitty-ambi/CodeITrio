<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'LivreController::index');
$routes->get('/livres', 'LivreController::index');
$routes->get('/livres/(:num)', 'LivreController::detail/$1');