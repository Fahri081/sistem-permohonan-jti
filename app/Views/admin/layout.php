<?php

use App\Libraries\NotificationService;

$session = session();

/*
|--------------------------------------------------------------------------
| Ambil ID user yang sedang login
|--------------------------------------------------------------------------
*/
$userId = $session->get('id_user') ?? $session->get('user_id');

/*
|--------------------------------------------------------------------------
| Data notifikasi admin
|--------------------------------------------------------------------------
*/
$notifications = [];
$unreadCount = 0;

if ($userId) {
    $notificationService = new NotificationService();

    $notifications = $notificationService->getForUser(
        (int) $userId,
        5
    );

    $unreadCount = $notificationService->unreadCount(
        (int) $userId
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= $this->renderSection('title') ?: 'JTI Signature - Admin' ?>
    </title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <!-- Admin CSS -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/admin/dashboard.css') ?>"
    >

    <!-- =====================================================
         NOTIFICATION POPUP STYLE
    ====================================================== -->

    <style>

        /* ==============================
           TOPBAR ACTIONS
        =============================== */

        .topbar-actions {
            position: relative;
        }


        /* ==============================
           NOTIFICATION WRAPPER
        =============================== */

        .notification-wrapper {
            position: relative;
        }


        /* ==============================
           NOTIFICATION BUTTON
        =============================== */

        .topbar-icon {
            position: relative;

            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: none;
            background: transparent;

            border-radius: 10px;

            cursor: pointer;

            color: #475569;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }


        .topbar-icon:hover {
            background: #f1f5f9;
            color: #2563eb;
        }


        .topbar-icon i {
            font-size: 19px;
        }


        /* ==============================
           BADGE JUMLAH NOTIFIKASI
        =============================== */

        .notification-badge {
            position: absolute;

            top: 4px;
            right: 3px;

            min-width: 18px;
            height: 18px;

            padding: 0 5px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ef4444;
            color: #ffffff;

            border: 2px solid #ffffff;
            border-radius: 999px;

            font-size: 10px;
            font-weight: 700;

            line-height: 1;
        }


        /* ==============================
           POPUP CONTAINER
        =============================== */

        .notification-popup {
            position: absolute;

            top: calc(100% + 12px);
            right: 0;

            width: 370px;

            background: #ffffff;

            border: 1px solid #e2e8f0;
            border-radius: 16px;

            box-shadow:
                0 20px 40px rgba(15, 23, 42, 0.12),
                0 4px 12px rgba(15, 23, 42, 0.06);

            overflow: hidden;

            z-index: 9999;

            opacity: 0;
            visibility: hidden;

            transform: translateY(-8px);

            transition:
                opacity 0.2s ease,
                transform 0.2s ease,
                visibility 0.2s ease;
        }


        .notification-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }


        /* ==============================
           POPUP HEADER
        =============================== */

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 18px 18px 14px;

            border-bottom: 1px solid #f1f5f9;
        }


        .notification-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }


        .notification-header-left h3 {
            margin: 0;

            font-size: 16px;
            font-weight: 700;

            color: #0f172a;
        }


        .notification-count {
            min-width: 22px;
            height: 22px;

            padding: 0 7px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;
            color: #2563eb;

            border-radius: 999px;

            font-size: 11px;
            font-weight: 700;
        }


        .notification-mark-all {
            border: none;
            background: transparent;

            padding: 5px 0;

            color: #2563eb;

            font-size: 12px;
            font-weight: 600;

            cursor: pointer;

            text-decoration: none;
        }


        .notification-mark-all:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }


        /* ==============================
           NOTIFICATION LIST
        =============================== */

        .notification-list {
            max-height: 390px;
            overflow-y: auto;
        }


        .notification-list::-webkit-scrollbar {
            width: 5px;
        }


        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }


        /* ==============================
           SINGLE NOTIFICATION
        =============================== */

        .notification-item {
            display: flex;
            gap: 12px;

            padding: 15px 18px;

            text-decoration: none;

            border-bottom: 1px solid #f1f5f9;

            transition:
                background 0.2s ease;
        }


        .notification-item:hover {
            background: #f8fafc;
        }


        .notification-item.unread {
            background: #f8fbff;
        }


        /* ==============================
           ICON NOTIFIKASI
        =============================== */

        .notification-item-icon {
            flex: 0 0 auto;

            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eff6ff;
            color: #2563eb;
        }


        .notification-item-icon i {
            font-size: 15px;
        }


        /* ==============================
           CONTENT
        =============================== */

        .notification-item-content {
            min-width: 0;
            flex: 1;
        }


        .notification-item-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }


        .notification-item-title {
            margin: 0;

            font-size: 13px;
            font-weight: 700;

            color: #0f172a;

            line-height: 1.4;
        }


        .notification-item-message {
            margin: 4px 0 7px;

            font-size: 12px;
            line-height: 1.5;

            color: #64748b;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;

            overflow: hidden;
        }


        .notification-item-time {
            font-size: 10px;
            color: #94a3b8;
        }


        /* ==============================
           DOT NOTIFIKASI BARU
        =============================== */

        .notification-item-dot {
            flex: 0 0 auto;

            width: 7px;
            height: 7px;

            margin-top: 5px;

            background: #2563eb;

            border-radius: 50%;
        }


        /* ==============================
           EMPTY STATE
        =============================== */

        .notification-empty {
            padding: 40px 20px;

            text-align: center;
        }


        .notification-empty-icon {
            width: 58px;
            height: 58px;

            margin: 0 auto 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f8fafc;

            border-radius: 50%;

            color: #94a3b8;
        }


        .notification-empty-icon i {
            font-size: 22px;
        }


        .notification-empty h4 {
            margin: 0 0 5px;

            color: #334155;

            font-size: 14px;
        }


        .notification-empty p {
            margin: 0;

            color: #94a3b8;

            font-size: 12px;
        }


        /* ==============================
           POPUP FOOTER
        =============================== */

        .notification-footer {
            padding: 12px 18px;

            border-top: 1px solid #f1f5f9;

            text-align: center;
        }


        .notification-footer a {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 100%;

            padding: 9px 12px;

            border-radius: 9px;

            background: #f8fafc;

            color: #2563eb;

            font-size: 12px;
            font-weight: 600;

            text-decoration: none;

            transition:
                background 0.2s ease,
                color 0.2s ease;
        }


        .notification-footer a:hover {
            background: #eff6ff;
            color: #1d4ed8;
        }


        .notification-footer i {
            margin-left: 7px;
            font-size: 11px;
        }


        /* ==============================
           RESPONSIVE
        =============================== */

        @media (max-width: 600px) {

            .notification-popup {
                position: fixed;

                top: 72px;
                left: 12px;
                right: 12px;

                width: auto;
            }

        }

    </style>

</head>


<body>

<div class="admin-layout">

    <!-- =====================================
         SIDEBAR
    ====================================== -->

    <aside class="sidebar">

        <div class="sidebar-brand">

            <div class="sidebar-logo">
                <span>JTI</span>
            </div>

            <div class="sidebar-brand-text">

                <h2>JTI Signature</h2>

                <span>Academic Services</span>

            </div>

        </div>


        <!-- NAVIGATION -->

        <nav class="sidebar-nav">

            <a
                href="<?= site_url('admin') ?>"
                class="nav-item <?= uri_string() === 'admin' ? 'active' : '' ?>"
            >

                <i class="fa-solid fa-table-cells-large"></i>

                <span>Dashboard</span>

            </a>


            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="nav-item <?= str_starts_with(uri_string(), 'admin/permohonan') ? 'active' : '' ?>"
            >

                <i class="fa-regular fa-file-lines"></i>

                <span>Semua Permohonan</span>

            </a>


            <a
                href="<?= site_url('admin/laporan') ?>"
                class="nav-item <?= str_starts_with(uri_string(), 'admin/laporan') ? 'active' : '' ?>"
            >

                <i class="fa-solid fa-chart-column"></i>

                <span>Laporan</span>

            </a>

        </nav>


        <!-- SIDEBAR BOTTOM -->

        <div class="sidebar-bottom">

            <a
                href="#"
                class="nav-item"
            >

                <i class="fa-regular fa-circle-question"></i>

                <span>Pusat Bantuan</span>

            </a>


            <a
                href="<?= site_url('logout') ?>"
                class="nav-item logout"
            >

                <i class="fa-solid fa-arrow-right-from-bracket"></i>

                <span>Keluar</span>

            </a>

        </div>

    </aside>


    <!-- =====================================
         MAIN
    ====================================== -->

    <main class="admin-main">

        <!-- TOP BAR -->

        <header class="topbar">

            <div class="topbar-title">

                <span>
                    Sistem Tanda Tangan JTI
                </span>

            </div>


            <div class="topbar-actions">

                <!-- =====================================
                     NOTIFICATION
                ====================================== -->

                <div class="notification-wrapper">

                    <button
                        type="button"
                        class="topbar-icon"
                        id="notificationButton"
                        aria-label="Notifikasi"
                        aria-expanded="false"
                    >

                        <i class="fa-regular fa-bell"></i>


                        <?php if ($unreadCount > 0): ?>

                            <span class="notification-badge">
                                <?= $unreadCount > 99 ? '99+' : $unreadCount ?>
                            </span>

                        <?php endif; ?>

                    </button>


                    <!-- NOTIFICATION POPUP -->

                    <div
                        class="notification-popup"
                        id="notificationPopup"
                    >

                        <!-- HEADER -->

                        <div class="notification-header">

                            <div class="notification-header-left">

                                <h3>
                                    Notifikasi
                                </h3>

                                <?php if ($unreadCount > 0): ?>

                                    <span class="notification-count">
                                        <?= $unreadCount ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <?php if ($unreadCount > 0): ?>

                                <a
                                    href="<?= site_url('notifications/read-all') ?>"
                                    class="notification-mark-all"
                                >
                                    Tandai semua dibaca
                                </a>

                            <?php endif; ?>

                        </div>


                        <!-- LIST -->

                        <div class="notification-list">

                            <?php if (empty($notifications)): ?>

                                <div class="notification-empty">

                                    <div class="notification-empty-icon">
                                        <i class="fa-regular fa-bell"></i>
                                    </div>

                                    <h4>
                                        Belum ada notifikasi
                                    </h4>

                                    <p>
                                        Notifikasi baru akan muncul di sini.
                                    </p>

                                </div>

                            <?php else: ?>

                                <?php foreach ($notifications as $notification): ?>

                                    <a
                                        href="<?= site_url(
                                            'notifications/read/' .
                                            $notification['id_notifikasi']
                                        ) ?>"
                                        class="notification-item <?= (int) $notification['dibaca'] === 0 ? 'unread' : '' ?>"
                                    >

                                        <div class="notification-item-icon">

                                            <i class="fa-regular fa-bell"></i>

                                        </div>


                                        <div class="notification-item-content">

                                            <div class="notification-item-top">

                                                <h4 class="notification-item-title">
                                                    <?= esc($notification['judul']) ?>
                                                </h4>


                                                <?php if ((int) $notification['dibaca'] === 0): ?>

                                                    <span class="notification-item-dot"></span>

                                                <?php endif; ?>

                                            </div>


                                            <p class="notification-item-message">

                                                <?= esc($notification['pesan']) ?>

                                            </p>


                                            <span class="notification-item-time">

                                                <?= esc($notification['created_at']) ?>

                                            </span>

                                        </div>

                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>


                        <!-- FOOTER -->

                        <div class="notification-footer">

                            <a href="<?= site_url('notifications') ?>">

                                Lihat semua notifikasi

                                <i class="fa-solid fa-arrow-right"></i>

                            </a>

                        </div>

                    </div>

                </div>


                <div class="topbar-divider"></div>


                <!-- ADMIN PROFILE -->

                <div class="admin-profile">

                    <div class="profile-avatar">
                        A
                    </div>

                    <div class="profile-info">

                        <strong>
                            Admin
                        </strong>

                        <span>
                            Administrator
                        </span>

                    </div>

                </div>

            </div>

        </header>


        <!-- PAGE CONTENT -->

        <div class="admin-content">

            <?= $this->renderSection('content') ?>

        </div>


        <!-- FOOTER -->

        <footer class="admin-footer">

            <div>
                <strong>JTI Signature</strong>
            </div>

            <div>
                © 2024 Jurusan Teknologi Informasi.
                Hak Cipta Dilindungi Undang-Undang.
            </div>

            <div class="footer-links">

                <a href="#">Kebijakan Privasi</a>

                <a href="#">Syarat dan Ketentuan</a>

                <a href="#">Peta Kampus</a>

            </div>

        </footer>

    </main>

</div>


<!-- =====================================
     NOTIFICATION JAVASCRIPT
====================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('notificationButton');
    const popup = document.getElementById('notificationPopup');

    if (!button || !popup) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Toggle popup ketika lonceng diklik
    |--------------------------------------------------------------------------
    */

    button.addEventListener('click', function (event) {

        event.stopPropagation();

        const isOpen = popup.classList.contains('show');

        if (isOpen) {

            popup.classList.remove('show');

            button.setAttribute(
                'aria-expanded',
                'false'
            );

        } else {

            popup.classList.add('show');

            button.setAttribute(
                'aria-expanded',
                'true'
            );
        }
    });


    /*
    |--------------------------------------------------------------------------
    | Klik di luar popup → tutup
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (
            !popup.contains(event.target) &&
            !button.contains(event.target)
        ) {

            popup.classList.remove('show');

            button.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Escape → tutup popup
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            popup.classList.remove('show');

            button.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });

});

</script>

</body>

</html>