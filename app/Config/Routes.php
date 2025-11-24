<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// JABATAN
$routes->get('/jabatan', 'Jabatan::index');
$routes->post('/jabatan/save', 'Jabatan::save');
$routes->get('/jabatan/delete/(:num)', 'Jabatan::delete/$1');
$routes->get('/jabatan/get/(:num)', 'Jabatan::getjabatan/$1');
