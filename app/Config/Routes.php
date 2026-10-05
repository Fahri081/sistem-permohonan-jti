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

// Tampilkan halaman register lokal
$routes->get(
    'register',
    'Auth::register'
);

// Proses register lokal
$routes->post(
    'register',
    'Auth::processRegister'
);

// Form melengkapi register Google
$routes->get(
    'register/google',
    'Auth::googleRegister'
);

// Proses melengkapi register Google
$routes->post(
    'register/google',
    'Auth::processGoogleRegister'
);

// Logout
$routes->get(
    'logout',
    'Auth::logout'
);

// Login / register dengan akun Google / Polinema
$routes->get(
    'login/google',
    'Auth::google'
);

$routes->get(
    'auth/google/callback',
    'Auth::googleCallback'
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

        // Konfirmasi pengambilan + upload bukti pengambilan
        $routes->post(
            'permohonan/(:num)/pengambilan',
            'Mahasiswa::submitBuktiPengambilan/$1'
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

        // Update Foto Profil Mahasiswa
        $routes->post(
            'profil/foto',
            'Mahasiswa::updateFotoProfil'
        );

        // Pengaturan Akun
        $routes->get(
            'pengaturan',
            'Mahasiswa::pengaturan'
        );

        // Update Password
        $routes->post(
            'pengaturan/password',
            'Mahasiswa::updatePassword'
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
    ['filter' => 'role:admin,super_admin'],
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

        // Verifikasi bukti pengambilan mahasiswa
        $routes->post(
            'permohonan/(:num)/verifikasi-pengambilan',
            'Admin::verifikasiPengambilan/$1'
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
