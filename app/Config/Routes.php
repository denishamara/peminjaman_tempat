<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::landing'); // atau sesuai controller kamu
$routes->get('landing', 'Home::landing');

// Jadwal publik (tanpa login)
$routes->get('jadwal/public', 'JadwalController::publicIndex');

$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);


// Auth Routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::loginPost');

$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::registerPost');

$routes->get('auth/logout', 'Auth::logout');

// Ruang routes
$routes->get('ruang/index', 'RuangController::index');
$routes->get('ruang/create', 'RuangController::create');
$routes->post('ruang/store', 'RuangController::store');
$routes->get('ruang/edit/(:num)', 'RuangController::edit/$1');
$routes->post('ruang/update/(:num)', 'RuangController::update/$1');
$routes->delete('ruang/delete/(:num)', 'RuangController::delete/$1');

// Jadwal routes
$routes->get('jadwal/index', 'JadwalController::index');
$routes->get('jadwal/create', 'JadwalController::create');
$routes->post('jadwal/store', 'JadwalController::store');
$routes->get('jadwal/edit/(:num)', 'JadwalController::edit/$1');
$routes->post('jadwal/update/(:num)', 'JadwalController::update/$1');
$routes->delete('jadwal/delete/(:num)', 'JadwalController::delete/$1');

$routes->group('administrator', ['filter' => 'auth:administrator'], function($routes) {
    $routes->get('users', 'UserController::index');
    $routes->get('users/index', 'UserController::index');
    $routes->get('users/create', 'UserController::createForm');
    $routes->post('users/create', 'UserController::create');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->delete('users/delete/(:num)', 'UserController::delete/$1');
});

// Peminjaman routes for peminjam (filter by role peminjam)
$routes->group('peminjaman', ['filter' => 'auth:peminjam'], function($routes) {
    $routes->get('ajukan', 'PeminjamanController::ajukan');
    $routes->post('submit', 'PeminjamanController::submit');
    $routes->get('daftar', 'PeminjamanController::daftar');
    $routes->get('detail/(:num)', 'PeminjamanController::detail/$1');
    $routes->get('history', 'PeminjamanController::history');
}); 

$routes->post('peminjaman/riwayat/delete/(:num)', 'PeminjamanController::delete/$1');

$routes->group('petugas', function($routes) {
    $routes->get('peminjaman_daftar', 'PetugasController::peminjaman_daftar');
    $routes->get('detail/(:num)', 'PetugasController::detail/$1');
    $routes->get('setuju/(:num)', 'PetugasController::setuju/$1');
    $routes->get('tolak/(:num)', 'PetugasController::tolak/$1');
    $routes->get('hapus/(:num)', 'PetugasController::hapus/$1');
});

// Laporan routes (filter & generate PDF)
$routes->group('laporan', ['filter' => 'auth'], function($routes) {
    // Halaman filter laporan
    $routes->get('/', 'LaporanController::index');
    
    // Generate laporan PDF
    $routes->post('generate', 'LaporanController::generate');
});
// 📞 Halaman kontak untuk semua user
$routes->get('kontak', 'KontakController::index');

// 📞 Hanya admin yang boleh edit/update
$routes->group('administrator', ['filter' => 'auth:administrator'], function($routes) {
    $routes->get('kontak', 'KontakController::index');
    $routes->get('kontak/edit/(:num)', 'KontakController::edit/$1');
    $routes->post('kontak/update/(:num)', 'KontakController::update/$1');
});

// ================= PROFILE =================
$routes->get('/profile', 'ProfileController::index');
$routes->get('/profile/edit', 'ProfileController::edit');
$routes->post('/profile/update', 'ProfileController::update');
$routes->get('/profile/deletePhoto', 'ProfileController::deletePhoto');

$routes->get('jadwal/kalender', 'JadwalController::kalender');
$routes->get('jadwal/getKalenderData', 'JadwalController::getKalenderData');










