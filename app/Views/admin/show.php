<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Detail Permohonan - JTI Signature
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<link
    rel="stylesheet"
    href="<?= base_url('assets/css/admin/show.css') ?>"
>


<div class="detail-page">


    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="detail-header">

        <div class="detail-header-left">

            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="back-button"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar
            </a>


            <div class="title-row">

                <div>

                    <div class="title-label">
                        DETAIL PERMOHONAN
                    </div>

                    <h1>
                        Request #REQ-<?= esc($permohonan['id_permohonan']) ?>
                    </h1>

                </div>


                <?php
                $status = strtoupper(
                    $permohonan['nama_status']
                );

                $statusClass = strtolower(
                    $status
                );
                ?>


                <span
                    class="global-status <?= esc($statusClass) ?>"
                >

                    <span class="status-dot"></span>

                    <?= esc($status) ?>

                </span>

            </div>

        </div>


        <div class="submitted">

            <span>
                Tanggal Pengajuan
            </span>

            <strong>

                <?= ! empty(
                    $permohonan['tanggal_pengajuan']
                )
                    ? esc(
                        date(
                            'd M Y, H:i',
                            strtotime(
                                $permohonan[
                                    'tanggal_pengajuan'
                                ]
                            )
                        )
                    )
                    : '-'
                ?>

                WIB

            </strong>

        </div>

    </div>



    <!-- =====================================================
         MAIN GRID
    ====================================================== -->

    <div class="detail-layout">


        <!-- =================================================
             LEFT
        ================================================== -->

        <main class="detail-main">


            <!-- =============================================
                 MAHASISWA
            ============================================== -->

            <section class="detail-card student-card">

                <div class="section-title">

                    <div class="title-icon blue">

                        <i class="fa-solid fa-user"></i>

                    </div>

                    <div>

                        <h2>
                            Informasi Mahasiswa
                        </h2>

                        <p>
                            Data pemohon yang mengajukan permintaan.
                        </p>

                    </div>

                </div>


                <div class="student-profile">

                    <div class="profile-avatar">

                        <?= strtoupper(
                            substr(
                                $permohonan[
                                    'nama_lengkap'
                                ],
                                0,
                                1
                            )
                        ) ?>

                    </div>


                    <div class="student-name">

                        <span>
                            Nama Lengkap
                        </span>

                        <strong>
                            <?= esc(
                                $permohonan[
                                    'nama_lengkap'
                                ]
                            ) ?>
                        </strong>

                    </div>


                    <div class="student-meta">

                        <div>

                            <span>
                                NIM
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan[
                                        'nim'
                                    ]
                                ) ?>
                            </strong>

                        </div>


                        <div>

                            <span>
                                Email
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan[
                                        'email'
                                    ]
                                ) ?>
                            </strong>

                        </div>


                        <div>

                            <span>
                                No. Handphone
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan[
                                        'no_hp'
                                    ]
                                ) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </section>



            <!-- =============================================
                 PERMOHONAN
            ============================================== -->

            <section class="detail-card">

                <div class="section-title">

                    <div class="title-icon navy">

                        <i class="fa-regular fa-file-lines"></i>

                    </div>

                    <div>

                        <h2>
                            Tujuan Permohonan
                        </h2>

                        <p>
                            Informasi mengenai permintaan tanda tangan.
                        </p>

                    </div>

                </div>


                <!-- TUJUAN -->

                <div class="request-field">

                    <span>
                        Tujuan Permohonan
                    </span>

                    <div class="request-value highlight">

                        <?= esc(
                            $permohonan[
                                'nama_tujuan'
                            ]
                        ) ?>

                    </div>

                </div>


                <!-- KEPERLUAN -->

                <div class="request-field">

                    <span>
                        Keperluan
                    </span>

                    <div class="request-value">

                        <?= esc(
                            $permohonan[
                                'keperluan'
                            ]
                        ) ?>

                    </div>

                </div>


                <!-- DESKRIPSI -->

                <div class="request-field">

                    <span>
                        Deskripsi Tambahan
                    </span>

                    <div class="request-value description">

                        <?php if (
                            ! empty(
                                $permohonan[
                                    'deskripsi'
                                ]
                            )
                        ) : ?>

                            <?= nl2br(
                                esc(
                                    $permohonan[
                                        'deskripsi'
                                    ]
                                )
                            ) ?>

                        <?php else : ?>

                            <span class="empty-text">
                                Tidak ada deskripsi tambahan.
                            </span>

                        <?php endif; ?>

                    </div>

                </div>

            </section>



            <!-- =============================================
                 BERKAS
            ============================================== -->

            <section class="detail-card">

                <div class="section-title section-title-between">

                    <div class="title-group">

                        <div class="title-icon purple">

                            <i class="fa-solid fa-paperclip"></i>

                        </div>

                        <div>

                            <h2>
                                Berkas Dokumen
                            </h2>

                            <p>
                                Pemeriksaan dilakukan pada setiap berkas.
                            </p>

                        </div>

                    </div>


                    <span class="document-count">

                        <?= count($berkas) ?>

                        <?= count($berkas) === 1
                            ? 'Berkas'
                            : 'Berkas'
                        ?>

                    </span>

                </div>



                <?php if (! empty($berkas)) : ?>

                    <div class="document-list">

                        <?php foreach ($berkas as $index => $b) : ?>

                            <?php
                            $isDone =
                                (int) $b['selesai'] === 1;
                            ?>


                            <article class="document-card">


                                <!-- NUMBER -->

                                <div class="document-number">

                                    <?= str_pad(
                                        $index + 1,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) ?>

                                </div>


                                <!-- ICON -->

                                <div class="document-icon">

                                    <i class="fa-regular fa-file-lines"></i>

                                </div>


                                <!-- INFORMATION -->

                                <div class="document-info">

                                    <strong>

                                        <?= esc(
                                            $b[
                                                'nama_berkas'
                                            ]
                                        ) ?>

                                    </strong>

                                    <span>

                                        <?= $isDone
                                            ? 'Berkas sudah selesai diproses'
                                            : 'Menunggu pemeriksaan admin'
                                        ?>

                                    </span>

                                </div>


                                <!-- STATUS -->

                                <div class="document-status">

                                    <?php if ($isDone) : ?>

                                        <span class="document-badge completed">

                                            <i class="fa-regular fa-circle-check"></i>

                                            Selesai

                                        </span>

                                    <?php else : ?>

                                        <span class="document-badge processing">

                                            <i class="fa-regular fa-clock"></i>

                                            Diproses

                                        </span>

                                    <?php endif; ?>

                                </div>


                                <!-- ACTION -->

                                <div class="document-action">

                                    <form
                                        method="post"
                                        action="<?= site_url(
                                            'admin/berkas/' .
                                            $b[
                                                'id_berkas'
                                            ] .
                                            '/status'
                                        ) ?>"
                                    >

                                        <?= csrf_field() ?>


                                        <input
                                            type="hidden"
                                            name="selesai"
                                            value="<?= $isDone ? 0 : 1 ?>"
                                        >


                                        <button
                                            type="submit"
                                            class="<?= $isDone
                                                ? 'document-button secondary'
                                                : 'document-button success'
                                            ?>"
                                        >

                                            <?php if ($isDone) : ?>

                                                <i class="fa-solid fa-rotate-left"></i>

                                                Buka Kembali

                                            <?php else : ?>

                                                <i class="fa-solid fa-check"></i>

                                                Set Selesai

                                            <?php endif; ?>

                                        </button>

                                    </form>

                                </div>


                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php else : ?>


                    <div class="no-documents">

                        <div class="no-documents-icon">

                            <i class="fa-regular fa-folder-open"></i>

                        </div>

                        <strong>
                            Belum ada berkas
                        </strong>

                        <span>
                            Tidak ada dokumen yang dilampirkan pada permohonan ini.
                        </span>

                    </div>

                <?php endif; ?>

            </section>

        </main>



        <!-- =================================================
             RIGHT SIDEBAR
        ================================================== -->

        <aside class="detail-side">


            <!-- =============================================
                 STATUS SUMMARY
            ============================================== -->

            <section class="side-card status-card">

                <div class="side-card-header">

                    <span>
                        STATUS PERMOHONAN
                    </span>

                    <i class="fa-solid fa-chart-simple"></i>

                </div>


                <div
                    class="status-large <?= esc(
                        $statusClass
                    ) ?>"
                >

                    <span class="status-dot"></span>

                    <div>

                        <strong>
                            <?= esc($status) ?>
                        </strong>

                        <span>
                            Status saat ini
                        </span>

                    </div>

                </div>

            </section>



            <!-- =============================================
                 FOTO BUKTI
            ============================================== -->

            <section class="side-card">

                <div class="side-heading">

                    <div>

                        <h2>
                            Foto Bukti Pengumpulan
                        </h2>

                        <p>
                            Bukti penyerahan berkas fisik ke admin jurusan.
                        </p>

                    </div>

                    <i class="fa-regular fa-image"></i>

                </div>


                <?php

                $fotoBukti = null;

                foreach ($berkas as $b) {

                    if (
                        ! empty(
                            $b['bukti_foto']
                        )
                    ) {

                        $fotoBukti =
                            $b['bukti_foto'];

                        break;

                    }
                }

                ?>


                <?php if ($fotoBukti) : ?>

                    <a
                        href="<?= base_url(
                            $fotoBukti
                        ) ?>"
                        target="_blank"
                        class="evidence-wrapper"
                    >

                        <img
                            src="<?= base_url(
                                $fotoBukti
                            ) ?>"
                            alt="Foto Bukti Pengumpulan"
                            class="evidence-image"
                        >

                        <div class="image-overlay">

                            <span>

                                <i class="fa-solid fa-expand"></i>

                                Lihat gambar

                            </span>

                        </div>

                    </a>

                <?php else : ?>

                    <div class="evidence-empty">

                        <div>

                            <i class="fa-regular fa-image"></i>

                        </div>

                        <strong>
                            Foto belum tersedia
                        </strong>

                        <span>
                            Mahasiswa belum mengunggah
                            foto bukti pengumpulan.
                        </span>

                    </div>

                <?php endif; ?>

            </section>



            <!-- =============================================
                 DECISION
            ============================================== -->

            <section class="side-card decision-card">

                <div class="side-heading">

                    <div>

                        <h2>
                            Keputusan Admin
                        </h2>

                        <p>
                            Perbarui status permohonan.
                        </p>

                    </div>

                    <i class="fa-solid fa-gavel"></i>

                </div>


                <form
                    method="post"
                    action="<?= site_url(
                        'admin/permohonan/' .
                        $permohonan[
                            'id_permohonan'
                        ] .
                        '/status'
                    ) ?>"
                >

                    <?= csrf_field() ?>


                    <!-- STATUS -->

                    <div class="control-group">

                        <label for="status">
                            Status Permohonan
                        </label>

                        <div class="control-select">

                            <select
                                name="status"
                                id="status"
                            >

                                <option
                                    value="DIAJUKAN"
                                    <?= $status === 'DIAJUKAN'
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Diajukan
                                </option>

                                <option
                                    value="DIPROSES"
                                    <?= $status === 'DIPROSES'
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Diproses
                                </option>

                                <option
                                    value="DITOLAK"
                                    <?= $status === 'DITOLAK'
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Ditolak
                                </option>

                                <option
                                    value="SELESAI"
                                    <?= $status === 'SELESAI'
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Selesai
                                </option>

                                <option
                                    value="DIAMBIL"
                                    <?= $status === 'DIAMBIL'
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    Diambil
                                </option>

                            </select>

                            <i class="fa-solid fa-chevron-down"></i>

                        </div>

                    </div>


                    <!-- REASON -->

                    <div class="control-group">

                        <label for="keterangan_penolakan">
                            Alasan Penolakan
                        </label>

                        <textarea
                            name="keterangan_penolakan"
                            id="keterangan_penolakan"
                            placeholder="Masukkan alasan jika permohonan ditolak..."
                        ><?= esc(
                            $permohonan[
                                'keterangan_penolakan'
                            ] ?? ''
                        ) ?></textarea>

                    </div>


                    <button
                        type="submit"
                        class="update-button"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Perubahan

                    </button>

                </form>


                <!-- REJECT -->

                <form
                    method="post"
                    action="<?= site_url(
                        'admin/permohonan/' .
                        $permohonan[
                            'id_permohonan'
                        ] .
                        '/status'
                    ) ?>"
                    class="reject-form"
                >

                    <?= csrf_field() ?>


                    <input
                        type="hidden"
                        name="status"
                        value="DITOLAK"
                    >


                    <input
                        type="hidden"
                        name="keterangan_penolakan"
                        value="<?= esc(
                            $permohonan[
                                'keterangan_penolakan'
                            ] ?? ''
                        ) ?>"
                    >


                    <button
                        type="submit"
                        class="reject-button"
                    >

                        <i class="fa-regular fa-circle-xmark"></i>

                        Tolak Permohonan

                    </button>

                </form>

            </section>

        </aside>

    </div>

</div>

<?= $this->endSection() ?>