<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk root URL, mengarahkan ke halaman login
$routes->get('/', 'AuthController::login');

// Rute login Myth:Auth (untuk kejelasan)
$routes->get('login', 'AuthController::login');

// Halaman publik (tidak memerlukan login)
$routes->get('/jadwal', 'Jadwal::index');
$routes->get('/jadwal/cetak_pdf', 'Jadwal::cetak_pdf');

// Grup route yang memerlukan login
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('home', 'Home::index');
    // $routes->get('home/user', 'Home::user');
    $routes->get('/logout', 'AuthController::logout');

    $routes->get('category', 'Category::index');
    $routes->get('category/create', 'Category::create');
    $routes->post('category/store', 'Category::store');
    $routes->get('category/edit/(:num)', 'Category::edit/$1');
    $routes->post('category/update/(:num)', 'Category::update/$1');
    $routes->get('category/delete/(:num)', 'Category::delete/$1');

    $routes->get('product', 'Product::index');
    $routes->get('product/create', 'Product::create');
    $routes->post('product/store', 'Product::store');
    $routes->get('product/edit/(:num)', 'Product::edit/$1');
    $routes->post('product/update/(:num)', 'Product::update/$1');
    $routes->get('product/delete/(:num)', 'Product::delete/$1');

    $routes->get('incoming-item', 'IncomingItem::index');
    $routes->get('incoming-item/create', 'IncomingItem::create');
    $routes->post('incoming-item/store', 'IncomingItem::store');
    $routes->get('incoming-item/edit/(:num)', 'IncomingItem::edit/$1');
    $routes->post('incoming-item/update/(:num)', 'IncomingItem::update/$1');
    $routes->get('incoming-item/delete/(:num)', 'IncomingItem::delete/$1');

    $routes->get('/outgoing-item', 'OutgoingItem::index');
    $routes->get('/outgoing-item/create', 'OutgoingItem::create');
    $routes->post('/outgoing-item/store', 'OutgoingItem::store');
    $routes->get('/outgoing-item/edit/(:num)', 'OutgoingItem::edit/$1');
    $routes->post('/outgoing-item/update/(:num)', 'OutgoingItem::update/$1');
    $routes->get('/outgoing-item/delete/(:num)', 'OutgoingItem::delete/$1');

    $routes->group('user', ['filter' => 'login'], static function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('create', 'UserController::create');
        $routes->post('store', 'UserController::store');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update/(:num)', 'UserController::update/$1');
        $routes->get('delete/(:num)', 'UserController::delete/$1');
    });

    $routes->get('report', 'Report::index', ['filter' => 'login']);
    $routes->group('report', ['filter' => 'login'], static function ($routes) {
        $routes->get('incoming', 'Report::incoming');
        $routes->get('outgoing', 'Report::outgoing');
        $routes->get('stock', 'Report::stock');
    });

    $routes->group('purchase', ['filter' => 'restrict'], function ($routes) {
        $routes->get('/', 'Purchase::index');
        $routes->get('create', 'Purchase::create');
        $routes->post('store', 'Purchase::store');
        $routes->get('edit/(:num)', 'Purchase::edit/$1');
        $routes->post('update/(:num)', 'Purchase::update/$1');
        $routes->get('delete/(:num)', 'Purchase::delete/$1');
    });
});