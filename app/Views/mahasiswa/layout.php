<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Tanda Tangan JTI') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --bg: #f4f7fc;
            --surface: #ffffff;
            --surface-soft: #f8faff;

            --navy: #142e52;
            --navy-deep: #0d2038;

            --blue: #2563eb;
            --blue-dark: #1d4ed8;
            --blue-soft: #eaf1ff;

            --indigo: #4f46e5;
            --indigo-soft: #eeecff;

            --success: #059669;
            --success-soft: #e8f8f2;

            --warning: #d97706;
            --warning-soft: #fff4df;

            --danger: #dc2626;
            --danger-soft: #ffebeb;

            --text: #172033;
            --muted: #667085;
            --faint: #98a2b3;

            --border: #e2e8f0;
            --border-soft: #edf1f6;

            --shadow-sm: 0 4px 16px rgba(20, 46, 82, .055);
            --shadow-md: 0 14px 32px rgba(20, 46, 82, .09);

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 18px;

            --sidebar-width: 264px;
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
            background:
                radial-gradient(circle at 92% 0%, rgba(37,99,235,.065), transparent 28%),
                var(--bg);
            color: var(--text);
            font-family: "Plus Jakarta Sans", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
        }

        button,
        input,
        textarea,
        select {
            font: inherit;
        }

        button {
            -webkit-tap-highlight-color: transparent;
        }

        /* =========================
           APP SHELL
        ========================== */
        .app {
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================== */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;

            width: var(--sidebar-width);
            min-height: 100vh;

            display: flex;
            flex-direction: column;

            overflow-y: auto;

            background:
                radial-gradient(circle at 0% 0%, rgba(79,70,229,.18), transparent 28%),
                linear-gradient(180deg, #142f55 0%, #112844 58%, #0d2038 100%);

            color: #dbe8f8;
            box-shadow: 10px 0 30px rgba(15,34,60,.10);

            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.18) transparent;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 24px 22px;

            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .brand-mark {
            width: 43px;
            height: 43px;
            flex: 0 0 43px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;
            background: #fff;
            color: var(--navy);

            font-size: 14px;
            font-weight: 800;

            box-shadow: 0 8px 20px rgba(0,0,0,.14);
        }

        .brand-copy {
            min-width: 0;
        }

        .brand-title {
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.25px;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: #a9bed8;
            font-size: 10.5px;
            font-weight: 500;
        }

        .nav-section {
            padding: 18px 22px 8px;
            color: #7892b0;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            padding: 0 12px;
        }

        .nav-item {
            min-height: 46px;

            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 5px;
            padding: 0 13px;

            border-radius: 12px;

            color: #a9bed8;
            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            transition:
                background .18s ease,
                color .18s ease,
                transform .18s ease;
        }

        .nav-item:hover {
            color: #fff;
            background: rgba(255,255,255,.075);
            transform: translateX(2px);
        }

        .nav-item.active {
            color: #fff;
            background:
                linear-gradient(135deg, rgba(37,99,235,.96), rgba(79,70,229,.94));
            box-shadow: 0 8px 20px rgba(22,69,157,.26);
        }

        .nav-icon {
            width: 19px;
            height: 19px;
            flex: 0 0 19px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-spacer {
            flex: 1;
        }

        .sidebar-bottom {
            padding: 13px 12px 16px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .logout:hover {
            color: #ffd6d6;
            background: rgba(220,38,38,.12);
        }

        /* =========================
           MAIN
        ========================== */
        .main {
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            margin-left: var(--sidebar-width);

            display: flex;
            flex-direction: column;
        }

        /* =========================
           TOPBAR
        ========================== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;

            height: 76px;
            padding: 0 34px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;

            background: rgba(244,247,252,.88);
            border-bottom: 1px solid rgba(226,232,240,.82);
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .context {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .context-label {
            color: var(--faint);
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .context-title {
            color: var(--text);
            font-size: 14px;
            font-weight: 800;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            position: relative;

            width: 42px;
            height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);
            border-radius: 12px;
            background: rgba(255,255,255,.92);
            color: #5c6b80;

            cursor: pointer;

            box-shadow: 0 2px 8px rgba(20,46,82,.035);

            transition: .18s ease;
        }

        .icon-btn:hover {
            color: var(--blue);
            border-color: #bfd1f2;
            background: #fff;
            transform: translateY(-1px);
        }

        .notif-badge {
            position: absolute;
            top: 5px;
            right: 5px;

            min-width: 17px;
            height: 17px;
            padding: 0 4px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 999px;
            border: 2px solid var(--bg);

            background: var(--danger);
            color: #fff;

            font-size: 8.5px;
            font-weight: 800;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 5px 8px 5px 5px;
            border-radius: 13px;

            text-decoration: none;

            transition: background .18s ease;
        }

        .profile:hover {
            background: #fff;
        }

        .avatar {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(135deg, #2563eb, #4f46e5);

            color: #fff;
            font-size: 12px;
            font-weight: 800;

            box-shadow: 0 7px 17px rgba(37,99,235,.18);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .profile-name {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            color: var(--text);
            font-size: 12.5px;
            font-weight: 800;
        }

        .profile-role {
            color: var(--faint);
            font-size: 10px;
            font-weight: 500;
        }

        /* =========================
           NOTIFICATION
        ========================== */
        .notification-wrap {
            position: relative;
        }

        .notification-panel {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;

            width: 370px;

            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-7px);

            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;

            box-shadow: 0 20px 48px rgba(20,46,82,.14);

            transition:
                opacity .18s ease,
                transform .18s ease,
                visibility .18s ease;
        }

        .notification-panel.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-head {
            padding: 17px 18px 14px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            border-bottom: 1px solid var(--border-soft);
        }

        .notification-head-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-head h3 {
            color: var(--text);
            font-size: 14px;
            font-weight: 800;
        }

        .count-pill {
            min-width: 22px;
            height: 22px;
            padding: 0 7px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 999px;
            background: var(--blue-soft);
            color: var(--blue-dark);

            font-size: 10px;
            font-weight: 800;
        }

        .mark-all {
            color: var(--blue);
            font-size: 10.5px;
            font-weight: 700;
            text-decoration: none;
        }

        .mark-all:hover {
            text-decoration: underline;
        }

        .notification-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 11px;

            padding: 14px 18px;

            border-bottom: 1px solid var(--border-soft);
            text-decoration: none;

            transition: background .18s ease;
        }

        .notification-item:hover {
            background: #f8fbff;
        }

        .notification-item.unread {
            background: #f5f9ff;
        }

        .notification-icon {
            width: 35px;
            height: 35px;
            flex: 0 0 35px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;
            background: var(--blue-soft);
            color: var(--blue);
        }

        .notification-body {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            color: var(--text);
            font-size: 11.5px;
            font-weight: 800;
            line-height: 1.35;
        }

        .notification-message {
            margin-top: 4px;

            color: var(--muted);
            font-size: 10.5px;
            line-height: 1.5;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            display: block;
            margin-top: 5px;
            color: var(--faint);
            font-size: 9.5px;
        }

        .new-dot {
            width: 7px;
            height: 7px;
            margin-top: 4px;
            flex: 0 0 7px;

            border-radius: 50%;
            background: var(--blue);
        }

        .notification-empty {
            padding: 38px 18px;
            text-align: center;
        }

        .notification-empty-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            background: #f4f6fa;
            color: var(--faint);
        }

        .notification-empty h4 {
            color: #475467;
            font-size: 12px;
            font-weight: 800;
        }

        .notification-empty p {
            margin-top: 4px;
            color: var(--faint);
            font-size: 10.5px;
        }

        .notification-footer {
            padding: 11px 14px;
            background: #fbfcfe;
            border-top: 1px solid var(--border-soft);
        }

        .notification-footer a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            padding: 9px;

            border-radius: 9px;
            background: #f1f5ff;
            color: var(--blue-dark);

            font-size: 10.5px;
            font-weight: 800;
            text-decoration: none;
        }

        .notification-footer a:hover {
            background: #e7eeff;
        }

        /* =========================
           CONTENT
        ========================== */
        .content {
            width: 100%;
            max-width: 1480px;
            margin: 0 auto;

            flex: 1;

            padding: 30px 34px 40px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;

            margin-bottom: 20px;
            padding: 13px 15px;

            border-radius: 12px;
            border: 1px solid transparent;

            font-size: 12px;
            line-height: 1.5;
        }

        .alert-success {
            color: #087153;
            background: var(--success-soft);
            border-color: #b9ead7;
        }

        .alert-error {
            color: #b42318;
            background: var(--danger-soft);
            border-color: #f4c7c7;
        }

        /* =========================
           GENERIC VISUAL LANGUAGE
           ========================== */
        .content .card,
        .content .detail-card,
        .content .form-card,
        .content .stat-card,
        .content .request-card,
        .content .table-card,
        .content .activity-card,
        .content .profile-card,
        .content .bukti-fisik-card,
        .content .status-card {
            border-color: var(--border) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: var(--shadow-sm) !important;
        }

        .content .card:hover,
        .content .detail-card:hover,
        .content .form-card:hover,
        .content .stat-card:hover,
        .content .request-card:hover,
        .content .activity-card:hover {
            box-shadow: var(--shadow-md) !important;
        }

        /* Buttons from child views */
        .content button,
        .content .btn {
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease,
                border-color .18s ease !important;
        }

        .content input,
        .content textarea,
        .content select {
            border-color: var(--border) !important;
            border-radius: 11px !important;
        }

        .content input:focus,
        .content textarea:focus,
        .content select:focus {
            outline: none !important;
            border-color: #93b4f4 !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,.10) !important;
        }

        /* Common status helpers */
        .badge-diajukan,
        .status-diajukan,
        .status-badge-diajukan {
            background: var(--blue-soft) !important;
            color: var(--blue-dark) !important;
        }

        .badge-diproses,
        .status-diproses,
        .status-badge-diproses {
            background: var(--indigo-soft) !important;
            color: var(--indigo) !important;
        }

        .badge-selesai,
        .status-selesai,
        .status-badge-selesai {
            background: var(--success-soft) !important;
            color: var(--success) !important;
        }

        .badge-ditolak,
        .status-ditolak,
        .status-badge-ditolak {
            background: var(--danger-soft) !important;
            color: var(--danger) !important;
        }

        .badge-diambil,
        .status-diambil,
        .status-badge-diambil {
            background: var(--indigo-soft) !important;
            color: var(--indigo) !important;
        }

        /* =========================
           FOOTER
        ========================== */
        .footer {
            padding: 18px 34px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;

            background: rgba(255,255,255,.66);
            border-top: 1px solid var(--border);

            color: var(--faint);
            font-size: 10.5px;
        }

        .footer strong {
            color: var(--muted);
            font-weight: 800;
        }

        .footer-links {
            display: flex;
            gap: 18px;
        }

        .footer-links a {
            color: var(--faint);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--blue);
        }

        /* =========================
           MOBILE
        ========================== */
        .mobile-menu-btn {
            display: none;

            width: 40px;
            height: 40px;

            align-items: center;
            justify-content: center;

            border: 1px solid var(--border);
            border-radius: 11px;
            background: #fff;
            color: var(--text);

            cursor: pointer;
        }

        .mobile-overlay {
            display: none;

            position: fixed;
            inset: 0;
            z-index: 990;

            background: rgba(15,34,60,.44);
            backdrop-filter: blur(2px);
        }

        @media (max-width: 1100px) {
            :root {
                --sidebar-width: 238px;
            }

            .topbar {
                padding-left: 24px;
                padding-right: 24px;
            }

            .content {
                padding-left: 24px;
                padding-right: 24px;
            }

            .footer {
                padding-left: 24px;
                padding-right: 24px;
            }
        }

        @media (max-width: 860px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .24s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-menu-btn {
                display: inline-flex;
            }

            .mobile-overlay.show {
                display: block;
            }

            .main {
                width: 100%;
                margin-left: 0;
            }

            .profile-info {
                display: none;
            }

            .notification-panel {
                position: fixed;
                top: 70px;
                left: 12px;
                right: 12px;
                width: auto;
            }
        }

        @media (max-width: 620px) {
            .topbar {
                height: 68px;
                padding: 0 14px;
            }

            .content {
                padding: 20px 14px 28px;
            }

            .footer {
                padding: 15px 14px;
                flex-direction: column;
                align-items: flex-start;
            }

            .context {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<?php
    $fullName = trim((string) (session('nama_lengkap') ?? 'Mahasiswa'));
    $fullName = $fullName !== '' ? $fullName : 'Mahasiswa';

    $nameParts = preg_split('/\s+/', $fullName);
    $firstInitial = substr($nameParts[0] ?? 'M', 0, 1);
    $lastInitial = substr($nameParts[count($nameParts) - 1] ?? '', 0, 1);
    $initials = strtoupper($firstInitial . $lastInitial);

    $currentPath = trim(uri_string(), '/');

    $notificationRows = is_array($notifications ?? null)
        ? $notifications
        : [];

    $unreadCountValue = (int) ($unreadCount ?? 0);
?>

<div class="app">

    <!-- =====================================================
         SIDEBAR
    ====================================================== -->
    <aside class="sidebar" id="studentSidebar">

        <a href="<?= site_url('mahasiswa') ?>" class="brand">

            <div class="brand-mark">
                JTI
            </div>

            <div class="brand-copy">
                <div class="brand-title">
                    JTI Signature
                </div>

                <div class="brand-subtitle">
                    Academic Services
                </div>
            </div>

        </a>

        <div class="nav-section">
            Menu Utama
        </div>

        <nav class="sidebar-nav">

            <a
                href="<?= site_url('mahasiswa') ?>"
                class="nav-item <?= ($currentPath === 'mahasiswa' || $currentPath === '') ? 'active' : '' ?>"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </span>

                <span>Dashboard</span>
            </a>

            <a
                href="<?= site_url('mahasiswa/permohonan/create') ?>"
                class="nav-item <?= $currentPath === 'mahasiswa/permohonan/create' ? 'active' : '' ?>"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                </span>

                <span>Ajukan Permohonan</span>
            </a>

            <a
                href="<?= site_url('mahasiswa/permohonan') ?>"
                class="nav-item <?= (
                    $currentPath === 'mahasiswa/permohonan' ||
                    (
                        str_starts_with($currentPath, 'mahasiswa/permohonan/') &&
                        $currentPath !== 'mahasiswa/permohonan/create'
                    )
                ) ? 'active' : '' ?>"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="8" y1="13" x2="16" y2="13"></line>
                        <line x1="8" y1="17" x2="13" y2="17"></line>
                    </svg>
                </span>

                <span>Permohonan Saya</span>
            </a>

        </nav>

        <div class="sidebar-spacer"></div>

        <div class="sidebar-bottom">

            <a
                href="<?= site_url('mahasiswa/profil') ?>"
                class="nav-item <?= str_starts_with($currentPath, 'mahasiswa/profil') ? 'active' : '' ?>"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>

                <span>Profil</span>
            </a>

            <a
                href="#"
                class="nav-item"
                onclick="alert('Pusat Bantuan JTI Signature:\nHubungi bagian Administrasi Jurusan Teknologi Informasi untuk bantuan layanan.'); return false;"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.2 9a3 3 0 1 1 5.5 1.7c-.9 1.2-2.7 1.7-2.7 3.3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </span>

                <span>Pusat Bantuan</span>
            </a>

            <a
                href="<?= site_url('logout') ?>"
                class="nav-item logout"
            >
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                </span>

                <span>Keluar</span>
            </a>

        </div>

    </aside>

    <div
        class="mobile-overlay"
        id="mobileOverlay"
        onclick="closeSidebar()"
    ></div>

    <!-- =====================================================
         MAIN
    ====================================================== -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="mobile-menu-btn"
                    onclick="openSidebar()"
                    aria-label="Buka menu"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" y1="6" x2="20" y2="6"></line>
                        <line x1="4" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="18" x2="20" y2="18"></line>
                    </svg>
                </button>

                <div class="context">
                    <span class="context-label">
                        Layanan Akademik
                    </span>

                    <span class="context-title">
                        Sistem Tanda Tangan JTI
                    </span>
                </div>

            </div>

            <div class="topbar-right">

                <!-- NOTIFICATION -->
                <div class="notification-wrap">

                    <button
                        type="button"
                        class="icon-btn"
                        id="notificationButton"
                        aria-label="Notifikasi"
                        aria-expanded="false"
                        title="Notifikasi"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>

                        <?php if ($unreadCountValue > 0): ?>
                            <span class="notif-badge">
                                <?= $unreadCountValue > 99 ? '99+' : $unreadCountValue ?>
                            </span>
                        <?php endif; ?>

                    </button>

                    <div
                        class="notification-panel"
                        id="notificationPanel"
                    >

                        <div class="notification-head">

                            <div class="notification-head-left">

                                <h3>
                                    Notifikasi
                                </h3>

                                <?php if ($unreadCountValue > 0): ?>
                                    <span class="count-pill">
                                        <?= $unreadCountValue ?>
                                    </span>
                                <?php endif; ?>

                            </div>

                            <?php if ($unreadCountValue > 0): ?>
                                <a
                                    href="<?= site_url('notifications/read-all') ?>"
                                    class="mark-all"
                                >
                                    Tandai semua dibaca
                                </a>
                            <?php endif; ?>

                        </div>

                        <div class="notification-list">

                            <?php if (empty($notificationRows)): ?>

                                <div class="notification-empty">

                                    <div class="notification-empty-icon">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                    </div>

                                    <h4>
                                        Belum ada notifikasi
                                    </h4>

                                    <p>
                                        Update permohonan akan muncul di sini.
                                    </p>

                                </div>

                            <?php else: ?>

                                <?php foreach ($notificationRows as $notification): ?>

                                    <a
                                        href="<?= site_url('notifications/read/' . $notification['id_notifikasi']) ?>"
                                        class="notification-item <?= (int) ($notification['dibaca'] ?? 0) === 0 ? 'unread' : '' ?>"
                                    >

                                        <div class="notification-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                            </svg>
                                        </div>

                                        <div class="notification-body">

                                            <div class="notification-title">
                                                <?= esc($notification['judul'] ?? 'Notifikasi') ?>
                                            </div>

                                            <p class="notification-message">
                                                <?= esc($notification['pesan'] ?? '') ?>
                                            </p>

                                            <span class="notification-time">
                                                <?= esc($notification['created_at'] ?? '') ?>
                                            </span>

                                        </div>

                                        <?php if ((int) ($notification['dibaca'] ?? 0) === 0): ?>
                                            <span class="new-dot"></span>
                                        <?php endif; ?>

                                    </a>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                        <div class="notification-footer">

                            <a href="<?= site_url('notifications') ?>">
                                <span>Lihat semua notifikasi</span>
                                <span>→</span>
                            </a>

                        </div>

                    </div>

                </div>

                <!-- PROFILE -->
                <a
                    href="<?= site_url('mahasiswa/profil') ?>"
                    class="profile"
                >

                    <div class="avatar">
                        <?= esc($initials) ?>
                    </div>

                    <div class="profile-info">

                        <span class="profile-name">
                            <?= esc($fullName) ?>
                        </span>

                        <span class="profile-role">
                            Mahasiswa
                        </span>

                    </div>

                </a>

            </div>

        </header>

        <!-- CONTENT -->
        <div class="content">

            <?php if (session('success')): ?>

                <div class="alert alert-success">

                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>

                    <span>
                        <?= esc(session('success')) ?>
                    </span>

                </div>

            <?php endif; ?>

            <?php if (session('error')): ?>

                <div class="alert alert-error">

                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>

                    <span>
                        <?= esc(session('error')) ?>
                    </span>

                </div>

            <?php endif; ?>

            <?= $this->renderSection('content') ?>

        </div>

        <!-- FOOTER -->
        <footer class="footer">

            <div>
                <strong>JTI Signature</strong>
                <span>
                    &nbsp;·&nbsp; © <?= date('Y') ?> Jurusan Teknologi Informasi
                </span>
            </div>

            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Pusat Bantuan</a>
            </div>

        </footer>

    </main>

</div>

<script>
    const notificationButton =
        document.getElementById('notificationButton');

    const notificationPanel =
        document.getElementById('notificationPanel');

    const sidebar =
        document.getElementById('studentSidebar');

    const mobileOverlay =
        document.getElementById('mobileOverlay');

    function closeNotification() {
        if (!notificationButton || !notificationPanel) {
            return;
        }

        notificationPanel.classList.remove('show');

        notificationButton.setAttribute(
            'aria-expanded',
            'false'
        );
    }

    function openSidebar() {
        if (!sidebar || !mobileOverlay) {
            return;
        }

        sidebar.classList.add('open');
        mobileOverlay.classList.add('show');

        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (!sidebar || !mobileOverlay) {
            return;
        }

        sidebar.classList.remove('open');
        mobileOverlay.classList.remove('show');

        document.body.style.overflow = '';
    }

    if (notificationButton && notificationPanel) {

        notificationButton.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                const isOpen =
                    notificationPanel.classList.contains('show');

                if (isOpen) {
                    closeNotification();
                } else {

                    notificationPanel.classList.add('show');

                    notificationButton.setAttribute(
                        'aria-expanded',
                        'true'
                    );
                }
            }
        );

        notificationPanel.addEventListener(
            'click',
            function (event) {
                event.stopPropagation();
            }
        );
    }

    document.addEventListener(
        'click',
        function () {
            closeNotification();
        }
    );

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeNotification();
                closeSidebar();
            }
        }
    );

    window.addEventListener(
        'resize',
        function () {

            if (window.innerWidth > 860) {
                closeSidebar();
            }

        }
    );
</script>

</body>
</html>
