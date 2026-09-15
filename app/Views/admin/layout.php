<?php

use App\Libraries\NotificationService;

$session = session();

$userId = $session->get('id_user') ?? $session->get('user_id');
$adminName = trim((string) ($session->get('nama_lengkap') ?? $session->get('username') ?? 'Admin'));
if ($adminName === '') {
    $adminName = 'Admin';
}

$adminInitial = strtoupper(substr($adminName, 0, 1));

$notifications = [];
$unreadCount = 0;

if ($userId) {
    try {
        $notificationService = new NotificationService();
        $notifications = $notificationService->getForUser((int) $userId, 5);
        $unreadCount = $notificationService->unreadCount((int) $userId);
    } catch (\Throwable $e) {
        $notifications = [];
        $unreadCount = 0;
    }
}

$currentUri = trim(uri_string(), '/');

$dashboardActive = $currentUri === 'admin';
$permohonanActive = $currentUri === 'admin/permohonan' || str_starts_with($currentUri, 'admin/permohonan/');
$laporanActive = $currentUri === 'admin/laporan' || str_starts_with($currentUri, 'admin/laporan/');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $this->renderSection('title') ?: 'JTI Signature - Admin' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        :root {
            --bg: #f4f7fc;
            --surface: #ffffff;
            --surface-soft: #f8faff;
            --navy: #142e52;
            --navy-dark: #0c2240;
            --royal: #2563eb;
            --royal-dark: #1d4ed8;
            --indigo: #4f46e5;
            --text: #172033;
            --muted: #667085;
            --muted-light: #98a2b3;
            --border: #e2e8f0;
            --border-light: #eef2f7;
            --success: #059669;
            --success-bg: #ecfdf5;
            --warning: #d97706;
            --warning-bg: #fffbeb;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --shadow-sm: 0 1px 2px rgba(16, 24, 40, .04);
            --shadow-md: 0 10px 28px rgba(20, 46, 82, .08);
            --sidebar-width: 258px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .admin-shell {
            min-height: 100vh;
            display: flex;
        }

        /* =========================================================
           SIDEBAR
        ========================================================== */
        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background:
                radial-gradient(circle at 95% 6%, rgba(79, 70, 229, .28), transparent 28%),
                linear-gradient(180deg, #142e52 0%, #0e2747 100%);
            color: #dbeafe;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 10px 0 34px rgba(20, 46, 82, .08);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 20px 20px;
            text-decoration: none;
            color: #fff;
        }

        .admin-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, #ffffff 0%, #eaf1ff 100%);
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .03em;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .16);
            flex-shrink: 0;
        }

        .admin-brand-copy {
            min-width: 0;
        }

        .admin-brand-copy h1 {
            font-size: 15px;
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .admin-brand-copy span {
            display: block;
            margin-top: 3px;
            color: #aec7e7;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: .01em;
        }

        .sidebar-section-label {
            padding: 10px 20px 9px;
            color: #87a5ca;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 0 12px;
        }

        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 46px;
            padding: 11px 13px;
            border-radius: 12px;
            text-decoration: none;
            color: #b9cde7;
            font-size: 12.5px;
            font-weight: 600;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .admin-nav-item i {
            width: 18px;
            text-align: center;
            font-size: 15px;
            color: #91acd0;
            transition: color .18s ease;
        }

        .admin-nav-item:hover {
            color: #fff;
            background: rgba(255,255,255,.075);
            transform: translateX(2px);
        }

        .admin-nav-item.active {
            color: #fff;
            background: linear-gradient(135deg, rgba(37, 99, 235, .95), rgba(79, 70, 229, .92));
            box-shadow: 0 10px 24px rgba(37, 99, 235, .22);
        }

        .admin-nav-item.active i {
            color: #fff;
        }

        .sidebar-spacer {
            flex: 1;
        }

        .sidebar-help {
            margin: 12px;
            padding: 14px;
            border: 1px solid rgba(173, 198, 232, .14);
            border-radius: 14px;
            background: rgba(255,255,255,.045);
        }

        .sidebar-help-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-size: 11.5px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .sidebar-help-title i {
            color: #9cc0ff;
        }

        .sidebar-help p {
            color: #a9bed9;
            font-size: 10.5px;
            line-height: 1.5;
        }

        .sidebar-bottom {
            padding: 0 12px 16px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .admin-nav-item.logout:hover {
            background: rgba(220, 38, 38, .14);
            color: #fecaca;
        }

        .admin-nav-item.logout:hover i {
            color: #fca5a5;
        }

        /* =========================================================
           MAIN
        ========================================================== */
        .admin-main {
            width: 100%;
            min-width: 0;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            height: 72px;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: rgba(255,255,255,.88);
            border-bottom: 1px solid rgba(226,232,240,.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .topbar-left {
            min-width: 0;
        }

        .topbar-eyebrow {
            color: var(--muted-light);
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .topbar-title {
            color: var(--navy);
            font-size: 15px;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Notification */
        .notification-wrapper {
            position: relative;
        }

        .topbar-icon-button {
            position: relative;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            background: #fff;
            color: #475467;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .18s ease;
        }

        .topbar-icon-button:hover,
        .topbar-icon-button[aria-expanded="true"] {
            border-color: #cfe0ff;
            color: var(--royal);
            background: #f8fbff;
            box-shadow: 0 4px 12px rgba(37,99,235,.08);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border: 2px solid #fff;
            border-radius: 999px;
            background: #ef4444;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            font-weight: 800;
            line-height: 1;
        }

        .notification-popup {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 372px;
            max-width: calc(100vw - 24px);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 24px 60px rgba(15,23,42,.16);
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity .18s ease, transform .18s ease, visibility .18s ease;
        }

        .notification-popup.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-head {
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px solid var(--border-light);
        }

        .notification-head-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-head h3 {
            color: var(--navy);
            font-size: 13.5px;
            font-weight: 800;
        }

        .notification-count {
            min-width: 21px;
            height: 21px;
            padding: 0 6px;
            border-radius: 999px;
            background: #eaf1ff;
            color: var(--royal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
        }

        .notification-mark-all {
            color: var(--royal);
            text-decoration: none;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        .notification-mark-all:hover {
            color: var(--royal-dark);
            text-decoration: underline;
        }

        .notification-list {
            max-height: 390px;
            overflow-y: auto;
        }

        .notification-list::-webkit-scrollbar {
            width: 5px;
        }

        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            padding: 14px 18px;
            text-decoration: none;
            border-bottom: 1px solid var(--border-light);
            transition: background .15s ease;
        }

        .notification-item:hover {
            background: #f8fbff;
        }

        .notification-item.unread {
            background: #f7fbff;
        }

        .notification-item-icon {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            border-radius: 10px;
            background: #eaf1ff;
            color: var(--royal);
            display: flex;
            align-items: center;
            justify-content: center;
        }

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
            color: var(--text);
            font-size: 11.5px;
            line-height: 1.4;
            font-weight: 800;
        }

        .notification-item-message {
            margin-top: 3px;
            color: var(--muted);
            font-size: 10.5px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-item-time {
            display: block;
            margin-top: 6px;
            color: var(--muted-light);
            font-size: 9.5px;
        }

        .notification-dot {
            width: 7px;
            height: 7px;
            margin-top: 4px;
            border-radius: 50%;
            background: var(--royal);
            flex: 0 0 7px;
        }

        .notification-empty {
            padding: 38px 20px;
            text-align: center;
        }

        .notification-empty-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 11px;
            border-radius: 50%;
            background: #f4f7fc;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .notification-empty h4 {
            color: #344054;
            font-size: 12px;
            font-weight: 800;
        }

        .notification-empty p {
            margin-top: 4px;
            color: var(--muted-light);
            font-size: 10.5px;
        }

        .notification-footer {
            padding: 11px 16px;
            border-top: 1px solid var(--border-light);
        }

        .notification-footer a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 12px;
            border-radius: 10px;
            background: #f6f9ff;
            color: var(--royal);
            text-decoration: none;
            font-size: 10.5px;
            font-weight: 700;
        }

        .notification-footer a:hover {
            background: #edf4ff;
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: var(--border);
            margin: 0 2px;
        }

        .admin-identity {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 2px;
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--royal), var(--indigo));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 6px 14px rgba(37,99,235,.2);
        }

        .admin-identity-text {
            min-width: 0;
        }

        .admin-identity-text strong {
            display: block;
            color: var(--navy);
            font-size: 11.5px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 170px;
        }

        .admin-identity-text span {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 9.5px;
        }

        /* =========================================================
           CONTENT & FOOTER
        ========================================================== */
        .admin-content {
            flex: 1;
            width: 100%;
            padding: 28px 28px 30px;
        }

        .admin-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 16px 28px 20px;
            border-top: 1px solid rgba(226,232,240,.9);
            color: var(--muted-light);
            background: rgba(255,255,255,.56);
            font-size: 9.5px;
            line-height: 1.4;
        }

        .admin-footer strong {
            color: #667085;
            font-weight: 800;
        }

        .footer-links {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-links a {
            color: #7c8799;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--royal);
        }

        /* =========================================================
           MOBILE
        ========================================================== */
        .mobile-sidebar-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--navy);
            border-radius: 11px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .46);
            z-index: 950;
        }

        @media (max-width: 980px) {
            :root {
                --sidebar-width: 238px;
            }

            .admin-topbar,
            .admin-content,
            .admin-footer {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        @media (max-width: 780px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform .22s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-sidebar-overlay-show {
                display: block;
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-sidebar-toggle {
                display: inline-flex;
            }

            .topbar-left {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .topbar-eyebrow {
                display: none;
            }

            .topbar-title {
                font-size: 13.5px;
            }

            .admin-identity-text {
                display: none;
            }

            .topbar-divider {
                display: none;
            }

            .admin-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 560px) {
            .admin-topbar {
                height: 66px;
                padding-left: 14px;
                padding-right: 14px;
            }

            .admin-content {
                padding: 20px 14px 24px;
            }

            .admin-footer {
                padding: 14px;
            }

            .topbar-actions {
                gap: 6px;
            }

            .admin-avatar,
            .topbar-icon-button,
            .mobile-sidebar-toggle {
                width: 37px;
                height: 37px;
                border-radius: 10px;
            }

            .notification-popup {
                position: fixed;
                top: 74px;
                left: 12px;
                right: 12px;
                width: auto;
                max-width: none;
            }
        }
    </style>

    <?= $this->renderSection('head') ?>
</head>

<body>

<div class="admin-shell">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar" id="adminSidebar">

        <a href="<?= site_url('admin') ?>" class="admin-brand">
            <div class="admin-brand-logo">JTI</div>

            <div class="admin-brand-copy">
                <h1>JTI Signature</h1>
                <span>Academic Services</span>
            </div>
        </a>

        <div class="sidebar-section-label">Navigasi</div>

        <nav class="sidebar-nav">

            <a
                href="<?= site_url('admin') ?>"
                class="admin-nav-item <?= $dashboardActive ? 'active' : '' ?>"
            >
                <i class="fa-solid fa-grid-2"></i>
                <span>Dashboard</span>
            </a>

            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="admin-nav-item <?= $permohonanActive ? 'active' : '' ?>"
            >
                <i class="fa-regular fa-file-lines"></i>
                <span>Semua Permohonan</span>
            </a>

            <a
                href="<?= site_url('admin/laporan') ?>"
                class="admin-nav-item <?= $laporanActive ? 'active' : '' ?>"
            >
                <i class="fa-solid fa-chart-column"></i>
                <span>Laporan</span>
            </a>

        </nav>

        <div class="sidebar-spacer"></div>

        <div class="sidebar-help">
            <div class="sidebar-help-title">
                <i class="fa-regular fa-circle-question"></i>
                <span>Pusat Bantuan</span>
            </div>
            <p>Kelola permohonan mahasiswa, periksa bukti pengumpulan, dan perbarui status dengan mudah.</p>
        </div>

        <div class="sidebar-bottom">
            <a href="<?= site_url('logout') ?>" class="admin-nav-item logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Keluar</span>
            </a>
        </div>

    </aside>

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>

    <!-- MAIN -->
    <main class="admin-main">

        <!-- TOPBAR -->
        <header class="admin-topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="mobile-sidebar-toggle"
                    id="mobileSidebarToggle"
                    aria-label="Buka menu"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>
                    <div class="topbar-eyebrow">Panel Administrator</div>
                    <div class="topbar-title">Sistem Tanda Tangan JTI</div>
                </div>

            </div>

            <div class="topbar-actions">

                <!-- NOTIFICATION -->
                <div class="notification-wrapper">

                    <button
                        type="button"
                        class="topbar-icon-button"
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

                    <div class="notification-popup" id="notificationPopup">

                        <div class="notification-head">
                            <div class="notification-head-left">
                                <h3>Notifikasi</h3>

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

                        <div class="notification-list">

                            <?php if (empty($notifications)): ?>

                                <div class="notification-empty">
                                    <div class="notification-empty-icon">
                                        <i class="fa-regular fa-bell"></i>
                                    </div>

                                    <h4>Belum ada notifikasi</h4>
                                    <p>Notifikasi baru akan muncul di sini.</p>
                                </div>

                            <?php else: ?>

                                <?php foreach ($notifications as $notification): ?>

                                    <a
                                        href="<?= site_url('notifications/read/' . $notification['id_notifikasi']) ?>"
                                        class="notification-item <?= (int) ($notification['dibaca'] ?? 1) === 0 ? 'unread' : '' ?>"
                                    >

                                        <div class="notification-item-icon">
                                            <i class="fa-regular fa-bell"></i>
                                        </div>

                                        <div class="notification-item-content">

                                            <div class="notification-item-top">
                                                <h4 class="notification-item-title">
                                                    <?= esc($notification['judul'] ?? 'Notifikasi') ?>
                                                </h4>

                                                <?php if ((int) ($notification['dibaca'] ?? 1) === 0): ?>
                                                    <span class="notification-dot"></span>
                                                <?php endif; ?>
                                            </div>

                                            <p class="notification-item-message">
                                                <?= esc($notification['pesan'] ?? '') ?>
                                            </p>

                                            <span class="notification-item-time">
                                                <?= esc($notification['created_at'] ?? '') ?>
                                            </span>

                                        </div>

                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                        <div class="notification-footer">
                            <a href="<?= site_url('notifications') ?>">
                                Lihat semua notifikasi
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="topbar-divider"></div>

                <!-- ADMIN IDENTITY -->
                <div class="admin-identity">

                    <div class="admin-avatar">
                        <?= esc($adminInitial) ?>
                    </div>

                    <div class="admin-identity-text">
                        <strong><?= esc($adminName) ?></strong>
                        <span>Administrator</span>
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
                © <?= date('Y') ?> Jurusan Teknologi Informasi.
            </div>

            <div class="footer-links">
                <a href="#">Privasi</a>
                <a href="#">Ketentuan</a>
                <a href="#">Peta Kampus</a>
            </div>
        </footer>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const notificationButton = document.getElementById('notificationButton');
    const notificationPopup = document.getElementById('notificationPopup');

    if (notificationButton && notificationPopup) {

        notificationButton.addEventListener('click', function (event) {
            event.stopPropagation();

            const isOpen = notificationPopup.classList.contains('show');

            notificationPopup.classList.toggle('show', !isOpen);
            notificationButton.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
        });

        document.addEventListener('click', function (event) {
            if (
                !notificationPopup.contains(event.target) &&
                !notificationButton.contains(event.target)
            ) {
                notificationPopup.classList.remove('show');
                notificationButton.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                notificationPopup.classList.remove('show');
                notificationButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('mobileSidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('open');
        }

        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('admin-sidebar-overlay-show');
        }
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');

            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle(
                    'admin-sidebar-overlay-show',
                    sidebar.classList.contains('open')
                );
            }
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    document.querySelectorAll('.admin-nav-item').forEach(function (item) {
        item.addEventListener('click', function () {
            if (window.innerWidth <= 780) {
                closeSidebar();
            }
        });
    });

});
</script>

<?= $this->renderSection('scripts') ?>

</body>
</html>
