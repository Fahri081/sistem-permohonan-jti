<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Home::index');

/*
 * --------------------------------------------------------------------
 * Authentication
 * --------------------------------------------------------------------
 */

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

/*
 * --------------------------------------------------------------------
 * Mahasiswa
 * --------------------------------------------------------------------
 */

$routes->group(
    'mahasiswa',
    ['filter' => 'role:mahasiswa'],
    static function (RouteCollection $routes) {

        // Dashboard mahasiswa
        $routes->get('/', 'Mahasiswa::index');

        // Form ajukan permohonan
        $routes->get('permohonan/create', 'Mahasiswa::create');

        // Simpan permohonan
        $routes->post('permohonan', 'Mahasiswa::store');
    }
);

/*
 * --------------------------------------------------------------------
 * Admin
 * --------------------------------------------------------------------
 */

$routes->group(
    'admin',
    ['filter' => 'role:admin'],
    static function (RouteCollection $routes) {

        // Dashboard admin
        $routes->get('/', 'Admin::index');

        // Semua permohonan
        $routes->get('permohonan', 'Admin::all');

        // Detail permohonan
        $routes->get('permohonan/(:num)', 'Admin::show/$1');

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

        // Tandai permohonan sudah diambil
        $routes->post(
            'permohonan/(:num)/ambil',
            'Admin::markPickedUp/$1'
        );

        // Laporan dan statistik
        $routes->get('laporan', 'Admin::laporan');
    }
);

/*
 * --------------------------------------------------------------------
 * Notifications
 * --------------------------------------------------------------------
 */

$routes->get('notifications', 'Notification::index');

$routes->get(
    'notifications/read/(:num)',
    'Notification::read/$1'
);

$routes->get(
    'notifications/read-all',
    'Notification::readAll'
);

/*
 * --------------------------------------------------------------------
 * Auto Routing
 * --------------------------------------------------------------------
 */

// Jangan aktifkan Auto Routing
$routes->setAutoRoute(false);