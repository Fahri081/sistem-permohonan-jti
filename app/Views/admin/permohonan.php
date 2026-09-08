<?= $this->extend('admin/layout') ?>


<?= $this->section('title') ?>
Semua Permohonan - JTI Signature
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<!-- CSS khusus halaman Semua Permohonan -->
<link
    rel="stylesheet"
    href="<?= base_url('assets/css/admin/permohonan.css') ?>"
>


<div class="admin-page">

    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="page-header">

        <div>

            <h1>
                Semua Permohonan
            </h1>

            <p>
                Kelola semua pengajuan tanda tangan mahasiswa.
            </p>

        </div>

    </div>


    <!-- =====================================
         FILTER
    ====================================== -->

    <div class="filter-card">

        <form
            method="get"
            action="<?= site_url('admin/permohonan') ?>"
            class="filter-form"
        >

            <!-- SEARCH -->

            <div class="search-box">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="keyword"
                    value="<?= esc($keyword ?? '') ?>"
                    placeholder="Cari permohonan..."
                >

            </div>


            <!-- STATUS -->

            <select
                name="status"
                class="status-filter"
            >

                <option value="">
                    Semua Status
                </option>

                <option
                    value="1"
                    <?= ($statusFilter ?? '') === '1' ? 'selected' : '' ?>
                >
                    Diajukan
                </option>

                <option
                    value="2"
                    <?= ($statusFilter ?? '') === '2' ? 'selected' : '' ?>
                >
                    Ditolak
                </option>

                <option
                    value="3"
                    <?= ($statusFilter ?? '') === '3' ? 'selected' : '' ?>
                >
                    Diproses
                </option>

                <option
                    value="4"
                    <?= ($statusFilter ?? '') === '4' ? 'selected' : '' ?>
                >
                    Selesai
                </option>

                <option
                    value="5"
                    <?= ($statusFilter ?? '') === '5' ? 'selected' : '' ?>
                >
                    Diambil
                </option>

            </select>


            <!-- FILTER BUTTON -->

            <button
                type="submit"
                class="filter-button"
            >

                <i class="fa-solid fa-filter"></i>

                Filter

            </button>


            <!-- RESET -->

            <a
                href="<?= site_url('admin/permohonan') ?>"
                class="reset-button"
            >
                Reset
            </a>

        </form>

    </div>


    <!-- =====================================
         TABLE CARD
    ====================================== -->

    <div class="table-card">

        <!-- HEADER TABLE -->

        <div class="table-header">

            <div>

                <h2>
                    Daftar Permohonan
                </h2>

                <p>
                    Menampilkan
                    <strong>
                        <?= count($permohonan) ?>
                    </strong>
                    permohonan
                </p>

            </div>

        </div>


        <?php if (! empty($permohonan)) : ?>

            <!-- TABLE -->

            <div class="table-wrapper">

                <table class="admin-table">

                    <thead>

                        <tr>

                            <th>
                                ID Permohonan
                            </th>

                            <th>
                                Mahasiswa
                            </th>

                            <th>
                                Tujuan
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php foreach ($permohonan as $p) : ?>

                        <?php

                        $status = strtoupper(
                            $p['nama_status']
                        );

                        $statusClass = strtolower(
                            $status
                        );

                        $tanggal =
                            $p['tanggal_pengajuan']
                            ?? $p['created_at']
                            ?? null;

                        ?>


                        <tr>

                            <!-- ID -->

                            <td>

                                <span class="request-id">

                                    #<?= esc(
                                        $p['id_permohonan']
                                    ) ?>

                                </span>

                            </td>


                            <!-- MAHASISWA -->

                            <td>

                                <div class="student-cell">

                                    <div class="student-avatar">

                                        <i class="fa-solid fa-user"></i>

                                    </div>


                                    <div class="student-data">

                                        <strong>

                                            <?= esc(
                                                $p['nama_lengkap']
                                            ) ?>

                                        </strong>

                                        <span>

                                            <?= esc(
                                                $p['nim']
                                            ) ?>

                                        </span>

                                    </div>

                                </div>

                            </td>


                            <!-- TUJUAN -->

                            <td>

                                <div class="purpose-cell">

                                    <?= esc(
                                        $p['nama_tujuan']
                                    ) ?>

                                </div>

                            </td>


                            <!-- TANGGAL -->

                            <td>

                                <?php if ($tanggal) : ?>

                                    <?= esc(
                                        date(
                                            'd M Y',
                                            strtotime($tanggal)
                                        )
                                    ) ?>

                                <?php else : ?>

                                    -

                                <?php endif; ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <span
                                    class="status-badge <?= esc(
                                        $statusClass
                                    ) ?>"
                                >
                                    <?= esc($status) ?>
                                </span>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <a
                                    href="<?= site_url(
                                        'admin/permohonan/' .
                                        $p['id_permohonan']
                                    ) ?>"
                                    class="detail-button"
                                >

                                    <i class="fa-regular fa-eye"></i>

                                    Detail

                                </a>

                            </td>

                        </tr>


                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


        <?php else : ?>


            <!-- =================================
                 EMPTY STATE
            ================================== -->

            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fa-regular fa-folder-open"></i>

                </div>


                <h3>
                    Belum ada permohonan
                </h3>


                <p>
                    Belum ada data permohonan yang tersedia.
                </p>

            </div>


        <?php endif; ?>

    </div>

</div>


<?= $this->endSection() ?>