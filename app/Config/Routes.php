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

// KARYAWAN
$routes->get('/karyawan', 'Karyawan::index');
$routes->post('/karyawan/save', 'Karyawan::save');
$routes->get('/karyawan/delete/(:num)', 'Karyawan::delete/$1');
$routes->get('/karyawan/get/(:num)', 'Karyawan::getkaryawan/$1');

// JENIS BUS
$routes->get('/jenisbus', 'Jenisbus::index');
$routes->post('/jenisbus/save', 'Jenisbus::save');
$routes->get('/jenisbus/delete/(:num)', 'Jenisbus::delete/$1');
$routes->get('/jenisbus/get/(:num)', 'Jenisbus::getjenisbus/$1');

// BUS
$routes->get('/bus', 'Bus::index');
$routes->post('/bus/save', 'Bus::save');
$routes->get('/bus/delete/(:num)', 'Bus::delete/$1');
$routes->get('/bus/get/(:num)', 'Bus::getbus/$1');
