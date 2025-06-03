<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Add routes for all navigation links
$routes->get('manage-room', 'Room::index');
$routes->get('manage-tenant', 'Tenant::index');
$routes->get('maintenance', 'Maintenance::index');
$routes->get('floor-plan', 'FloorPlan::index');
$routes->get('generate-report', 'Report::index');
// Room management API endpoints
$routes->post('room/create', 'Room::create');
$routes->post('room/update/(:num)', 'Room::update/$1');
$routes->post('room/delete/(:num)', 'Room::delete/$1');
$routes->get('room/get/(:num)', 'Room::get/$1');
$routes->get('room/getRoomDetails/(:num)', 'Room::getRoomDetails/$1');