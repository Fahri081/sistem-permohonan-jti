<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sistem Tanda Tangan JTI') ?></title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-navy: #133863;
            --primary-navy-dark: #0a1f38;
            --sidebar-bg: #153a6b;
            --sidebar-active: #1d4e8c;
            --sidebar-hover: #19447c;
            --sidebar-text: #b8cee8;
            --sidebar-text-active: #ffffff;
            --bg-main: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --badge-amber-bg: #fef3c7;
            --badge-amber-text: #b45309;
            --badge-green-bg: #d1fae5;
            --badge-green-text: #047857;
            --badge-blue-bg: #e0f2fe;
            --badge-blue-text: #0284c7;
            --badge-red-bg: #fee2e2;
            --badge-red-text: #b91c1c;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            background: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sidebar-bg);
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        .brand-text h1 {
            font-size: 15.5px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.2px;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 11px;
            color: var(--sidebar-text);
            margin-top: 2px;
            font-weight: 400;
        }

        .sidebar-menu {
            list-style: none;
            padding: 10px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu.bottom-menu {
            flex: 0;
            padding-bottom: 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: auto;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .menu-item a:hover {
            background-color: var(--sidebar-hover);
            color: var(--sidebar-text-active);
        }

        .menu-item.active a {
            background-color: var(--sidebar-active);
            color: var(--sidebar-text-active);
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .menu-icon {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.95;
            flex-shrink: 0;
        }

        /* MAIN CONTENT AREA */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: 68px;
            background: transparent;
            padding: 0 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .topbar-left-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-left: auto;
        }

        /* NOTIFICATION CONTAINER & DROPDOWN */
        .notif-dropdown-wrapper {
            position: relative;
        }

        .notif-btn {
            position: relative;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-dark);
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }

        .notif-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        /* RED DOT (TITIK MERAH INFO ADMIN) */
        .notif-badge {
            position: absolute;
            top: 6px;
            right: 7px;
            width: 9px;
            height: 9px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
            animation: pulse-red 2s infinite ease-in-out;
        }

        @keyframes pulse-red {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.15); opacity: 0.85; }
        }

        .notif-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 340px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            display: none;
            z-index: 1000;
            overflow: hidden;
            animation: fadeIn 0.15s ease-out;
        }

        .notif-dropdown.show {
            display: block;
        }

        .notif-dropdown-header {
            padding: 14px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notif-dropdown-header h4 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
        }

        .notif-badge-pill {
            background: #ef4444;
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
        }

        .notif-list {
            max-height: 320px;
            overflow-y: auto;
            list-style: none;
        }

        .notif-item {
            padding: 12px 18px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s;
            cursor: pointer;
        }

        .notif-item:hover {
            background: #f8fafc;
        }

        .notif-item.unread {
            background: #f0fdf4;
        }

        .notif-item-title {
            font-size: 12.5px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notif-item-desc {
            font-size: 12px;
            color: #64748b;
            line-height: 1.4;
        }

        .notif-item-time {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 5px;
        }

        .settings-btn {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-dark);
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            text-decoration: none;
        }

        .settings-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        .user-avatar-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .user-avatar-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #ffffff;
            font-weight: 700;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .user-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            letter-spacing: -0.1px;
        }

        /* CONTENT CONTAINER */
        .content-container {
            padding: 0 36px 36px;
            flex: 1;
        }

        /* ALERTS */
        .alert {
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 22px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* FOOTER */
        .footer {
            background-color: transparent;
            border-top: 1px solid var(--border-color);
            padding: 18px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: auto;
        }

        .footer-brand {
            font-weight: 700;
            color: var(--text-dark);
            margin-right: 8px;
        }

        .footer-links {
            display: flex;
            gap: 22px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .footer-links a:hover {
            color: var(--text-dark);
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                min-height: auto;
                position: static;
            }
            .sidebar-menu {
                flex-direction: row;
                flex-wrap: wrap;
            }
            .sidebar-menu.bottom-menu {
                border-top: none;
                padding-bottom: 10px;
            }
            .content-container, .topbar, .footer {
                padding-left: 18px;
                padding-right: 18px;
            }
            .footer {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <a href="<?= site_url('mahasiswa') ?>" class="sidebar-brand">
            <div class="brand-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#153a6b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="brand-text">
                <h1>JTI Signature</h1>
                <p>Layanan Akademik</p>
            </div>
        </a>

        <ul class="sidebar-menu">
            <!-- 1. Dashboard -->
            <li class="menu-item <?= (current_url() == site_url('mahasiswa') || current_url() == site_url('mahasiswa/')) ? 'active' : '' ?>">
                <a href="<?= site_url('mahasiswa') ?>">
                    <span class="menu-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- 2. Ajukan Baru -->
            <li class="menu-item <?= strpos(current_url(), 'permohonan/create') !== false ? 'active' : '' ?>">
                <a href="<?= site_url('mahasiswa/permohonan/create') ?>">
                    <span class="menu-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </span>
                    <span>Ajukan Baru</span>
                </a>
            </li>

            <!-- 3. Permohonan Saya -->
            <li class="menu-item <?= (strpos(current_url(), 'permohonan') !== false && strpos(current_url(), 'permohonan/create') === false) ? 'active' : '' ?>">
                <a href="<?= site_url('mahasiswa') ?>">
                    <span class="menu-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </span>
                    <span>Permohonan Saya</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu bottom-menu">
            <li class="menu-item">
                <a href="<?= site_url('logout') ?>">
                    <span class="menu-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </span>
                    <span>Keluar</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" onclick="alert('Pusat Bantuan JTI Signature:\nHubungi bagian Administrasi Jurusan Teknologi Informasi atau email ke jti@polinema.ac.id'); return false;">
                    <span class="menu-icon">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </span>
                    <span>Pusat Bantuan</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- TOPBAR -->
        <header class="topbar">
            <div>
                <?php if (current_url() != site_url('mahasiswa') && current_url() != site_url('mahasiswa/')): ?>
                    <span class="topbar-left-title">Sistem Tanda Tangan JTI</span>
                <?php endif; ?>
            </div>

            <div class="topbar-right">
                <!-- NOTIFICATION BUTTON WITH RED DOT (INFO DARI ADMIN) -->
                <div class="notif-dropdown-wrapper">
                    <button type="button" class="notif-btn" id="notifBtn" title="Pemberitahuan & Info dari Admin">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <!-- TITIK MERAH (INFO ADMIN) -->
                        <span class="notif-badge" id="notifBadge"></span>
                    </button>

                    <!-- DROPDOWN NOTIFIKASI INFO ADMIN -->
                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="notif-dropdown-header">
                            <h4>Info & Pemberitahuan Admin</h4>
                            <span class="notif-badge-pill">2 Baru</span>
                        </div>
                        <ul class="notif-list">
                            <li class="notif-item unread">
                                <div class="notif-item-title">
                                    <span>Permohonan Siap Diambil</span>
                                    <span style="color:#059669; font-size:11px;">Baru</span>
                                </div>
                                <div class="notif-item-desc">Dokumen <strong>#REQ-039</strong> (Tanda Tangan Pengesahan PKL) telah selesai & siap diambil di Ruang Admin Jurusan.</div>
                                <div class="notif-item-time">10 menit yang lalu</div>
                            </li>
                            <li class="notif-item unread">
                                <div class="notif-item-title">
                                    <span>Status Berkas Diperbarui</span>
                                    <span style="color:#2563eb; font-size:11px;">Baru</span>
                                </div>
                                <div class="notif-item-desc">Permohonan <strong>#REQ-042</strong> telah diverifikasi dan sedang diproses Ketua Program Studi.</div>
                                <div class="notif-item-time">2 jam yang lalu</div>
                            </li>
                            <li class="notif-item">
                                <div class="notif-item-title">
                                    <span>Catatan Revisi Berkas</span>
                                </div>
                                <div class="notif-item-desc">Berkas permohonan <strong>#REQ-031</strong> ditolak: Surat pernyataan orang tua belum bermaterai.</div>
                                <div class="notif-item-time">1 hari yang lalu</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- SETTINGS ICON -->
                <a href="#" class="settings-btn" title="Pengaturan Akun" onclick="alert('Pengaturan Akun Mahasiswa'); return false;">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </a>

                <?php
                    $fullName = session('nama_lengkap') ?? 'Budi Santoso';
                    $avatarPath = base_url('assets/images/avatar_budi.jpg');
                ?>
                <!-- USER PROFILE -->
                <div class="user-profile">
                    <img src="<?= $avatarPath ?>" alt="<?= esc($fullName) ?>" class="user-avatar-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="user-avatar-placeholder" style="display:none;">BS</div>
                    <?php if (current_url() == site_url('mahasiswa') || current_url() == site_url('mahasiswa/')): ?>
                        <span class="user-name"><?= esc($fullName) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- CONTENT CONTAINER -->
        <main class="content-container">
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span><?= esc(session('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span><?= esc(session('error')) ?></span>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>

        <!-- FOOTER -->
        <footer class="footer">
            <div>
                <span class="footer-brand">JTI Signature</span>
                <span>&copy; <?= date('Y') ?> Jurusan Teknologi Informasi. Hak Cipta Dilindungi Undang-Undang.</span>
            </div>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat dan Ketentuan</a>
                <a href="#">Peta Situs</a>
            </div>
        </footer>
    </div>

    <!-- NOTIFICATION DROPDOWN SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            const notifBadge = document.getElementById('notifBadge');

            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!notifDropdown.contains(e.target) && e.target !== notifBtn) {
                        notifDropdown.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>
