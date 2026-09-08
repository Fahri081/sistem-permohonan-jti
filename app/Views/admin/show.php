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

    <!-- =========================================
         HEADER
    ========================================== -->

    <div class="detail-page-header">

        <div class="header-left">

            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="back-link"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar
            </a>

            <div class="request-title-row">

                <h1>
                    Request #REQ-<?= esc($permohonan['id_permohonan']) ?>
                </h1>

                <?php
                $statusGlobal = strtoupper(
                    $permohonan['nama_status']
                );

                $statusClass = strtolower(
                    $statusGlobal
                );
                ?>

                <span class="global-status <?= esc($statusClass) ?>">

                    <?php if ($statusGlobal === 'DIAJUKAN') : ?>

                        <i class="fa-solid fa-circle-info"></i>

                    <?php elseif ($statusGlobal === 'DIPROSES') : ?>

                        <i class="fa-regular fa-clock"></i>

                    <?php elseif ($statusGlobal === 'SELESAI') : ?>

                        <i class="fa-regular fa-circle-check"></i>

                    <?php elseif ($statusGlobal === 'DITOLAK') : ?>

                        <i class="fa-regular fa-circle-xmark"></i>

                    <?php elseif ($statusGlobal === 'DIAMBIL') : ?>

                        <i class="fa-solid fa-box-archive"></i>

                    <?php endif; ?>

                    <?= esc($statusGlobal) ?>

                </span>

            </div>

        </div>


        <div class="submitted-info">

            Submitted:

            <?= ! empty($permohonan['tanggal_pengajuan'])
                ? esc(
                    date(
                        'd M Y - H:i',
                        strtotime(
                            $permohonan['tanggal_pengajuan']
                        )
                    )
                )
                : '-'
            ?>

        </div>

    </div>


    <!-- =========================================
         MAIN GRID
    ========================================== -->

    <div class="detail-grid">


        <!-- =====================================
             LEFT COLUMN
        ====================================== -->

        <div class="detail-main">


            <!-- INFORMASI MAHASISWA -->

            <section class="detail-card">

                <div class="card-title">

                    <h2>
                        Informasi Mahasiswa
                    </h2>

                </div>


                <div class="student-detail">

                    <div class="student-avatar-large">

                        <i class="fa-solid fa-user"></i>

                    </div>


                    <div class="student-details-grid">

                        <div class="info-item">

                            <span class="info-label">
                                Nama Lengkap
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan['nama_lengkap']
                                ) ?>
                            </strong>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                NIM
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan['nim']
                                ) ?>
                            </strong>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                Email
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan['email']
                                ) ?>
                            </strong>

                        </div>


                        <div class="info-item">

                            <span class="info-label">
                                No. Handphone
                            </span>

                            <strong>
                                <?= esc(
                                    $permohonan['no_hp']
                                ) ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </section>


            <!-- TUJUAN PERMOHONAN -->

            <section class="detail-card">

                <div class="card-title">

                    <h2>
                        Tujuan Permohonan
                    </h2>

                </div>


                <div class="field-block">

                    <span class="field-label">
                        Tujuan Permohonan
                    </span>

                    <div class="field-value">
                        <?= esc(
                            $permohonan['nama_tujuan']
                        ) ?>
                    </div>

                </div>


                <div class="field-block">

                    <span class="field-label">
                        Keperluan
                    </span>

                    <div class="field-value">

                        <?= esc(
                            $permohonan['keperluan']
                        ) ?>

                    </div>

                </div>


                <div class="field-block">

                    <span class="field-label">
                        Deskripsi Tambahan
                    </span>

                    <div class="field-value description">

                        <?=
                            ! empty(
                                $permohonan['deskripsi']
                            )
                            ? nl2br(
                                esc(
                                    $permohonan['deskripsi']
                                )
                            )
                            : 'Tidak ada deskripsi tambahan.'
                        ?>

                    </div>

                </div>

            </section>


            <!-- BERKAS -->

            <section class="detail-card">

                <div class="card-title card-title-between">

                    <h2>
                        Berkas Dokumen
                    </h2>

                    <span class="attachment-count">

                        <?= count($berkas) ?>

                        Berkas Terlampir

                    </span>

                </div>


                <div class="document-list">

                    <?php if (! empty($berkas)) : ?>

                        <?php foreach ($berkas as $b) : ?>

                            <?php
                            $isDone =
                                (int) $b['selesai'] === 1;
                            ?>


                            <div class="document-item">

                                <div class="document-icon">

                                    <i class="fa-regular fa-file-lines"></i>

                                </div>


                                <div class="document-info">

                                    <strong>
                                        <?= esc(
                                            $b['nama_berkas']
                                        ) ?>
                                    </strong>

                                    <span>

                                        <?= $isDone
                                            ? 'Berkas sudah selesai diproses.'
                                            : 'Berkas sedang diproses.'
                                        ?>

                                    </span>

                                </div>


                                <div class="document-status">

                                    <?php if ($isDone) : ?>

                                        <span class="document-badge selesai">

                                            <i class="fa-regular fa-circle-check"></i>

                                            Selesai

                                        </span>

                                    <?php else : ?>

                                        <span class="document-badge diproses">

                                            <i class="fa-regular fa-clock"></i>

                                            Diproses

                                        </span>

                                    <?php endif; ?>

                                </div>


                                <div class="document-action">

                                    <form
                                        method="post"
                                        action="<?= site_url(
                                            'admin/berkas/' .
                                            $b['id_berkas'] .
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
                                                ? 'secondary-button'
                                                : 'success-button'
                                            ?>"
                                        >

                                            <?php if ($isDone) : ?>

                                                Tandai Diproses

                                            <?php else : ?>

                                                Set Selesai

                                            <?php endif; ?>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <div class="empty-documents">

                            <i class="fa-regular fa-folder-open"></i>

                            <p>
                                Belum ada berkas yang dilampirkan.
                            </p>

                        </div>

                    <?php endif; ?>

                </div>

            </section>

        </div>


        <!-- =====================================
             RIGHT COLUMN
        ====================================== -->

        <aside class="detail-sidebar">


            <!-- FOTO BUKTI -->

            <section class="detail-card evidence-card">

                <div class="card-title">

                    <h2>
                        Foto Bukti Pengumpulan
                    </h2>

                </div>

                <p class="card-description">
                    Foto bukti pengumpulan berkas fisik
                    ke admin jurusan.
                </p>


                <?php

                $fotoBukti = null;

                foreach ($berkas as $b) {

                    if (! empty($b['bukti_foto'])) {

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
                        class="evidence-image-link"
                    >

                        <img
                            src="<?= base_url(
                                $fotoBukti
                            ) ?>"
                            alt="Bukti Pengumpulan"
                            class="evidence-image"
                        >

                    </a>


                    <a
                        href="<?= base_url(
                            $fotoBukti
                        ) ?>"
                        target="_blank"
                        class="view-image-link"
                    >

                        Klik untuk melihat gambar penuh

                    </a>

                <?php else : ?>

                    <div class="no-evidence">

                        <i class="fa-regular fa-image"></i>

                        <span>
                            Foto bukti belum tersedia.
                        </span>

                    </div>

                <?php endif; ?>

            </section>


            <!-- KEPUTUSAN AKHIR -->

            <section class="detail-card decision-card">

                <div class="card-title">

                    <h2>
                        <i class="fa-solid fa-gavel"></i>
                        Keputusan Akhir
                    </h2>

                </div>


                <!-- FORM UPDATE GLOBAL -->

                <form
                    method="post"
                    action="<?= site_url(
                        'admin/permohonan/' .
                        $permohonan['id_permohonan'] .
                        '/status'
                    ) ?>"
                >

                    <?= csrf_field() ?>


                    <div class="field-block">

                        <label
                            for="status"
                            class="field-label"
                        >
                            Status Permohonan
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="decision-select"
                        >

                            <option
                                value="DIAJUKAN"
                                <?= $statusGlobal === 'DIAJUKAN'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Diajukan
                            </option>

                            <option
                                value="DIPROSES"
                                <?= $statusGlobal === 'DIPROSES'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Diproses
                            </option>

                            <option
                                value="SELESAI"
                                <?= $statusGlobal === 'SELESAI'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Selesai
                            </option>

                            <option
                                value="DIAMBIL"
                                <?= $statusGlobal === 'DIAMBIL'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Diambil
                            </option>

                            <option
                                value="DITOLAK"
                                <?= $statusGlobal === 'DITOLAK'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Ditolak
                            </option>

                        </select>

                    </div>


                    <!-- ALASAN PENOLAKAN -->

                    <div class="field-block">

                        <label
                            for="keterangan_penolakan"
                            class="field-label"
                        >
                            Alasan Penolakan
                        </label>

                        <textarea
                            name="keterangan_penolakan"
                            id="keterangan_penolakan"
                            class="decision-textarea"
                            placeholder="Masukkan alasan jika dokumen ditolak..."
                        ><?= esc(
                            $permohonan[
                                'keterangan_penolakan'
                            ] ?? ''
                        ) ?></textarea>

                    </div>


                    <button
                        type="submit"
                        class="primary-button"
                    >

                        <i class="fa-solid fa-rotate"></i>

                        Update Status Global

                    </button>

                </form>


                <!-- TOLAK CEPAT -->

                <form
                    method="post"
                    action="<?= site_url(
                        'admin/permohonan/' .
                        $permohonan['id_permohonan'] .
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