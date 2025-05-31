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
