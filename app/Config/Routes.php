<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');

// JABATAN
$routes->get('/jabatan', 'Jabatan::index');
$routes->post('/jabatan/save', 'Jabatan::save');
$routes->get('/jabatan/delete/(:num)', 'Jabatan::delete/$1');
$routes->get('/jabatan/get/(:num)', 'Jabatan::getjabatan/$1');

// PAKET BUS
$routes->get('/paketbus', 'Paketbus::index');
$routes->post('/paketbus/save', 'Paketbus::save');
$routes->get('/paketbus/delete/(:num)', 'Paketbus::delete/$1');
$routes->get('/paketbus/get/(:num)', 'Paketbus::getpaketbus/$1');

// PENYEWA
$routes->get('/penyewa', 'Penyewa::index');
$routes->post('/penyewa/save', 'Penyewa::save');
$routes->get('/penyewa/delete/(:num)', 'Penyewa::delete/$1');
$routes->get('/penyewa/get/(:num)', 'Penyewa::getpenyewa/$1');

// PEMBERANGKATAN
$routes->get('/pemberangkatan', 'Pemberangkatan::index');
$routes->post('/pemberangkatan/save', 'Pemberangkatan::save');
$routes->get('/pemberangkatan/delete/(:num)', 'Pemberangkatan::delete/$1');
$routes->get('/pemberangkatan/get/(:num)', 'Pemberangkatan::getpemberangkatan/$1');

// PEMESANAN
$routes->get('/pemesanan', 'Pemesanan::index');
$routes->post('/pemesanan/save', 'Pemesanan::save');
$routes->get('/pemesanan/delete/(:num)', 'Pemesanan::delete/$1');
$routes->get('/pemesanan/get/(:num)', 'Pemesanan::getpemesanan/$1');
$routes->get('/pemesanan/laporan', 'Pemesanan::laporan');

// PEMBAYARAN
$routes->get('/pembayaran', 'Pembayaran::index');
$routes->post('/pembayaran/save', 'Pembayaran::save');
$routes->get('/pembayaran/delete/(:num)', 'Pembayaran::delete/$1');
$routes->get('/pembayaran/get/(:num)', 'Pembayaran::getpembayaran/$1');

// PEMESANAN DETAIL
$routes->get('/pemesanan-detail', 'PemesananDetail::index');
$routes->post('/pemesanan-detail/save', 'PemesananDetail::save');
$routes->get('/pemesanan-detail/delete/(:num)', 'PemesananDetail::delete/$1');
$routes->get('/pemesanan-detail/get/(:num)', 'PemesananDetail::getpemesananDetail/$1');

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

// PAKET WISATA
$routes->get('/paketwisata', 'Paketwisata::index');
$routes->post('/paketwisata/save', 'Paketwisata::save');
$routes->get('/paketwisata/delete/(:num)', 'Paketwisata::delete/$1');
$routes->get('/paketwisata/get/(:num)', 'Paketwisata::getbus/$1');

$routes->group('', ['namespace' => 'App\Controllers'], static function ($routes) {
    // Auth views
    $routes->get('login', 'Login::index');
    $routes->post('login/authenticate', 'Login::authenticate');
    $routes->get('login/dashboard', 'Login::dashboard');
    $routes->get('logout', 'Login::logout');
    $routes->get('register', 'Register::register');
    $routes->post('register/store', 'Register::store');
});
