<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Rute Halaman Utama Pelanggan
$routes->get('/', 'Home::index');
$routes->get('pelanggan', 'Home::index');
$routes->get('menu', 'Home::menu');
$routes->get('rating', 'RatingCustomer::index');
$routes->post('rating/store', 'RatingCustomer::store');

// Rute Halaman Riwayat Pesanan Pelanggan
$routes->get('pesanan', 'Pesanan::index');
$routes->get('pesanan/riwayat', 'Pesanan::riwayat');
$routes->post('pesanan/rating/simpan/(:num)', 'Pesanan::simpanRating/$1');

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
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->post('login/store', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register/store', 'Auth::store');
$routes->get('logout', 'Auth::logout');

// ====================================================================
// HALAMAN ADMIN (GRUP RUTE YANG SUDAH DIPROTEKSI DENGAN FILTER 'auth')
// ====================================================================

$routes->group('admin', ['filter' => 'auth'], function($routes) {

    $routes->get('/', 'Admin\Dashboard::index');

    $routes->get('pesanan', 'Admin\Dashboard::pesanan');
    $routes->get('menu', 'Admin\Dashboard::menu');
    $routes->get('meja', 'Admin\Dashboard::meja');
    $routes->get('pelanggan', 'Admin\Dashboard::pelanggan');
    $routes->post('pelanggan_tambah', 'Admin\Dashboard::pelanggan_tambah');
    $routes->get('pelanggan_hapus/(:num)', 'Admin\Dashboard::pelanggan_hapus/$1');
    $routes->get('transaksi', 'Admin\Dashboard::transaksi');
    $routes->get('laporan', 'Admin\Dashboard::laporan');
    $routes->get('pengaturan', 'Admin\Dashboard::pengaturan');

    $routes->post('menu/add', 'Admin\Dashboard::addMenu');
    $routes->post('menu/edit/(:num)', 'Admin\Dashboard::updateMenu/$1');
    $routes->get('menu/delete/(:num)', 'Admin\Dashboard::deleteMenu/$1');

    $routes->post('meja/simpan', 'Admin\Dashboard::simpanMeja');
    $routes->post('meja/update/(:num)', 'Admin\Dashboard::updateMeja/$1');
    $routes->get('meja/delete/(:num)', 'Admin\Dashboard::deleteMeja/$1');

    $routes->get('detail/(:num)', 'Admin\Dashboard::detail/$1');
    $routes->post('update-status/(:num)', 'Admin\Dashboard::updateStatus/$1');
    $routes->post('pay/(:num)', 'Admin\Dashboard::processPayment/$1');
    $routes->post('batalkan/(:num)', 'Admin\Dashboard::batalkan/$1');

    $routes->post('pengaturan/update-password', 'Admin\Dashboard::updatePassword');
    $routes->post('pengaturan/update-settings', 'Admin\Dashboard::updateSettings');

    $routes->get('grafik-realtime', 'Admin\Dashboard::grafikRealtime');

});

$routes->group('owner', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Owner\Dashboard::index');
    $routes->get('transaksi', 'Owner\Dashboard::transaksi');

    $routes->get('menu-approval', 'Admin\Owner\MenuApproval::index');
    $routes->post('menu-approval/approve/(:num)', 'Admin\Owner\MenuApproval::approve/$1');
    $routes->post('menu-approval/reject/(:num)', 'Admin\Owner\MenuApproval::reject/$1');

    // Karyawan
    $routes->get('karyawan', 'Owner\Karyawan::index');
    $routes->get('karyawan/create', 'Owner\Karyawan::create');
    $routes->post('karyawan/store', 'Owner\Karyawan::store');
    $routes->get('karyawan/edit/(:num)', 'Owner\Karyawan::edit/$1');
    $routes->post('karyawan/update-status/(:num)', 'Owner\Karyawan::updateStatus/$1');
    $routes->get('karyawan/delete/(:num)', 'Owner\Karyawan::delete/$1');
    $routes->post('karyawan/delete/(:num)', 'Owner\Karyawan::delete/$1');
    $routes->post('karyawan/update/(:num)', 'Owner\Karyawan::update/$1');

    // Meja
    $routes->get('meja', 'Owner\MejaController::index');
    $routes->post('meja/simpan', 'Owner\MejaController::simpan');
    $routes->post('meja/update/(:num)', 'Owner\MejaController::update/$1');
    $routes->get('meja/hapus/(:num)', 'Owner\MejaController::hapus/$1');

    // QR Code
    $routes->get('qrcode', 'QrcodeController::index');

    // Rating & Ulasan
    $routes->get('rating', 'Owner\Rating::index');

    // Laporan Keuangan
    $routes->get('laporan', 'Owner\Laporan::index');

    // Pengaturan
    $routes->get('pengaturan', 'Owner\Pengaturan::index');
    $routes->post('pengaturan/update-settings', 'Owner\Pengaturan::updateSettings');
    $routes->post('pengaturan/update-password', 'Owner\Pengaturan::updatePassword');
});