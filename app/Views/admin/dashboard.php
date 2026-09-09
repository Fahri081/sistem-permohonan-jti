<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Dashboard Admin - JTI Signature
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="admin-dashboard">

    <!-- =========================================
         HEADER
    ========================================== -->

    <div class="dashboard-intro">

        <div>

            <span class="eyebrow">
                ADMINISTRATOR
            </span>

            <h1>
                Dashboard Admin
            </h1>

            <p>
                Pantau dan kelola seluruh proses permohonan
                tanda tangan akademik dalam satu tempat.
            </p>

        </div>

        <div class="intro-date">

            <i class="fa-regular fa-calendar"></i>

            <span>
                Hari ini
            </span>

        </div>

    </div>


    <!-- =========================================
         STATISTIC CARDS
    ========================================== -->

    <div class="stats-grid">


        <!-- TOTAL -->

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon total">

                    <i class="fa-regular fa-folder-open"></i>

                </div>

                <span class="stat-caption">
                    Keseluruhan
                </span>

            </div>

            <div class="stat-bottom">

                <strong>
                    <?= number_format($statistik['total']) ?>
                </strong>

                <span>
                    Total Permohonan
                </span>

            </div>

        </article>


        <!-- DIAJUKAN -->

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon submitted">

                    <i class="fa-solid fa-circle-info"></i>

                </div>

                <span class="stat-caption blue">
                    Menunggu
                </span>

            </div>

            <div class="stat-bottom">

                <strong>
                    <?= number_format($statistik['diajukan']) ?>
                </strong>

                <span>
                    Diajukan
                </span>

            </div>

        </article>


        <!-- DIPROSES -->

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon processing">

                    <i class="fa-regular fa-clock"></i>

                </div>

                <span class="stat-caption orange">
                    Aktif
                </span>

            </div>

            <div class="stat-bottom">

                <strong>
                    <?= number_format($statistik['diproses']) ?>
                </strong>

                <span>
                    Diproses
                </span>

            </div>

        </article>


        <!-- SELESAI -->

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon completed">

                    <i class="fa-regular fa-circle-check"></i>

                </div>

                <span class="stat-caption green">
                    Berhasil
                </span>

            </div>

            <div class="stat-bottom">

                <strong>
                    <?= number_format($statistik['selesai']) ?>
                </strong>

                <span>
                    Selesai
                </span>

            </div>

        </article>


        <!-- DITOLAK -->

        <article class="stat-card">

            <div class="stat-top">

                <div class="stat-icon rejected">

                    <i class="fa-regular fa-circle-xmark"></i>

                </div>

                <span class="stat-caption red">
                    Perlu perhatian
                </span>

            </div>

            <div class="stat-bottom">

                <strong>
                    <?= number_format($statistik['ditolak']) ?>
                </strong>

                <span>
                    Ditolak
                </span>

            </div>

        </article>


        <!-- DIAMBIL - FEATURED -->

        <article class="stat-card featured">

            <div class="featured-decoration"></div>

            <div class="stat-top">

                <div class="stat-icon featured-icon">

                    <i class="fa-solid fa-box-archive"></i>

                </div>

                <span class="featured-label">
                    Completed
                </span>

            </div>

            <div class="featured-content">

                <strong>
                    <?= number_format($statistik['diambil']) ?>
                </strong>

                <span>
                    Siap Diambil
                </span>

            </div>

            <div class="featured-arrow">

                <i class="fa-solid fa-arrow-up-right-from-square"></i>

            </div>

        </article>


    </div>


    <!-- =========================================
         ACTIVITY SECTION
    ========================================== -->

    <section class="activity-section">

        <div class="section-heading">

            <div>

                <span class="section-label">
                    MONITORING
                </span>

                <h2>
                    Aktivitas Terbaru
                </h2>

                <p>
                    Aktivitas permohonan terbaru dalam sistem.
                </p>

            </div>


            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="view-all"
            >

                Lihat Semua

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        <div class="activity-card">

            <div class="activity-card-header">

                <div>
                    Permohonan Terbaru
                </div>

                <span>
                    <?= count($aktivitas) ?> aktivitas
                </span>

            </div>


            <?php if (! empty($aktivitas)) : ?>

                <div class="activity-list">

                    <?php foreach ($aktivitas as $index => $p) : ?>

                        <?php

                        $status =
                            strtoupper(
                                $p['nama_status']
                            );

                        $statusClass =
                            strtolower($status);

                        ?>

                        <div class="activity-item">

                            <!-- NUMBER -->

                            <div class="activity-number">

                                <?= str_pad(
                                    $index + 1,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>

                            </div>


                            <!-- ICON -->

                            <div
                                class="
                                    activity-icon
                                    <?= esc($statusClass) ?>
                                "
                            >

                                <?php if ($status === 'DIAJUKAN') : ?>

                                    <i class="fa-solid fa-paper-plane"></i>

                                <?php elseif ($status === 'DIPROSES') : ?>

                                    <i class="fa-regular fa-clock"></i>

                                <?php elseif ($status === 'SELESAI') : ?>

                                    <i class="fa-regular fa-circle-check"></i>

                                <?php elseif ($status === 'DITOLAK') : ?>

                                    <i class="fa-regular fa-circle-xmark"></i>

                                <?php elseif ($status === 'DIAMBIL') : ?>

                                    <i class="fa-solid fa-box-archive"></i>

                                <?php else : ?>

                                    <i class="fa-regular fa-file-lines"></i>

                                <?php endif; ?>

                            </div>


                            <!-- INFORMATION -->

                            <div class="activity-info">

                                <div class="activity-main">

                                    <strong>

                                        Permohonan Baru:
                                        <?= esc(
                                            $p['nama_lengkap']
                                        ) ?>

                                    </strong>

                                    <span>

                                        #<?= esc(
                                            $p['id_permohonan']
                                        ) ?>

                                    </span>

                                </div>


                                <div class="activity-meta">

                                    <span>

                                        <?= esc(
                                            $p['nama_tujuan']
                                        ) ?>

                                    </span>

                                    <span class="meta-dot">
                                        •
                                    </span>

                                    <span>
                                        <?= esc($status) ?>
                                    </span>

                                </div>

                            </div>


                            <!-- STATUS -->

                            <div class="activity-right">

                                <span
                                    class="
                                        activity-status
                                        <?= esc($statusClass) ?>
                                    "
                                >

                                    <?= esc($status) ?>

                                </span>


                                <a
                                    href="<?= site_url(
                                        'admin/permohonan/' .
                                        $p['id_permohonan']
                                    ) ?>"
                                    class="activity-detail"
                                    title="Lihat detail"
                                >

                                    <i class="fa-solid fa-chevron-right"></i>

                                </a>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>


            <?php else : ?>


                <!-- EMPTY -->

                <div class="activity-empty">

                    <div class="empty-symbol">

                        <i class="fa-regular fa-folder-open"></i>

                    </div>

                    <h3>
                        Belum ada aktivitas
                    </h3>

                    <p>
                        Belum ada permohonan baru yang masuk ke sistem.
                    </p>

                    <a
                        href="<?= site_url('admin/permohonan') ?>"
                        class="empty-button"
                    >
                        Buka Semua Permohonan
                    </a>

                </div>


            <?php endif; ?>

        </div>

    </section>

</div>

<?= $this->endSection() ?>