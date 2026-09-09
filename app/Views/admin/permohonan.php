<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Semua Permohonan - JTI Signature
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link
    rel="stylesheet"
    href="<?= base_url('assets/css/admin/permohonan.css') ?>"
>

<div class="requests-page">

    <!-- ==================================================
         PAGE HEADING
    =================================================== -->

    <div class="requests-top">

        <div class="requests-title">

            <h1>
                Semua Permohonan
            </h1>

            <p>
                Kelola semua pengajuan tanda tangan mahasiswa
            </p>

        </div>


        <!-- ==================================================
             SEARCH / FILTER
        =================================================== -->

        <form
            method="get"
            action="<?= site_url('admin/permohonan') ?>"
            class="requests-controls"
        >

            <div class="search-input">

                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="text"
                    name="keyword"
                    value="<?= esc($keyword ?? '') ?>"
                    placeholder="Cari permohonan..."
                    autocomplete="off"
                >

            </div>


            <div class="filter-input">

                <i class="fa-solid fa-sliders"></i>

                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="1"
                        <?= ($statusFilter ?? '') === '1'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Diajukan
                    </option>

                    <option
                        value="2"
                        <?= ($statusFilter ?? '') === '2'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Diproses
                    </option>

                    <option
                        value="3"
                        <?= ($statusFilter ?? '') === '3'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Ditolak
                    </option>

                    <option
                        value="4"
                        <?= ($statusFilter ?? '') === '4'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Selesai
                    </option>

                    <option
                        value="5"
                        <?= ($statusFilter ?? '') === '5'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Diambil
                    </option>

                </select>

                <i class="fa-solid fa-chevron-down"></i>

            </div>


            <button
                type="submit"
                class="btn-search"
            >

                <i class="fa-solid fa-magnifying-glass"></i>

                Cari

            </button>


            <?php if (
                ! empty($keyword) ||
                ! empty($statusFilter)
            ) : ?>

                <a
                    href="<?= site_url('admin/permohonan') ?>"
                    class="btn-reset"
                >
                    Reset
                </a>

            <?php endif; ?>

        </form>

    </div>


    <!-- ==================================================
         MAIN CARD
    =================================================== -->

    <div class="requests-card">

        <!-- CARD HEADER -->

        <div class="card-toolbar">

            <div>

                <h2>
                    Daftar Permohonan
                </h2>

                <span>
                    Menampilkan
                    <strong>
                        <?= count($permohonan) ?>
                    </strong>
                    permohonan
                </span>

            </div>


            <div class="total-counter">

                <span>
                    TOTAL
                </span>

                <strong>
                    <?= count($permohonan) ?>
                </strong>

            </div>

        </div>


        <?php if (! empty($permohonan)) : ?>

            <!-- ==================================================
                 TABLE
            =================================================== -->

            <div class="requests-table-wrapper">

                <table class="requests-table">

                    <thead>

                        <tr>

                            <th>ID PERMOHONAN</th>

                            <th>MAHASISWA</th>

                            <th>TUJUAN</th>

                            <th>BERKAS</th>

                            <th>TANGGAL</th>

                            <th>STATUS</th>

                            <th>AKSI</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php foreach ($permohonan as $p) : ?>

                        <?php

                        $status =
                            strtoupper(
                                $p['nama_status']
                            );

                        $statusClass =
                            strtolower(
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

                                    #REQ-<?= str_pad(
                                        $p['id_permohonan'],
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ) ?>

                                </span>

                            </td>


                            <!-- MAHASISWA -->

                            <td>

                                <div class="student-cell">

                                    <div class="student-avatar">

                                        <?= strtoupper(
                                            substr(
                                                $p['nama_lengkap'],
                                                0,
                                                1
                                            )
                                        ) ?>

                                    </div>


                                    <div class="student-text">

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

                                    <strong>

                                        <?= esc(
                                            $p['nama_tujuan']
                                        ) ?>

                                    </strong>

                                    <span>
                                        Permohonan tanda tangan
                                    </span>

                                </div>

                            </td>


                            <!-- BERKAS -->

                            <td>

                                <div class="file-cell">

                                    <i class="fa-solid fa-paperclip"></i>

                                    <span>-</span>

                                </div>

                            </td>


                            <!-- TANGGAL -->

                            <td>

                                <?php if ($tanggal) : ?>

                                    <div class="date-cell">

                                        <strong>

                                            <?= esc(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $tanggal
                                                    )
                                                )
                                            ) ?>

                                        </strong>

                                        <span>

                                            <?= esc(
                                                date(
                                                    'H:i',
                                                    strtotime(
                                                        $tanggal
                                                    )
                                                )
                                            ) ?>

                                            WIB

                                        </span>

                                    </div>

                                <?php else : ?>

                                    <span class="muted">
                                        -
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <span
                                    class="
                                        status-badge
                                        <?= esc(
                                            $statusClass
                                        ) ?>
                                    "
                                >

                                    <span></span>

                                    <?= esc(
                                        $status
                                    ) ?>

                                </span>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <a
                                    href="<?= site_url(
                                        'admin/permohonan/' .
                                        $p['id_permohonan']
                                    ) ?>"
                                    class="detail-button"
                                >

                                    Detail

                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <!-- ==================================================
                 FOOTER
            =================================================== -->

            <div class="requests-footer">

                <span>

                    Menampilkan
                    <strong>
                        <?= count($permohonan) ?>
                    </strong>
                    dari
                    <strong>
                        <?= count($permohonan) ?>
                    </strong>
                    permohonan

                </span>


                <div class="pagination">

                    <button disabled>
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <button class="current">
                        1
                    </button>

                    <button disabled>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                </div>

            </div>


        <?php else : ?>

            <!-- ==================================================
                 EMPTY STATE
            =================================================== -->

            <div class="empty-state">

                <div class="empty-icon">

                    <i class="fa-regular fa-folder-open"></i>

                </div>

                <h3>
                    Belum ada permohonan
                </h3>

                <p>

                    <?php if (
                        ! empty($keyword) ||
                        ! empty($statusFilter)
                    ) : ?>

                        Tidak ada permohonan yang sesuai
                        dengan pencarian atau filter.

                    <?php else : ?>

                        Belum ada data permohonan yang
                        tersedia di sistem.

                    <?php endif; ?>

                </p>


                <?php if (
                    ! empty($keyword) ||
                    ! empty($statusFilter)
                ) : ?>

                    <a
                        href="<?= site_url('admin/permohonan') ?>"
                    >
                        Tampilkan Semua
                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

</div>

<?= $this->endSection() ?>