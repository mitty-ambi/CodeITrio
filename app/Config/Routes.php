<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/eleve/create', 'ElevesController::create');
$routes->post('/eleve/create', 'ElevesController::store');
$routes->get('/eleve/success', 'ElevesController::success');
$routes->get('/eleve/update/(:num)', 'ElevesController::update/$1');
$routes->post('/eleve/update/(:num)', 'ElevesController::updateStore/$1');
$routes->get('/eleves', 'ElevesController::index');
$routes->post('/eleve/delete/(:num)', 'ElevesController::delete/$1');