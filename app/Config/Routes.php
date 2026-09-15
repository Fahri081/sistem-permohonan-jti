<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Tampilkan halaman login
$routes->get(
    'login',
    'Auth::login'
);

// Proses login
$routes->post(
    'login',
    'Auth::attempt'
);

// Logout
$routes->get(
    'logout',
    'Auth::logout'
);


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
|
| Setelah login, Auth akan mengarahkan user
| ke dashboard berdasarkan role masing-masing.
|
*/

$routes->get(
    '/',
    'Auth::login'
);


/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

$routes->group(
    'mahasiswa',
    ['filter' => 'role:mahasiswa'],
    static function (RouteCollection $routes) {

        // Dashboard Mahasiswa
        $routes->get(
            '/',
            'Mahasiswa::index'
        );

        // Permohonan Saya
        $routes->get(
            'permohonan',
            'Mahasiswa::permohonan'
        );

        // Form Ajukan Permohonan Baru
        $routes->get(
            'permohonan/create',
            'Mahasiswa::create'
        );

        // Simpan Permohonan Baru
        $routes->post(
            'permohonan',
            'Mahasiswa::store'
        );

        // Detail Permohonan
        $routes->get(
            'permohonan/(:num)',
            'Mahasiswa::show/$1'
        );

        // Ubah / Perbaiki Bukti Fisik
        $routes->post(
            'permohonan/(:num)/bukti-fisik',
            'Mahasiswa::updateBuktiFisik/$1'
        );

        // Ajukan ulang permohonan yang ditolak
        $routes->post(
            'permohonan/(:num)/reupload',
            'Mahasiswa::reupload/$1'
        );

        // Profil Mahasiswa
        $routes->get(
            'profil',
            'Mahasiswa::profil'
        );

        // Update Profil Mahasiswa
        $routes->post(
            'profil',
            'Mahasiswa::updateProfil'
        );
    }
);


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

$routes->group(
    'admin',
    ['filter' => 'role:admin'],
    static function (RouteCollection $routes) {

        // Dashboard Admin
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

        // Update Status Permohonan
        $routes->post(
            'permohonan/(:num)/status',
            'Admin::updateStatus/$1'
        );

        // Tandai Permohonan Sudah Diambil
        $routes->post(
            'permohonan/(:num)/pickup',
            'Admin::markPickedUp/$1'
        );

        // Laporan
        $routes->get(
            'laporan',
            'Admin::laporan'
        );
    }
);


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/

// Daftar notifikasi
$routes->get(
    'notifications',
    'Notification::index'
);

// Tandai satu notifikasi sudah dibaca
$routes->get(
    'notifications/read/(:num)',
    'Notification::read/$1'
);

// Tandai semua notifikasi sudah dibaca
$routes->get(
    'notifications/read-all',
    'Notification::readAll'
);