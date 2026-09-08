<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Dashboard Admin - JTI Signature
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="dashboard-page">

    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="dashboard-header">

        <div>

            <h1>
                Dashboard Admin
            </h1>

            <p>
                Selamat datang kembali, Admin!
                Berikut adalah ringkasan status keseluruhan permohonan
                tanda tangan di sistem saat ini.
            </p>

        </div>

    </div>


    <!-- =====================================
         STATISTICS
    ====================================== -->

    <div class="stats-grid">

        <!-- TOTAL -->

        <div class="stat-card">

            <div class="stat-icon total">

                <i class="fa-regular fa-folder-open"></i>

            </div>

            <div class="stat-content">

                <span>
                    Total Permohonan
                </span>

                <strong>
                    <?= $statistik['total'] ?>
                </strong>

            </div>

        </div>


        <!-- DIAJUKAN -->

        <div class="stat-card">

            <div class="stat-icon submitted">

                <i class="fa-solid fa-circle-info"></i>

            </div>

            <div class="stat-content">

                <span>
                    Diajukan
                </span>

                <strong>
                    <?= $statistik['diajukan'] ?>
                </strong>

            </div>

        </div>


        <!-- DIPROSES -->

        <div class="stat-card">

            <div class="stat-icon processing">

                <i class="fa-regular fa-clock"></i>

            </div>

            <div class="stat-content">

                <span>
                    Diproses
                </span>

                <strong>
                    <?= $statistik['diproses'] ?>
                </strong>

            </div>

        </div>


        <!-- SELESAI -->

        <div class="stat-card">

            <div class="stat-icon completed">

                <i class="fa-regular fa-circle-check"></i>

            </div>

            <div class="stat-content">

                <span>
                    Selesai
                </span>

                <strong>
                    <?= $statistik['selesai'] ?>
                </strong>

            </div>

        </div>


        <!-- DITOLAK -->

        <div class="stat-card">

            <div class="stat-icon rejected">

                <i class="fa-regular fa-circle-xmark"></i>

            </div>

            <div class="stat-content">

                <span>
                    Ditolak
                </span>

                <strong>
                    <?= $statistik['ditolak'] ?>
                </strong>

            </div>

        </div>


        <!-- DIAMBIL -->

        <div class="stat-card">

            <div class="stat-icon picked">

                <i class="fa-solid fa-box-archive"></i>

            </div>

            <div class="stat-content">

                <span>
                    Diambil
                </span>

                <strong>
                    <?= $statistik['diambil'] ?>
                </strong>

            </div>

        </div>

    </div>


    <!-- =====================================
         AKTIVITAS
    ====================================== -->

    <section class="activity-section">

        <div class="section-header">

            <div>

                <h2>
                    Aktivitas Terbaru
                </h2>

                <p>
                    Berikut adalah aktivitas terbaru
                    pada sistem.
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

            <?php if (! empty($aktivitas)) : ?>

                <div class="activity-list">

                    <?php foreach ($aktivitas as $p) : ?>

                        <div class="activity-item">

                            <div class="activity-icon">

                                <i class="fa-regular fa-file-lines"></i>

                            </div>


                            <div class="activity-info">

                                <strong>

                                    Permohonan Baru:
                                    <?= esc($p['nama_lengkap']) ?>

                                </strong>

                                <span>

                                    #<?= esc($p['id_permohonan']) ?>

                                    •

                                    <?= esc($p['nama_tujuan']) ?>

                                </span>

                            </div>


                            <div class="activity-status">

                                <?php
                                $status = strtoupper(
                                    $p['nama_status']
                                );
                                ?>

                                <span
                                    class="status-badge <?= strtolower($status) ?>"
                                >
                                    <?= esc($status) ?>
                                </span>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php else : ?>

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="fa-solid fa-inbox"></i>

                    </div>

                    <h3>
                        Belum ada permohonan
                    </h3>

                    <p>
                        Belum ada permohonan yang masuk ke sistem.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </section>

</div>

<?= $this->endSection() ?>