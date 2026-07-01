<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Rute Halaman Utama Pelanggan
$routes->get('/', 'Home::index');
$routes->get('pelanggan', 'Home::index'); 
$routes->get('menu', 'Home::menu');

// Rute Halaman Riwayat Pesanan Pelanggan
$routes->get('pesanan', 'Pesanan::index'); // <-- DITAMBAHKAN
$routes->get('pesanan/riwayat', 'Pesanan::riwayat'); // <-- TAMBAHAN BARU (arsip)

// Rute untuk Fitur Keranjang Belanja Pelanggan
$routes->get('cart', 'Cart::index');          
$routes->post('cart/add', 'Cart::add');       
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->get('cart/decrease/(:any)', 'Cart::decrease/$1');
$routes->post('cart/decrease_ajax', 'Cart::decrease_ajax');

// Rute untuk Fitur Checkout Pelanggan
$routes->get('checkout', 'Cart::checkout');
$routes->post('checkout/process', 'Cart::process');

// Rute untuk Fitur Autentikasi Login & Logout
$routes->get('login', 'Auth::index');   // GET -> tampilkan form login
$routes->post('login', 'Auth::login');  // POST -> proses login
$routes->post('login/store', 'Auth::attemptLogin'); // sesuaikan nama method
$routes->get('register', 'Auth::register');
$routes->post('register/store', 'Auth::store');
$routes->get('logout', 'Auth::logout');

// ====================================================================
// HALAMAN ADMIN (GRUP RUTE YANG SUDAH DIPROTEKSI DENGAN FILTER 'auth')
// ====================================================================
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    
    // Dashboard Utama Admin (Mengarah ke Controller Dashboard)
    $routes->get('/', 'Admin\Dashboard::index'); 
    
    // RUTE SIDEBAR
    $routes->get('pesanan', 'Admin\Dashboard::pesanan');
    $routes->get('menu', 'Admin\Dashboard::menu');
    $routes->get('meja', 'Admin\Dashboard::meja');
    $routes->get('pelanggan', 'Admin\Dashboard::pelanggan');
    $routes->get('transaksi', 'Admin\Dashboard::transaksi');
    $routes->get('laporan', 'Admin\Dashboard::laporan');
    $routes->get('pengaturan', 'Admin\Dashboard::pengaturan');
    
    // PROSES CRUD MENU KAFE (Sudah diselipkan di dalam grup admin)
    $routes->post('menu/add', 'Admin\Dashboard::addMenu');
    $routes->post('menu/edit/(:num)', 'Admin\Dashboard::updateMenu/$1');
    $routes->get('menu/delete/(:num)', 'Admin\Dashboard::deleteMenu/$1');

    // RUTE PROSES TAMBAH MEJA (DITAROH DI SINI)
    $routes->post('meja/simpan', 'Admin\Dashboard::simpanMeja');
    $routes->post('meja/update/(:num)', 'Admin\Dashboard::updateMeja/$1'); // <-- TAMBAH INI
    $routes->get('meja/delete/(:num)', 'Admin\Dashboard::deleteMeja/$1');  // <-- TAMBAH INI
    
    // ====================================================================
    // PERBAIKAN DI SINI: Diarahkan murni ke Controller Admin (\App\Controllers\Admin)
    // agar pembacaan $_POST['payment_method'] dari dropdown detail.php berfungsi!
    // ====================================================================
    $routes->get('detail/(:num)', 'Admin::detail/$1');
    $routes->post('update-status/(:num)', 'Admin::updateStatus/$1');
    $routes->post('pay/(:num)', 'Admin::processPayment/$1');
    $routes->post('batalkan/(:num)', 'Admin::batalkan/$1');
    
    // Jalur Proses Simpan Pengaturan & Password
    $routes->post('pengaturan/update-password', 'Admin\Dashboard::updatePassword');
    $routes->post('pengaturan/update-settings', 'Admin\Dashboard::updateSettings');
});

$routes->group('owner', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Owner\Dashboard::index');
    $routes->get('laporan', 'Owner\Dashboard::laporan');
    $routes->get('transaksi', 'Owner\Dashboard::transaksi');

    // Karyawan
    $routes->get('karyawan', 'Owner\Karyawan::index');
    $routes->get('karyawan/create', 'Owner\Karyawan::create');
    $routes->post('karyawan/store', 'Owner\Karyawan::store');
    $routes->get('karyawan/edit/(:num)', 'Owner\Karyawan::edit/$1');
    $routes->post('karyawan/update-status/(:num)', 'Owner\Karyawan::updateStatus/$1');
    $routes->get('karyawan/delete/(:num)', 'Owner\Karyawan::delete/$1');
});