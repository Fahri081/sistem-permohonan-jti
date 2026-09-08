<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

$routes->get('/', 'Home::index');


// ==========================================
// AUTH
// ==========================================

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');


// ==========================================
// MAHASISWA
// ==========================================

$routes->group(
    'mahasiswa',
    [
        'filter' => 'role:mahasiswa'
    ],
    static function (RouteCollection $routes) {

        $routes->get(
            '/',
            'Mahasiswa::index'
        );

        $routes->get(
            'permohonan/create',
            'Mahasiswa::create'
        );

        $routes->post(
            'permohonan',
            'Mahasiswa::store'
        );
    }
);


// ==========================================
// ADMIN
// ==========================================

$routes->group(
    'admin',
    [
        'filter' => 'role:admin'
    ],
    static function (RouteCollection $routes) {

        // Dashboard
        $routes->get(
            '/',
            'Admin::index'
        );


        // Semua Permohonan
        $routes->get(
            'permohonan',
            'Admin::all'
        );


        // Detail Permohonan
        $routes->get(
            'permohonan/(:num)',
            'Admin::show/$1'
        );


        // Update status permohonan
        $routes->post(
            'permohonan/(:num)/status',
            'Admin::updateStatus/$1'
        );


        // Update status berkas
        $routes->post(
            'berkas/(:num)/status',
            'Admin::updateBerkasStatus/$1'
        );


        // Tandai sudah diambil
        $routes->post(
            'permohonan/(:num)/ambil',
            'Admin::markPickedUp/$1'
        );
    }
);


$routes->setAutoRoute(false);