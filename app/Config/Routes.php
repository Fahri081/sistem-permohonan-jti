<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

$routes->group('mahasiswa', ['filter' => 'role:mahasiswa'], static function (RouteCollection $routes) {
    $routes->get('/', 'Mahasiswa::index');
    $routes->get('permohonan/create', 'Mahasiswa::create');
    $routes->post('permohonan', 'Mahasiswa::store');
});

$routes->group('admin', ['filter' => 'role:admin'], static function (RouteCollection $routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('permohonan/(:num)', 'Admin::show/$1');
    $routes->post('permohonan/(:num)/status', 'Admin::updateStatus/$1');
    $routes->post('berkas/(:num)/status', 'Admin::updateBerkasStatus/$1');
    $routes->post('permohonan/(:num)/ambil', 'Admin::markPickedUp/$1');
});

$routes->setAutoRoute(false);
