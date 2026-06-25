<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('pelanggan', 'Home::index'); // FIX: Arahkan URL /pelanggan ke Home::index

// Rute untuk fitur Keranjang Belanja
$routes->get('cart', 'Cart::index');          
$routes->post('cart/add', 'Cart::add');       
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->get('cart/decrease/(:any)', 'Cart::decrease/$1');

$routes->get('checkout', 'Cart::checkout');
$routes->post('checkout/process', 'Cart::process');