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
                class="nav-item"
            >

                <i class="fa-regular fa-file-lines"></i>

                <span>Semua Permohonan</span>

            </a>


            <a
                href="<?= site_url('admin/laporan') ?>"
                class="nav-item"
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

                <button class="topbar-icon">

                    <i class="fa-regular fa-bell"></i>

                    <span class="notification-dot"></span>

                </button>


                <div class="topbar-divider"></div>


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

</body>

</html>