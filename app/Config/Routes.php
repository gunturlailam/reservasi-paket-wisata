<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// LOGIN & DASHBOARD
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/dashboard', 'Login::dashboard');
$routes->get('/logout', 'Login::logout');

// JABATAN
$routes->get('/jabatan', 'Jabatan::index');
$routes->post('/jabatan/save', 'Jabatan::save');
$routes->get('/jabatan/delete/(:num)', 'Jabatan::delete/$1');
$routes->get('/jabatan/get/(:num)', 'Jabatan::getjabatan/$1');

// LAPORAN JABATAN
$routes->get('/laporanjabatan', 'Laporanjabatan::index');
$routes->get('/laporanjabatan/cetak', 'Laporanjabatan::cetak');

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

// LAPORAN PEMBERANGKATAN
$routes->get('/laporanpemberangkatan', 'Laporanpemberangkatan::index');
$routes->get('/laporanpemberangkatan/cetak', 'Laporanpemberangkatan::cetak');

// PEMESANAN
$routes->get('/pemesanan', 'Pemesanan::index');
$routes->post('/pemesanan/save', 'Pemesanan::save');
$routes->get('/pemesanan/delete/(:num)', 'Pemesanan::delete/$1');
$routes->get('/pemesanan/get/(:num)', 'Pemesanan::getpemesanan/$1');
$routes->get('/pemesanan/laporan', 'Pemesanan::laporan');

// LAPORAN PEMESANAN
$routes->get('/laporanpemesanan', 'Laporanpemesanan::index');
$routes->get('/laporanpemesanan/cetak', 'Laporanpemesanan::cetak');

// PEMBAYARAN
$routes->get('/pembayaran', 'Pembayaran::index');
$routes->get('/pembayaran/debug', 'Pembayaran::debug');
$routes->post('/pembayaran/save', 'Pembayaran::save');
$routes->post('/pembayaran/tambah', 'Pembayaran::tambah');
$routes->post('/pembayaran/konfirmasi', 'Pembayaran::konfirmasi');
$routes->get('/pembayaran/delete/(:num)', 'Pembayaran::delete/$1');
$routes->get('/pembayaran/get/(:num)', 'Pembayaran::getpembayaran/$1');
$routes->get('/pembayaran/detail/(:num)', 'Pembayaran::detail/$1');
$routes->get('/pembayaran/proses/(:num)', 'Pembayaran::proses/$1');

// LAPORAN PEMBAYARAN
$routes->get('/laporanpembayaran', 'Laporanpembayaran::index');
$routes->get('/laporanpembayaran/cetak', 'Laporanpembayaran::cetak');

// PEMESANAN DETAIL
$routes->get('/pemesanan-detail', 'PemesananDetail::index');
$routes->post('/pemesanan-detail/save', 'PemesananDetail::save');
$routes->get('/pemesanan-detail/delete/(:num)', 'PemesananDetail::delete/$1');
$routes->get('/pemesanan-detail/get/(:num)', 'PemesananDetail::getpemesananDetail/$1');

// LAPORAN PEMESANAN DETAIL
$routes->get('/laporanpemesanandetail', 'Laporanpemesanandetail::index');
$routes->get('/laporanpemesanandetail/cetak', 'Laporanpemesanandetail::cetak');

// KARYAWAN
$routes->get('/karyawan', 'Karyawan::index');
$routes->post('/karyawan/save', 'Karyawan::save');
$routes->get('/karyawan/delete/(:num)', 'Karyawan::delete/$1');
$routes->get('/karyawan/get/(:num)', 'Karyawan::getkaryawan/$1');

// LAPORAN KARYAWAN
$routes->get('/laporankaryawan', 'Laporankaryawan::index');
$routes->get('/laporankaryawan/cetak', 'Laporankaryawan::cetak');

// JENIS BUS
$routes->get('/jenisbus', 'Jenisbus::index');
$routes->post('/jenisbus/save', 'Jenisbus::save');
$routes->get('/jenisbus/delete/(:num)', 'Jenisbus::delete/$1');
$routes->get('/jenisbus/get/(:num)', 'Jenisbus::getjenisbus/$1');

// LAPORAN JENIS BUS
$routes->get('/laporanjenisbus', 'Laporanjenisbus::index');
$routes->get('/laporanjenisbus/cetak', 'Laporanjenisbus::cetak');

// BUS
$routes->get('/bus', 'Bus::index');
$routes->post('/bus/save', 'Bus::save');
$routes->get('/bus/delete/(:num)', 'Bus::delete/$1');
$routes->get('/bus/get/(:num)', 'Bus::getbus/$1');

// LAPORAN BUS
$routes->get('/laporanbus', 'Laporanbus::index');
$routes->get('/laporanbus/cetak', 'Laporanbus::cetak');

// LAPORAN PAKET WISATA
$routes->get('/laporanpaketwisata', 'Laporanpaketwisata::index');
$routes->get('/laporanpaketwisata/cetak', 'Laporanpaketwisata::cetak');

// LAPORAN PAKET BUS
$routes->get('/laporanpaketbus', 'Laporanpaketbus::index');
$routes->get('/laporanpaketbus/cetak', 'Laporanpaketbus::cetak');

// LAPORAN PEMILIK
$routes->get('/laporanpemilik', 'Laporanpemilik::index');
$routes->get('/laporanpemilik/cetak', 'Laporanpemilik::cetak');

// LAPORAN PENYEWA
$routes->get('/laporanpenyewa', 'Laporanpenyewa::index');
$routes->get('/laporanpenyewa/cetak', 'Laporanpenyewa::cetak');

// PAKET WISATA
$routes->get('/paketwisata', 'Paketwisata::index');
$routes->post('/paketwisata/save', 'Paketwisata::save');
$routes->get('/paketwisata/delete/(:num)', 'Paketwisata::delete/$1');
$routes->get('/paketwisata/get/(:num)', 'Paketwisata::getbus/$1');

// PEMILIK
$routes->get('/pemilik', 'Pemilik::index');
$routes->post('/pemilik/save', 'Pemilik::save');
$routes->get('/pemilik/delete/(:num)', 'Pemilik::delete/$1');
$routes->get('/pemilik/get/(:num)', 'Pemilik::getpemilik/$1');

// PEMILIK
$routes->get('/pemilik', 'Pemilik::index');
$routes->post('/pemilik/save', 'Pemilik::save');
$routes->get('/pemilik/delete/(:num)', 'Pemilik::delete/$1');
$routes->get('/pemilik/get/(:num)', 'Pemilik::getpemilik/$1');

// REGISTER
$routes->get('/register', 'Register::register');
$routes->post('/register/store', 'Register::store');

// ADMIN DASHBOARD
$routes->get('admin/dashboard', 'Admin::dashboard');

// KARYAWAN DASHBOARD
$routes->get('karyawan/dashboard', 'Karyawan::dashboard');

// PENYEWA DASHBOARD
$routes->get('penyewa/dashboard', 'Penyewa::dashboard');

// SUPIR DASHBOARD
$routes->get('supir/dashboard', 'Supir::dashboard');

// PEMILIK DASHBOARD
$routes->get('pemilik/dashboard', 'Pemilik::dashboard');
