<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<?php
    $fullName = trim(
        (string) (session('nama_lengkap') ?? 'Mahasiswa')
    );

    $fullName = $fullName !== ''
        ? $fullName
        : 'Mahasiswa';

    $rows = is_array($permohonan ?? null)
        ? $permohonan
        : [];

    $total = count($rows);

    $countDiajukan = 0;
    $countDiproses = 0;
    $countDitolak = 0;
    $countSelesai = 0;
    $countDiambil = 0;

    foreach ($rows as $row) {
        $status = strtoupper(
            trim((string) ($row['nama_status'] ?? ''))
        );

        switch ($status) {
            case 'DIAJUKAN':
                $countDiajukan++;
                break;

            case 'DIPROSES':
                $countDiproses++;
                break;

            case 'DITOLAK':
                $countDitolak++;
                break;

            case 'SELESAI':
                $countSelesai++;
                break;

            case 'DIAMBIL':
                $countDiambil++;
                break;
        }
    }
?>

<style>
    /* =========================================================
       PAGE — PERMOHONAN SAYA
    ========================================================== */

    .requests-page {
        width: 100%;
    }

    /* =========================================================
       HERO
    ========================================================== */

    .requests-hero {
        position: relative;
        overflow: hidden;

        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;

        margin-bottom: 18px;
        padding: 24px 26px;

        border: 1px solid #dce7f7;
        border-radius: 18px;

        background:
            radial-gradient(
                circle at 92% 20%,
                rgba(255,255,255,.18),
                transparent 25%
            ),
            linear-gradient(
                135deg,
                #142f55 0%,
                #245d9d 56%,
                #4f46e5 100%
            );

        color: #fff;

        box-shadow:
            0 14px 32px rgba(23,63,112,.15);
    }

    .requests-hero::after {
        content: "";

        position: absolute;
        width: 210px;
        height: 210px;

        right: -75px;
        bottom: -120px;

        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;

        box-shadow:
            0 0 0 28px rgba(255,255,255,.035),
            0 0 0 56px rgba(255,255,255,.02);
    }

    .requests-hero-copy {
        position: relative;
        z-index: 2;

        max-width: 730px;
    }

    .requests-kicker {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        margin-bottom: 8px;
        padding: 5px 9px;

        border: 1px solid rgba(255,255,255,.15);
        border-radius: 999px;

        background: rgba(255,255,255,.08);

        color: #dbe9fb;

        font-size: 9px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .requests-kicker-dot {
        width: 6px;
        height: 6px;

        border-radius: 50%;
        background: #8bbaff;
        box-shadow: 0 0 0 4px rgba(139,186,255,.11);
    }

    .requests-hero h1 {
        color: #ffffff;

        font-size: clamp(24px, 3.2vw, 31px);
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -.7px;
    }

    .requests-hero p {
        margin-top: 8px;

        color: #d8e5f5;

        font-size: 11.5px;
        line-height: 1.65;
    }

    .requests-hero-action {
        position: relative;
        z-index: 2;
        flex: 0 0 auto;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;

        min-height: 40px;
        padding: 0 14px;

        border-radius: 10px;

        background: #fff;
        color: #173f70;

        font-size: 10.5px;
        font-weight: 800;

        text-decoration: none;

        box-shadow:
            0 8px 18px rgba(0,0,0,.12);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .requests-hero-action:hover {
        background: #f7faff;
        color: #173f70;
        transform: translateY(-1px);

        box-shadow:
            0 11px 22px rgba(0,0,0,.16);
    }

    /* =========================================================
       MINI STATS
    ========================================================== */

    .request-summary {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 11px;

        margin-bottom: 18px;
    }

    .summary-card {
        position: relative;
        overflow: hidden;

        min-height: 88px;

        padding: 14px;

        border: 1px solid #e2e8f0;
        border-radius: 13px;

        background: #fff;

        box-shadow:
            0 3px 12px rgba(20,46,82,.04);
    }

    .summary-card-label {
        color: #7a8799;
        font-size: 9px;
        font-weight: 700;
        line-height: 1.4;
    }

    .summary-card-value {
        margin-top: 8px;

        color: #172033;

        font-size: 22px;
        font-weight: 800;
        line-height: 1;

        letter-spacing: -.5px;
    }

    .summary-card-bar {
        position: absolute;
        left: 0;
        bottom: 0;

        width: 100%;
        height: 3px;

        background: #2563eb;
    }

    .summary-card.diproses .summary-card-bar {
        background: #4f46e5;
    }

    .summary-card.ditolak .summary-card-bar {
        background: #dc2626;
    }

    .summary-card.selesai .summary-card-bar {
        background: #059669;
    }

    .summary-card.diambil .summary-card-bar {
        background: #7c3aed;
    }

    /* =========================================================
       TOOLBAR
    ========================================================== */

    .requests-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;

        margin-bottom: 12px;
    }

    .requests-heading h2 {
        color: #172033;
        font-size: 15px;
        font-weight: 800;
    }

    .requests-heading p {
        margin-top: 3px;
        color: #98a2b3;
        font-size: 9.5px;
        line-height: 1.5;
    }

    .requests-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 9px;

        border: 1px solid #dce5f2;
        border-radius: 999px;

        background: #fff;

        color: #667085;

        font-size: 9.5px;
        font-weight: 700;
    }

    .requests-count strong {
        color: #2563eb;
        font-weight: 800;
    }

    /* =========================================================
       TABLE CARD
    ========================================================== */

    .requests-card {
        overflow: hidden;

        border:
            1px solid #e2e8f0;

        border-radius: 16px;

        background: #fff;

        box-shadow:
            0 4px 15px rgba(20,46,82,.045);
    }

    .requests-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .requests-table {
        width: 100%;
        min-width: 860px;

        border-collapse: collapse;
        border-spacing: 0;
    }

    .requests-table th {
        padding: 11px 17px;

        background:
            linear-gradient(
                180deg,
                #f8faff 0%,
                #f6f8fc 100%
            );

        border-bottom: 1px solid #e6ebf2;

        color: #7b8799;

        font-size: 9px;
        font-weight: 800;
        letter-spacing: .05em;

        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .requests-table td {
        padding: 14px 17px;

        border-bottom: 1px solid #eef2f6;

        color: #475467;

        font-size: 10.5px;
        vertical-align: middle;
    }

    .requests-table tbody tr {
        transition: background .15s ease;
    }

    .requests-table tbody tr:hover {
        background: #fbfdff;
    }

    .requests-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* =========================================================
       DATA CELLS
    ========================================================== */

    .request-code {
        color: #173f70;
        font-size: 10.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .request-date-cell {
        color: #7b8799;
        white-space: nowrap;
    }

    .request-destination {
        max-width: 190px;

        color: #172033;
        font-weight: 700;
        line-height: 1.45;
    }

    .request-purpose {
        max-width: 300px;

        color: #667085;
        line-height: 1.5;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 9px;

        border-radius: 999px;

        font-size: 9px;
        font-weight: 800;

        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-diajukan {
        color: #2563eb;
        background: #eaf1ff;
    }

    .status-diproses {
        color: #4f46e5;
        background: #eeecff;
    }

    .status-ditolak {
        color: #dc2626;
        background: #ffebeb;
    }

    .status-selesai {
        color: #059669;
        background: #e8f8f2;
    }

    .status-diambil {
        color: #6d28d9;
        background: #f0ebff;
    }

    /* =========================================================
       ACTION
    ========================================================== */

    .detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        min-height: 30px;
        padding: 0 9px;

        border: 1px solid #dce5f2;
        border-radius: 8px;

        background: #fff;
        color: #475467;

        font-size: 9.5px;
        font-weight: 800;

        text-decoration: none;

        transition:
            border-color .15s ease,
            color .15s ease,
            background .15s ease;
    }

    .detail-btn:hover {
        color: #1d4ed8;
        border-color: #bdd0ef;
        background: #f4f8ff;
    }

    /* =========================================================
       EMPTY
    ========================================================== */

    .requests-empty {
        padding: 52px 20px;
        text-align: center;
    }

    .requests-empty-icon {
        width: 58px;
        height: 58px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin: 0 auto 13px;

        border-radius: 16px;

        background:
            linear-gradient(
                135deg,
                #eef4ff,
                #f1efff
            );

        color: #6582b6;
    }

    .requests-empty h3 {
        color: #344054;
        font-size: 13px;
        font-weight: 800;
    }

    .requests-empty p {
        max-width: 420px;

        margin: 6px auto 0;

        color: #98a2b3;

        font-size: 10px;
        line-height: 1.65;
    }

    .requests-empty-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        margin-top: 14px;
        min-height: 34px;
        padding: 0 12px;

        border-radius: 9px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );

        font-size: 9.5px;
        font-weight: 800;

        text-decoration: none;

        box-shadow:
            0 7px 16px rgba(37,99,235,.14);
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 1100px) {
        .request-summary {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .requests-hero {
            align-items: flex-start;
            flex-direction: column;
        }

        .requests-hero-action {
            width: 100%;
        }

        .request-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .requests-toolbar {
            align-items: flex-start;
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .request-summary {
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .summary-card {
            min-height: 82px;
            padding: 12px;
        }

        .summary-card-value {
            font-size: 20px;
        }

        .requests-hero {
            padding: 20px;
            border-radius: 16px;
        }

        .requests-hero h1 {
            font-size: 23px;
        }
    }
</style>

<div class="requests-page">

    <!-- =====================================================
         HERO
    ====================================================== -->
    <section class="requests-hero">

        <div class="requests-hero-copy">

            <div class="requests-kicker">
                <span class="requests-kicker-dot"></span>
                Riwayat Pengajuan
            </div>

            <h1>
                Permohonan Saya
            </h1>

            <p>
                Kelola dan pantau seluruh permohonan tanda tangan
                yang pernah kamu ajukan melalui JTI Signature.
            </p>

        </div>

        <a
            href="<?= site_url('mahasiswa/permohonan/create') ?>"
            class="requests-hero-action"
        >
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>

            Ajukan Baru
        </a>

    </section>

    <!-- =====================================================
         SUMMARY
    ====================================================== -->
    <section class="request-summary">

        <div class="summary-card">
            <div class="summary-card-label">Total</div>
            <div class="summary-card-value"><?= esc($total) ?></div>
            <div class="summary-card-bar"></div>
        </div>

        <div class="summary-card">
            <div class="summary-card-label">Diajukan</div>
            <div class="summary-card-value"><?= esc($countDiajukan) ?></div>
            <div class="summary-card-bar"></div>
        </div>

        <div class="summary-card diproses">
            <div class="summary-card-label">Diproses</div>
            <div class="summary-card-value"><?= esc($countDiproses) ?></div>
            <div class="summary-card-bar"></div>
        </div>

        <div class="summary-card ditolak">
            <div class="summary-card-label">Ditolak</div>
            <div class="summary-card-value"><?= esc($countDitolak) ?></div>
            <div class="summary-card-bar"></div>
        </div>

        <div class="summary-card selesai">
            <div class="summary-card-label">Selesai / Diambil</div>
            <div class="summary-card-value">
                <?= esc($countSelesai + $countDiambil) ?>
            </div>
            <div class="summary-card-bar"></div>
        </div>

    </section>

    <!-- =====================================================
         TOOLBAR
    ====================================================== -->
    <div class="requests-toolbar">

        <div class="requests-heading">

            <h2>
                Semua Pengajuan
            </h2>

            <p>
                Daftar permohonan kamu, dari yang terbaru hingga terlama.
            </p>

        </div>

        <div class="requests-count">
            Menampilkan
            <strong><?= esc($total) ?></strong>
            permohonan
        </div>

    </div>

    <!-- =====================================================
         TABLE
    ====================================================== -->
    <section class="requests-card">

        <?php if (empty($rows)): ?>

            <div class="requests-empty">

                <div class="requests-empty-icon">

                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="8" y1="13" x2="16" y2="13"></line>
                        <line x1="8" y1="17" x2="13" y2="17"></line>
                    </svg>

                </div>

                <h3>
                    Belum ada permohonan
                </h3>

                <p>
                    Saat ini kamu belum memiliki pengajuan.
                    Buat permohonan baru untuk memulai proses layanan akademik.
                </p>

                <a
                    href="<?= site_url('mahasiswa/permohonan/create') ?>"
                    class="requests-empty-btn"
                >
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>

                    Ajukan Permohonan
                </a>

            </div>

        <?php else: ?>

            <div class="requests-table-wrap">

                <table class="requests-table">

                    <thead>
                        <tr>
                            <th>ID Permohonan</th>
                            <th>Tanggal</th>
                            <th>Tujuan</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($rows as $row): ?>

                        <?php
                            $idPermohonan = (int) (
                                $row['id_permohonan'] ?? 0
                            );

                            $statusRaw = strtoupper(
                                trim(
                                    (string) (
                                        $row['nama_status']
                                        ?? ''
                                    )
                                )
                            );

                            $statusClass =
                                'status-diajukan';

                            $statusLabel =
                                'Diajukan';

                            if ($statusRaw === 'DIPROSES') {
                                $statusClass =
                                    'status-diproses';

                                $statusLabel =
                                    'Diproses';
                            } elseif ($statusRaw === 'DITOLAK') {
                                $statusClass =
                                    'status-ditolak';

                                $statusLabel =
                                    'Ditolak';
                            } elseif ($statusRaw === 'SELESAI') {
                                $statusClass =
                                    'status-selesai';

                                $statusLabel =
                                    'Selesai';
                            } elseif ($statusRaw === 'DIAMBIL') {
                                $statusClass =
                                    'status-diambil';

                                $statusLabel =
                                    'Diambil';
                            }

                            $requestCode =
                                '#REQ-' .
                                str_pad(
                                    (string) $idPermohonan,
                                    4,
                                    '0',
                                    STR_PAD_LEFT
                                );

                            $dateDisplay =
                                ! empty(
                                    $row['tanggal_pengajuan']
                                )
                                ? date(
                                    'd M Y',
                                    strtotime(
                                        $row['tanggal_pengajuan']
                                    )
                                )
                                : '-';
                        ?>

                        <tr>

                            <td>
                                <span class="request-code">
                                    <?= esc($requestCode) ?>
                                </span>
                            </td>

                            <td>
                                <span class="request-date-cell">
                                    <?= esc($dateDisplay) ?>
                                </span>
                            </td>

                            <td>
                                <div class="request-destination">
                                    <?= esc(
                                        $row['nama_tujuan']
                                        ?? '-'
                                    ) ?>
                                </div>
                            </td>

                            <td>
                                <div class="request-purpose">
                                    <?= esc(
                                        $row['keperluan']
                                        ?? '-'
                                    ) ?>
                                </div>
                            </td>

                            <td>
                                <span
                                    class="status-chip <?= esc($statusClass) ?>"
                                >
                                    <span class="status-dot"></span>
                                    <?= esc($statusLabel) ?>
                                </span>
                            </td>

                            <td>

                                <?php if ($idPermohonan > 0): ?>

                                    <a
                                        href="<?= site_url(
                                            'mahasiswa/permohonan/' .
                                            $idPermohonan
                                        ) ?>"
                                        class="detail-btn"
                                    >
                                        Lihat Detail
                                        <span>→</span>
                                    </a>

                                <?php else: ?>

                                    <span
                                        style="color:#98a2b3;"
                                    >
                                        -
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </section>

</div>

<?= $this->endSection() ?>
