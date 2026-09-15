<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<?php
    /*
     * =========================================================
     * DATA DASHBOARD
     * =========================================================
     *
     * Controller Mahasiswa menyediakan:
     * - $permohonan
     * - $total
     * - $totalDiproses
     * - $totalSiapDiambil
     *
     * View juga dibuat toleran terhadap struktur $stats
     * apabila nanti dipakai kembali.
     */

    $fullName = trim(
        (string) (
            session('nama_lengkap')
            ?? 'Mahasiswa'
        )
    );

    $fullName = $fullName !== ''
        ? $fullName
        : 'Mahasiswa';

    $nameParts = preg_split(
        '/\s+/',
        $fullName
    );

    $firstName = $nameParts[0] ?? 'Mahasiswa';

    $permohonanRows = is_array(
        $permohonan ?? null
    )
        ? $permohonan
        : [];

    $totalPermohonan = isset($stats['total'])
        ? (int) $stats['total']
        : (int) ($total ?? count($permohonanRows));

    $totalDiprosesValue = isset($stats['diproses'])
        ? (int) $stats['diproses']
        : (int) ($totalDiproses ?? 0);

    $totalSiapDiambilValue = isset($stats['siap_diambil'])
        ? (int) $stats['siap_diambil']
        : (int) ($totalSiapDiambil ?? 0);

    $totalDiajukanValue = isset($stats['diajukan'])
        ? (int) $stats['diajukan']
        : 0;

    if (! isset($stats['diajukan'])) {
        foreach ($permohonanRows as $row) {
            if ((int) ($row['id_status'] ?? 0) === 1) {
                $totalDiajukanValue++;
            }
        }
    }

    /*
     * Ambil maksimal 6 permohonan terbaru.
     * Data sudah diurutkan descending dari controller.
     */
    $latestRows = array_slice(
        $permohonanRows,
        0,
        6
    );
?>

<style>
    /* =========================================================
       DASHBOARD — MODERN ACADEMIC
    ========================================================== */

    .dash-shell {
        width: 100%;
    }

    /* =========================================================
       HERO
    ========================================================== */

    .dash-hero {
        position: relative;
        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;

        margin-bottom: 24px;
        padding: 28px 30px;

        border-radius: 20px;
        border: 1px solid #dbe7f7;

        background:
            radial-gradient(
                circle at 90% 15%,
                rgba(255,255,255,.20),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #173f70 0%,
                #245d9d 52%,
                #4f46e5 100%
            );

        color: #ffffff;

        box-shadow:
            0 16px 34px rgba(23,63,112,.18);
    }

    .dash-hero::before {
        content: "";
        position: absolute;

        width: 220px;
        height: 220px;

        right: -80px;
        bottom: -105px;

        border-radius: 50%;

        border: 1px solid rgba(255,255,255,.16);
        box-shadow:
            0 0 0 28px rgba(255,255,255,.035),
            0 0 0 56px rgba(255,255,255,.025);
    }

    .dash-hero-content {
        position: relative;
        z-index: 2;

        max-width: 700px;
    }

    .dash-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        margin-bottom: 10px;
        padding: 5px 10px;

        border: 1px solid rgba(255,255,255,.16);
        border-radius: 999px;

        background: rgba(255,255,255,.09);

        color: #dceaff;

        font-size: 9.5px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .dash-eyebrow-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #86b8ff;
        box-shadow: 0 0 0 4px rgba(134,184,255,.12);
    }

    .dash-hero h1 {
        margin: 0;

        color: #ffffff;

        font-size: clamp(25px, 3.4vw, 34px);
        font-weight: 800;
        line-height: 1.15;
        letter-spacing: -.8px;
    }

    .dash-hero p {
        max-width: 650px;
        margin-top: 9px;

        color: #d6e5f7;

        font-size: 12.5px;
        line-height: 1.7;
    }

    .dash-hero-actions {
        position: relative;
        z-index: 2;
        flex: 0 0 auto;

        display: flex;
        align-items: center;
    }

    .dash-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        min-height: 42px;
        padding: 0 16px;

        border: none;
        border-radius: 11px;

        background: #ffffff;
        color: #173f70;

        font-size: 11.5px;
        font-weight: 800;

        text-decoration: none;

        box-shadow:
            0 8px 18px rgba(4,26,54,.15);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .dash-primary-btn:hover {
        background: #f6f9ff;
        color: #173f70;

        transform: translateY(-1px);

        box-shadow:
            0 11px 22px rgba(4,26,54,.20);
    }

    /* =========================================================
       STAT CARDS
    ========================================================== */

    .dash-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;

        margin-bottom: 24px;
    }

    .dash-stat {
        position: relative;
        overflow: hidden;

        min-height: 135px;

        padding: 18px;

        border: 1px solid #e2e8f0;
        border-radius: 16px;

        background: #ffffff;

        box-shadow:
            0 4px 15px rgba(20,46,82,.045);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .dash-stat:hover {
        transform: translateY(-2px);

        border-color: #d7e2f2;

        box-shadow:
            0 13px 28px rgba(20,46,82,.075);
    }

    .dash-stat::after {
        content: "";

        position: absolute;

        left: 0;
        right: 0;
        bottom: 0;

        height: 3px;

        background: #2563eb;
        opacity: .92;
    }

    .dash-stat.diproses::after {
        background: #4f46e5;
    }

    .dash-stat.diajukan::after {
        background: #0ea5e9;
    }

    .dash-stat.siap::after {
        background: #059669;
    }

    .dash-stat-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .dash-stat-label {
        color: #667085;
        font-size: 10.5px;
        font-weight: 700;
        line-height: 1.4;
    }

    .dash-stat-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 11px;

        background: #eaf1ff;
        color: #2563eb;
    }

    .dash-stat.diproses .dash-stat-icon {
        background: #eeecff;
        color: #4f46e5;
    }

    .dash-stat.diajukan .dash-stat-icon {
        background: #e7f6fe;
        color: #0284c7;
    }

    .dash-stat.siap .dash-stat-icon {
        background: #e8f8f2;
        color: #059669;
    }

    .dash-stat-value {
        margin-top: 18px;

        color: #172033;

        font-size: 29px;
        font-weight: 800;
        line-height: 1;

        letter-spacing: -.8px;
    }

    .dash-stat-caption {
        margin-top: 7px;

        color: #98a2b3;

        font-size: 9.5px;
        font-weight: 500;
    }

    /* =========================================================
       LOWER GRID
    ========================================================== */

    .dash-content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 300px;
        gap: 18px;
        align-items: start;
    }

    /* =========================================================
       REQUEST CARD
    ========================================================== */

    .dash-section {
        overflow: hidden;

        border:
            1px solid #e2e8f0;

        border-radius: 16px;

        background: #ffffff;

        box-shadow:
            0 4px 15px rgba(20,46,82,.045);
    }

    .dash-section-head {
        min-height: 71px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 17px 19px;

        border-bottom: 1px solid #edf1f6;
    }

    .dash-section-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dash-section-accent {
        width: 4px;
        height: 31px;

        border-radius: 999px;

        background:
            linear-gradient(
                180deg,
                #2563eb,
                #4f46e5
            );
    }

    .dash-section-title {
        color: #172033;
        font-size: 14px;
        font-weight: 800;
    }

    .dash-section-subtitle {
        margin-top: 3px;

        color: #98a2b3;

        font-size: 9.5px;
        line-height: 1.4;
    }

    .dash-view-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        color: #2563eb;

        font-size: 10px;
        font-weight: 800;

        text-decoration: none;
        white-space: nowrap;
    }

    .dash-view-all:hover {
        color: #1d4ed8;
    }

    /* =========================================================
       TABLE
    ========================================================== */

    .dash-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .dash-table {
        width: 100%;
        min-width: 730px;

        border-collapse: collapse;
        border-spacing: 0;
    }

    .dash-table th {
        padding: 11px 17px;

        background: #f8faff;

        border-bottom: 1px solid #edf1f6;

        color: #7b8799;

        font-size: 9px;
        font-weight: 800;
        letter-spacing: .04em;

        text-align: left;
        text-transform: uppercase;

        white-space: nowrap;
    }

    .dash-table td {
        padding: 14px 17px;

        border-bottom: 1px solid #f0f3f7;

        color: #344054;

        font-size: 10.5px;
        line-height: 1.45;

        vertical-align: middle;
    }

    .dash-table tbody tr {
        transition: background .15s ease;
    }

    .dash-table tbody tr:hover {
        background: #fbfdff;
    }

    .dash-table tbody tr:last-child td {
        border-bottom: none;
    }

    .request-id {
        color: #173f70;
        font-size: 10.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .request-date {
        color: #7b8799;
        white-space: nowrap;
    }

    .request-purpose {
        max-width: 170px;

        color: #172033;
        font-weight: 700;

        white-space: normal;
    }

    .request-need {
        max-width: 270px;

        color: #667085;
        line-height: 1.5;

        white-space: normal;
    }

    /* =========================================================
       STATUS
    ========================================================== */

    .request-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 6px 9px;

        border-radius: 999px;

        font-size: 9px;
        font-weight: 800;

        white-space: nowrap;
    }

    .request-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-diajukan {
        background: #eaf1ff;
        color: #2563eb;
    }

    .status-diproses {
        background: #eeecff;
        color: #4f46e5;
    }

    .status-ditolak {
        background: #ffebeb;
        color: #dc2626;
    }

    .status-selesai {
        background: #e8f8f2;
        color: #059669;
    }

    .status-diambil {
        background: #eef0ff;
        color: #5148d9;
    }

    .request-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;

        min-height: 30px;
        padding: 0 9px;

        border: 1px solid #dce5f1;
        border-radius: 8px;

        background: #ffffff;
        color: #475467;

        font-size: 9.5px;
        font-weight: 800;

        text-decoration: none;

        transition:
            background .15s ease,
            color .15s ease,
            border-color .15s ease;
    }

    .request-action:hover {
        color: #1d4ed8;
        border-color: #bfd1f2;
        background: #f5f8ff;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================== */

    .dash-empty {
        padding: 46px 24px;

        text-align: center;
    }

    .dash-empty-icon {
        width: 56px;
        height: 56px;

        margin: 0 auto 13px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background: #f1f5fb;
        color: #9aa8bb;
    }

    .dash-empty h3 {
        color: #344054;
        font-size: 13px;
        font-weight: 800;
    }

    .dash-empty p {
        max-width: 390px;
        margin: 6px auto 0;

        color: #98a2b3;

        font-size: 10.5px;
        line-height: 1.6;
    }

    .dash-empty-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        margin-top: 14px;
        padding: 9px 13px;

        border-radius: 9px;

        background:
            linear-gradient(
                135deg,
                #2563eb,
                #4f46e5
            );

        color: #ffffff;

        font-size: 10px;
        font-weight: 800;

        text-decoration: none;

        box-shadow:
            0 7px 16px rgba(37,99,235,.15);
    }

    /* =========================================================
       QUICK SUMMARY
    ========================================================== */

    .dash-side-stack {
        display: grid;
        gap: 18px;
    }

    .dash-summary {
        padding: 19px;
    }

    .dash-side-title {
        color: #172033;
        font-size: 13px;
        font-weight: 800;
    }

    .dash-side-description {
        margin-top: 4px;

        color: #98a2b3;

        font-size: 9.5px;
        line-height: 1.5;
    }

    .summary-list {
        margin-top: 17px;

        display: grid;
        gap: 9px;
    }

    .summary-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;

        padding: 10px 11px;

        border: 1px solid #edf1f6;
        border-radius: 10px;

        background: #fbfcfe;
    }

    .summary-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;

        background: #2563eb;
    }

    .summary-dot.diproses {
        background: #4f46e5;
    }

    .summary-dot.siap {
        background: #059669;
    }

    .summary-label {
        color: #667085;
        font-size: 10px;
        font-weight: 600;
    }

    .summary-value {
        color: #172033;
        font-size: 12px;
        font-weight: 800;
    }

    /* =========================================================
       QUICK ACTION
    ========================================================== */

    .dash-quick {
        padding: 19px;

        background:
            linear-gradient(
                160deg,
                #f8fbff,
                #eef3ff
            );
    }

    .quick-action {
        display: flex;
        align-items: center;
        gap: 10px;

        margin-top: 14px;
        padding: 11px;

        border: 1px solid #dce7fa;
        border-radius: 11px;

        background: #ffffff;

        text-decoration: none;

        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease;
    }

    .quick-action:hover {
        transform: translateY(-1px);

        border-color: #c7d7f3;

        box-shadow:
            0 8px 16px rgba(37,99,235,.07);
    }

    .quick-action-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #eaf1ff;
        color: #2563eb;
    }

    .quick-action-title {
        color: #172033;
        font-size: 10.5px;
        font-weight: 800;
    }

    .quick-action-text {
        margin-top: 2px;
        color: #98a2b3;
        font-size: 9px;
        line-height: 1.4;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 1180px) {

        .dash-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dash-content-grid {
            grid-template-columns: 1fr;
        }

        .dash-side-stack {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {

        .dash-hero {
            align-items: flex-start;
            flex-direction: column;
            padding: 22px;
        }

        .dash-primary-btn {
            width: 100%;
        }

        .dash-hero-actions {
            width: 100%;
        }

        .dash-stats {
            grid-template-columns: 1fr 1fr;
            gap: 11px;
        }

        .dash-stat {
            min-height: 125px;
            padding: 15px;
        }

        .dash-stat-value {
            font-size: 25px;
        }

        .dash-side-stack {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 500px) {

        .dash-hero {
            border-radius: 16px;
        }

        .dash-hero h1 {
            font-size: 24px;
        }

        .dash-hero p {
            font-size: 11.5px;
        }

        .dash-stats {
            grid-template-columns: 1fr;
        }

        .dash-section-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .dash-view-all {
            align-self: flex-start;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .dash-stat,
        .dash-primary-btn,
        .request-action,
        .quick-action {
            transition: none !important;
        }
    }
</style>

<div class="dash-shell">

    <!-- =====================================================
         HERO
    ====================================================== -->
    <section class="dash-hero">

        <div class="dash-hero-content">

            <div class="dash-eyebrow">
                <span class="dash-eyebrow-dot"></span>
                JTI Academic Services
            </div>

            <h1>
                Selamat datang, <?= esc($firstName) ?> 👋
            </h1>

            <p>
                Pantau status permohonan tanda tanganmu,
                lihat riwayat pengajuan, dan ajukan permohonan
                baru melalui satu dashboard.
            </p>

        </div>

        <div class="dash-hero-actions">

            <a
                href="<?= site_url('mahasiswa/permohonan/create') ?>"
                class="dash-primary-btn"
            >
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>

                Ajukan Permohonan
            </a>

        </div>

    </section>

    <!-- =====================================================
         STATISTICS
    ====================================================== -->
    <section class="dash-stats">

        <!-- TOTAL -->
        <div class="dash-stat">

            <div class="dash-stat-head">

                <div class="dash-stat-label">
                    Total Permohonan
                </div>

                <div class="dash-stat-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="8" y1="13" x2="16" y2="13"></line>
                        <line x1="8" y1="17" x2="13" y2="17"></line>
                    </svg>
                </div>

            </div>

            <div class="dash-stat-value">
                <?= esc($totalPermohonan) ?>
            </div>

            <div class="dash-stat-caption">
                Semua pengajuanmu
            </div>

        </div>

        <!-- DIAJUKAN -->
        <div class="dash-stat diajukan">

            <div class="dash-stat-head">

                <div class="dash-stat-label">
                    Menunggu Pemeriksaan
                </div>

                <div class="dash-stat-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 7v5l3 2"></path>
                    </svg>
                </div>

            </div>

            <div class="dash-stat-value">
                <?= esc($totalDiajukanValue) ?>
            </div>

            <div class="dash-stat-caption">
                Status Diajukan
            </div>

        </div>

        <!-- DIPROSES -->
        <div class="dash-stat diproses">

            <div class="dash-stat-head">

                <div class="dash-stat-label">
                    Sedang Diproses
                </div>

                <div class="dash-stat-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v4"></path>
                        <path d="M12 18v4"></path>
                        <path d="M4.93 4.93l2.83 2.83"></path>
                        <path d="M16.24 16.24l2.83 2.83"></path>
                        <path d="M2 12h4"></path>
                        <path d="M18 12h4"></path>
                        <path d="M4.93 19.07l2.83-2.83"></path>
                        <path d="M16.24 7.76l2.83-2.83"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>

            </div>

            <div class="dash-stat-value">
                <?= esc($totalDiprosesValue) ?>
            </div>

            <div class="dash-stat-caption">
                Dalam proses admin
            </div>

        </div>

        <!-- SIAP DIAMBIL -->
        <div class="dash-stat siap">

            <div class="dash-stat-head">

                <div class="dash-stat-label">
                    Siap Diambil
                </div>

                <div class="dash-stat-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3h12v18H6z"></path>
                        <path d="M9 7h6"></path>
                        <path d="M9 11h6"></path>
                        <path d="M9 15h4"></path>
                    </svg>
                </div>

            </div>

            <div class="dash-stat-value">
                <?= esc($totalSiapDiambilValue) ?>
            </div>

            <div class="dash-stat-caption">
                Selesai / siap diambil
            </div>

        </div>

    </section>

    <!-- =====================================================
         MAIN GRID
    ====================================================== -->
    <div class="dash-content-grid">

        <!-- =================================================
             REQUESTS
        ================================================== -->
        <section class="dash-section">

            <div class="dash-section-head">

                <div class="dash-section-title-wrap">

                    <div class="dash-section-accent"></div>

                    <div>
                        <div class="dash-section-title">
                            Permohonan Terbaru
                        </div>

                        <div class="dash-section-subtitle">
                            Enam pengajuan terakhir yang tercatat di sistem
                        </div>
                    </div>

                </div>

                <a
                    href="<?= site_url('mahasiswa/permohonan') ?>"
                    class="dash-view-all"
                >
                    Lihat Semua
                    <span>→</span>
                </a>

            </div>

            <?php if (empty($latestRows)): ?>

                <div class="dash-empty">

                    <div class="dash-empty-icon">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="8" y1="13" x2="16" y2="13"></line>
                            <line x1="8" y1="17" x2="12" y2="17"></line>
                        </svg>

                    </div>

                    <h3>
                        Belum ada permohonan
                    </h3>

                    <p>
                        Kamu belum memiliki pengajuan tanda tangan.
                        Mulai pengajuan pertamamu dari sini.
                    </p>

                    <a
                        href="<?= site_url('mahasiswa/permohonan/create') ?>"
                        class="dash-empty-btn"
                    >
                        Ajukan Permohonan
                    </a>

                </div>

            <?php else: ?>

                <div class="dash-table-wrap">

                    <table class="dash-table">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Tujuan</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($latestRows as $item): ?>

                            <?php
                                $statusRaw = strtoupper(
                                    trim(
                                        (string) (
                                            $item['nama_status']
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

                                $idPermohonan =
                                    (int) (
                                        $item['id_permohonan']
                                        ?? 0
                                    );

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
                                        $item['tanggal_pengajuan']
                                    )
                                    ? date(
                                        'd M Y',
                                        strtotime(
                                            $item['tanggal_pengajuan']
                                        )
                                    )
                                    : '-';
                            ?>

                            <tr>

                                <td>
                                    <span class="request-id">
                                        <?= esc($requestCode) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="request-date">
                                        <?= esc($dateDisplay) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="request-purpose">
                                        <?= esc(
                                            $item['nama_tujuan']
                                            ?? '-'
                                        ) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="request-need">
                                        <?= esc(
                                            $item['keperluan']
                                            ?? '-'
                                        ) ?>
                                    </div>
                                </td>

                                <td>

                                    <span
                                        class="request-status <?= esc($statusClass) ?>"
                                    >
                                        <span class="request-status-dot"></span>
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
                                            class="request-action"
                                        >
                                            Detail
                                            <span>→</span>
                                        </a>

                                    <?php else: ?>

                                        <span
                                            style="color:#98a2b3;font-size:10px;"
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

        <!-- =================================================
             SIDEBAR SUMMARY
        ================================================== -->
        <aside class="dash-side-stack">

            <!-- SUMMARY -->
            <section class="dash-section dash-summary">

                <div class="dash-side-title">
                    Ringkasan Status
                </div>

                <div class="dash-side-description">
                    Gambaran cepat posisi pengajuanmu saat ini.
                </div>

                <div class="summary-list">

                    <div class="summary-item">

                        <div class="summary-left">
                            <span class="summary-dot"></span>

                            <span class="summary-label">
                                Diajukan
                            </span>
                        </div>

                        <span class="summary-value">
                            <?= esc($totalDiajukanValue) ?>
                        </span>

                    </div>

                    <div class="summary-item">

                        <div class="summary-left">
                            <span class="summary-dot diproses"></span>

                            <span class="summary-label">
                                Diproses
                            </span>
                        </div>

                        <span class="summary-value">
                            <?= esc($totalDiprosesValue) ?>
                        </span>

                    </div>

                    <div class="summary-item">

                        <div class="summary-left">
                            <span class="summary-dot siap"></span>

                            <span class="summary-label">
                                Siap Diambil
                            </span>
                        </div>

                        <span class="summary-value">
                            <?= esc($totalSiapDiambilValue) ?>
                        </span>

                    </div>

                </div>

            </section>

            <!-- QUICK ACTION -->
            <section class="dash-section dash-quick">

                <div class="dash-side-title">
                    Akses Cepat
                </div>

                <div class="dash-side-description">
                    Menu yang paling sering digunakan.
                </div>

                <a
                    href="<?= site_url('mahasiswa/permohonan/create') ?>"
                    class="quick-action"
                >

                    <div class="quick-action-icon">

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="3"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>

                    </div>

                    <div>

                        <div class="quick-action-title">
                            Ajukan Baru
                        </div>

                        <div class="quick-action-text">
                            Buat permohonan tanda tangan
                        </div>

                    </div>

                    <span style="margin-left:auto;color:#98a2b3;font-size:12px;">
                        →
                    </span>

                </a>

                <a
                    href="<?= site_url('mahasiswa/permohonan') ?>"
                    class="quick-action"
                >

                    <div
                        class="quick-action-icon"
                        style="background:#eeecff;color:#4f46e5;"
                    >

                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>

                    </div>

                    <div>

                        <div class="quick-action-title">
                            Permohonan Saya
                        </div>

                        <div class="quick-action-text">
                            Lihat seluruh riwayat pengajuan
                        </div>

                    </div>

                    <span style="margin-left:auto;color:#98a2b3;font-size:12px;">
                        →
                    </span>

                </a>

            </section>

        </aside>

    </div>

</div>

<?= $this->endSection() ?>
