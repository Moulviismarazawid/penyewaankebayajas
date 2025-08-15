<?php

use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');

$routes->get('produk', 'Products::index');
$routes->get('produk/(:segment)', 'Products::show/$1');

$routes->group('cart', function($r){
    $r->get('/', 'Cart::index');
    $r->post('add', 'Cart::add');
    $r->post('remove', 'Cart::remove');
    $r->post('clear', 'Cart::clear');
});

$routes->group('auth', function($r){
    $r->get('login', 'Auth::login');
    $r->post('login', 'Auth::attempt');
    $r->get('google', 'Auth::google');                  // redirect ke Google
    $r->get('google/callback', 'Auth::googleCallback');
    $r->get('register', 'Auth::register');
    $r->post('register', 'Auth::store');
    $r->get('forgot', 'Auth::forgot');
    $r->post('forgot', 'Auth::sendReset');
    $r->get('reset/(:segment)', 'Auth::reset/$1');
    $r->post('reset', 'Auth::updatePassword');
    $r->get('logout', 'Auth::logout');
});

$routes->group('order', ['filter'=>'auth'], function($r){
    $r->post('quick', 'Order::quick');       // klik Sewa → invoice & riwayat
    $r->get('checkout', 'Order::checkout');  // checkout dari cart
    $r->post('confirm', 'Order::confirm');   // buat invoice dari cart
    $r->get('wa/(:segment)', 'Order::whatsapp/$1'); // redirect WA
    $r->get('riwayat', 'Order::history');
});

$routes->group('admin', ['filter'=>'admin'], function($r){
    $r->get('/', 'Admin\Dashboard::index');

    $r->get('categories', 'Admin\Categories::index');
    $r->post('categories/store', 'Admin\Categories::store');
    $r->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $r->post('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    $r->get('products', 'Admin\Products::index');
    $r->post('products/store', 'Admin\Products::store');
    $r->post('products/update/(:num)', 'Admin\Products::update/$1');
    $r->post('products/delete/(:num)', 'Admin\Products::delete/$1');

    $r->get('banners', 'Admin\Banners::index');
    $r->post('banners/store', 'Admin\Banners::store');
    $r->post('banners/update/(:num)', 'Admin\Banners::update/$1');
    $r->post('banners/delete/(:num)', 'Admin\Banners::delete/$1');

    $r->get('rentals', 'Admin\Rentals::index');          // list & tambah baru (admin)
    $r->post('rentals/create', 'Admin\Rentals::create'); // admin buat invoice untuk user
    $r->post('rentals/confirm/(:num)', 'Admin\Rentals::confirm/$1');
    $r->post('rentals/cancel/(:num)', 'Admin\Rentals::cancel/$1');
    $r->post('rentals/finish/(:num)', 'Admin\Rentals::finish/$1');
    $r->get('rentals/(:num)', 'Admin\Rentals::show/$1');

     $r->get('rentals/new',   'Admin\Rentals::new');   // form lengkap (mirip checkout user)
    $r->post('rentals/store','Admin\Rentals::store');

    $r->get('fifo', 'Admin\Fifo::index');

    $r->post('fines/add/(:num)', 'Admin\Fines::store/$1');

    $r->get('walkins', 'Admin\Walkins::index');
    $r->post('walkins/store', 'Admin\Walkins::store');

    $r->get('reports', 'Admin\Reports::income');
});
