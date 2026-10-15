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
$routes->post(
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

        // Foto bukti privat: hanya pemilik permohonan yang dapat melihat.
        $routes->get(
            'permohonan/(:num)/bukti-fisik/(:segment)',
            'PrivateEvidence::mahasiswaBuktiFisik/$1/$2'
        );

        $routes->get(
            'permohonan/(:num)/bukti-pengambilan/(:segment)',
            'PrivateEvidence::mahasiswaBuktiPengambilan/$1/$2'
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

        // Foto bukti privat: admin dan super admin yang lolos filter role.
        $routes->get(
            'permohonan/(:num)/bukti-fisik/(:segment)',
            'PrivateEvidence::adminBuktiFisik/$1/$2'
        );

        $routes->get(
            'permohonan/(:num)/bukti-pengambilan/(:segment)',
            'PrivateEvidence::adminBuktiPengambilan/$1/$2'
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

        // Laporan
        $routes->get(
            'laporan',
            'Admin::laporan'
        );

        /*
         * =====================================================
         * MANAGE USER - KHUSUS SUPER ADMIN
         * =====================================================
         */
        $routes->get(
            'users',
            'Admin::users',
            ['filter' => 'role:super_admin']
        );

        $routes->get(
            'users/(:num)',
            'Admin::userDetail/$1',
            ['filter' => 'role:super_admin']
        );

        $routes->get(
            'users/(:num)/edit',
            'Admin::editUser/$1',
            ['filter' => 'role:super_admin']
        );

        $routes->post(
            'users/(:num)/update',
            'Admin::updateUser/$1',
            ['filter' => 'role:super_admin']
        );

        $routes->post(
            'users/(:num)/delete',
            'Admin::deleteUser/$1',
            ['filter' => 'role:super_admin']
        );
    }
);


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/

// Daftar notifikasi — hanya pengguna aktif yang sudah login
$routes->get(
    'notifications',
    'Notification::index',
    ['filter' => 'role:mahasiswa,admin,super_admin']
);

// Tandai satu notifikasi sudah dibaca (POST + CSRF)
$routes->post(
    'notifications/read/(:num)',
    'Notification::read/$1',
    ['filter' => 'role:mahasiswa,admin,super_admin']
);

// Tandai semua notifikasi sudah dibaca (POST + CSRF)
$routes->post(
    'notifications/read-all',
    'Notification::readAll',
    ['filter' => 'role:mahasiswa,admin,super_admin']
);
