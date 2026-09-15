<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Dashboard Admin - JTI Signature
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$statistik = is_array($statistik ?? null) ? $statistik : [];
$aktivitas = is_array($aktivitas ?? null) ? $aktivitas : [];

$total    = (int) ($statistik['total'] ?? 0);
$diajukan = (int) ($statistik['diajukan'] ?? 0);
$diproses = (int) ($statistik['diproses'] ?? 0);
$ditolak  = (int) ($statistik['ditolak'] ?? 0);
$selesai  = (int) ($statistik['selesai'] ?? 0);
$diambil  = (int) ($statistik['diambil'] ?? 0);

$selesaiDiambil = $selesai + $diambil;

$adminName = trim((string) (session('nama_lengkap') ?? session('username') ?? 'Admin'));
if ($adminName === '') {
    $adminName = 'Admin';
}
$firstName = explode(' ', $adminName)[0];

$statusMeta = [
    'DIAJUKAN' => [
        'label' => 'Diajukan',
        'class' => 'status-diajukan',
        'icon' => 'fa-regular fa-paper-plane',
    ],
    'DIPROSES' => [
        'label' => 'Diproses',
        'class' => 'status-diproses',
        'icon' => 'fa-solid fa-spinner',
    ],
    'DITOLAK' => [
        'label' => 'Ditolak',
        'class' => 'status-ditolak',
        'icon' => 'fa-solid fa-circle-xmark',
    ],
    'SELESAI' => [
        'label' => 'Selesai',
        'class' => 'status-selesai',
        'icon' => 'fa-regular fa-circle-check',
    ],
    'DIAMBIL' => [
        'label' => 'Diambil',
        'class' => 'status-diambil',
        'icon' => 'fa-solid fa-box-open',
    ],
];

function adminFormatDate(?string $date): string
{
    if (empty($date)) {
        return '-';
    }

    $timestamp = strtotime($date);

    return $timestamp
        ? date('d M Y, H:i', $timestamp) . ' WIB'
        : '-';
}
?>

<style>
    .admin-dashboard {
        width: 100%;
        max-width: 1240px;
        margin: 0 auto;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        padding: 26px 28px;
        border-radius: 20px;
        background:
            radial-gradient(circle at 92% 15%, rgba(255,255,255,.18), transparent 26%),
            radial-gradient(circle at 72% 110%, rgba(79,70,229,.34), transparent 34%),
            linear-gradient(135deg, #142e52 0%, #173f70 56%, #2563eb 100%);
        color: #fff;
        box-shadow: 0 18px 38px rgba(20,46,82,.14);
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -60px;
        bottom: -90px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.12);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
    }

    .hero-kicker {
        margin-bottom: 6px;
        color: #bcd2f1;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .hero-title {
        margin: 0;
        font-size: clamp(22px, 3vw, 30px);
        line-height: 1.18;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .hero-description {
        max-width: 620px;
        margin-top: 8px;
        color: #d6e4f7;
        font-size: 12px;
        line-height: 1.65;
    }

    .hero-date {
        flex: 0 0 auto;
        min-width: 155px;
        padding: 12px 14px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 13px;
        background: rgba(255,255,255,.07);
        backdrop-filter: blur(10px);
    }

    .hero-date-label {
        display: block;
        color: #aecaec;
        font-size: 9.5px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .hero-date-value {
        color: #fff;
        font-size: 11px;
        font-weight: 700;
    }

    /* STATS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        position: relative;
        min-height: 136px;
        padding: 18px;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: #fff;
        box-shadow: var(--shadow-sm);
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        overflow: hidden;
    }

    .stat-card::after {
        content: "";
        position: absolute;
        width: 70px;
        height: 70px;
        right: -27px;
        bottom: -27px;
        border-radius: 50%;
        background: rgba(37,99,235,.045);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: #d7e3f6;
    }

    .stat-card.dark {
        background: linear-gradient(145deg, #102a4b 0%, #173f70 100%);
        border-color: #173f70;
    }

    .stat-card.dark .stat-label,
    .stat-card.dark .stat-value {
        color: #fff;
    }

    .stat-card.dark .stat-helper {
        color: #aac3e4;
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .stat-label {
        color: var(--muted);
        font-size: 10.5px;
        font-weight: 700;
        line-height: 1.35;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
    }

    .stat-icon.blue {
        background: #eaf1ff;
        color: var(--royal);
    }

    .stat-icon.indigo {
        background: #eeedff;
        color: var(--indigo);
    }

    .stat-icon.amber {
        background: #fff7e8;
        color: var(--warning);
    }

    .stat-icon.red {
        background: var(--danger-bg);
        color: var(--danger);
    }

    .stat-icon.green {
        background: var(--success-bg);
        color: var(--success);
    }

    .stat-icon.yellow {
        background: rgba(255,255,255,.12);
        color: #ffdf8b;
    }

    .stat-value {
        margin-top: 18px;
        color: var(--navy);
        font-size: 29px;
        line-height: 1;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .stat-helper {
        margin-top: 7px;
        color: var(--muted-light);
        font-size: 9.5px;
        line-height: 1.4;
    }

    /* CONTENT GRID */
    .dashboard-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(300px, .8fr);
        gap: 18px;
        align-items: start;
    }

    .panel {
        border: 1px solid var(--border);
        border-radius: 17px;
        background: #fff;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .panel-head {
        padding: 17px 18px 15px;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .panel-heading {
        min-width: 0;
    }

    .panel-kicker {
        color: var(--muted-light);
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .11em;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .panel-title {
        color: var(--navy);
        font-size: 14px;
        font-weight: 800;
    }

    .panel-subtitle {
        margin-top: 3px;
        color: var(--muted);
        font-size: 10.5px;
    }

    .panel-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--royal);
        text-decoration: none;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .panel-link:hover {
        color: var(--royal-dark);
    }

    /* RECENT REQUEST TABLE */
    .table-wrap {
        overflow-x: auto;
    }

    .requests-table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
    }

    .requests-table th {
        padding: 11px 14px;
        border-bottom: 1px solid var(--border-light);
        color: #98a2b3;
        background: #fbfcfe;
        font-size: 8.5px;
        line-height: 1.3;
        font-weight: 800;
        text-align: left;
        letter-spacing: .08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .requests-table td {
        padding: 13px 14px;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }

    .requests-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .requests-table tbody tr {
        transition: background .15s ease;
    }

    .requests-table tbody tr:hover {
        background: #fbfdff;
    }

    .request-id {
        color: var(--navy);
        font-size: 10.5px;
        font-weight: 800;
        white-space: nowrap;
    }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 150px;
    }

    .student-mini-avatar {
        width: 30px;
        height: 30px;
        border-radius: 10px;
        background: #edf4ff;
        color: var(--royal);
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 30px;
        font-size: 10px;
        font-weight: 800;
    }

    .student-name {
        min-width: 0;
    }

    .student-name strong {
        display: block;
        color: #344054;
        font-size: 10.5px;
        font-weight: 800;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 170px;
    }

    .student-name span {
        display: block;
        margin-top: 2px;
        color: var(--muted-light);
        font-size: 9px;
    }

    .destination-cell {
        color: #475467;
        font-size: 10px;
        font-weight: 600;
        max-width: 170px;
    }

    .date-cell {
        color: #667085;
        font-size: 9.5px;
        white-space: nowrap;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 8.8px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-diajukan {
        color: #1769aa;
        background: #edf7ff;
        border: 1px solid #d7ecff;
    }

    .status-diproses {
        color: #a15c00;
        background: #fff8e8;
        border: 1px solid #fce7b2;
    }

    .status-ditolak {
        color: #b42318;
        background: #fff1f0;
        border: 1px solid #ffd8d4;
    }

    .status-selesai {
        color: #087443;
        background: #ecfdf5;
        border: 1px solid #d4f7e8;
    }

    .status-diambil {
        color: #4c4f69;
        background: #f4f3ff;
        border: 1px solid #e8e6ff;
    }

    .detail-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 9px;
        border: 1px solid #dce6f5;
        border-radius: 9px;
        background: #fff;
        color: var(--navy);
        text-decoration: none;
        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;
    }

    .detail-btn:hover {
        color: var(--royal);
        border-color: #c6d9fb;
        background: #f8fbff;
    }

    .empty-table {
        padding: 44px 20px;
        text-align: center;
    }

    .empty-table-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 11px;
        border-radius: 14px;
        background: #f4f7fc;
        color: #98a2b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .empty-table strong {
        display: block;
        color: #344054;
        font-size: 11.5px;
        font-weight: 800;
    }

    .empty-table p {
        margin-top: 4px;
        color: #98a2b3;
        font-size: 10px;
    }

    /* SUMMARY */
    .summary-list {
        padding: 5px 18px 16px;
    }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-light);
    }

    .summary-item:last-child {
        border-bottom: 0;
    }

    .summary-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        flex: 0 0 9px;
    }

    .summary-dot.blue {
        background: #3182f6;
    }

    .summary-dot.amber {
        background: #f59e0b;
    }

    .summary-dot.red {
        background: #ef4444;
    }

    .summary-dot.green {
        background: #10b981;
    }

    .summary-dot.gray {
        background: #8b8da3;
    }

    .summary-label {
        flex: 1;
        color: #667085;
        font-size: 10.5px;
        font-weight: 600;
    }

    .summary-value {
        color: var(--navy);
        font-size: 12px;
        font-weight: 800;
    }

    .completion-box {
        margin: 0 18px 18px;
        padding: 14px;
        border-radius: 13px;
        background: linear-gradient(135deg, #f5f8ff 0%, #eef2ff 100%);
        border: 1px solid #e1e8ff;
    }

    .completion-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }

    .completion-top strong {
        color: var(--navy);
        font-size: 10px;
        font-weight: 800;
    }

    .completion-top span {
        color: var(--royal);
        font-size: 11px;
        font-weight: 800;
    }

    .progress-track {
        width: 100%;
        height: 7px;
        border-radius: 999px;
        background: rgba(37,99,235,.11);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, var(--royal), var(--indigo));
    }

    .completion-note {
        margin-top: 7px;
        color: var(--muted);
        font-size: 9px;
        line-height: 1.5;
    }

    /* QUICK ACTIONS */
    .quick-actions {
        margin-top: 18px;
        padding: 17px 18px 18px;
    }

    .quick-actions-title {
        margin-bottom: 11px;
        color: var(--navy);
        font-size: 12px;
        font-weight: 800;
    }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 9px;
    }

    .action-card {
        min-height: 76px;
        padding: 11px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #fff;
        text-decoration: none;
        transition: all .16s ease;
    }

    .action-card:hover {
        border-color: #cdddf7;
        background: #f9fbff;
        transform: translateY(-1px);
    }

    .action-icon {
        width: 29px;
        height: 29px;
        margin-bottom: 8px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eaf1ff;
        color: var(--royal);
        font-size: 12px;
    }

    .action-card strong {
        display: block;
        color: #344054;
        font-size: 9.5px;
        font-weight: 800;
    }

    .action-card span {
        display: block;
        margin-top: 2px;
        color: #98a2b3;
        font-size: 8.5px;
        line-height: 1.35;
    }

    /* RESPONSIVE */
    @media (max-width: 1120px) {
        .stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .dashboard-hero {
            padding: 22px 20px;
            border-radius: 17px;
        }

        .hero-content {
            align-items: flex-start;
            flex-direction: column;
        }

        .hero-date {
            min-width: 0;
            width: 100%;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .action-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            min-height: 122px;
        }

        .panel-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .panel-link {
            align-self: flex-start;
        }
    }
</style>

<div class="admin-dashboard">

    <!-- HERO -->
    <section class="dashboard-hero">
        <div class="hero-content">

            <div>
                <div class="hero-kicker">JTI Signature · Panel Administrator</div>

                <h1 class="hero-title">
                    Selamat datang, <?= esc($firstName) ?> 👋
                </h1>

                <p class="hero-description">
                    Pantau pengajuan mahasiswa, periksa bukti pengumpulan berkas fisik,
                    dan kelola status permohonan dari satu tempat.
                </p>
            </div>

            <div class="hero-date">
                <span class="hero-date-label">Hari ini</span>
                <span class="hero-date-value">
                    <?= date('d F Y') ?>
                </span>
            </div>

        </div>
    </section>

    <!-- STATS -->
    <section class="stats-grid">

        <article class="stat-card dark">
            <div class="stat-top">
                <div class="stat-label">Total Permohonan</div>
                <div class="stat-icon yellow">
                    <i class="fa-regular fa-file-lines"></i>
                </div>
            </div>

            <div class="stat-value"><?= number_format($total) ?></div>
            <div class="stat-helper">Seluruh pengajuan yang tersimpan</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Menunggu Pemeriksaan</div>
                <div class="stat-icon blue">
                    <i class="fa-regular fa-paper-plane"></i>
                </div>
            </div>

            <div class="stat-value"><?= number_format($diajukan) ?></div>
            <div class="stat-helper">Status Diajukan</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Sedang Diproses</div>
                <div class="stat-icon amber">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>

            <div class="stat-value"><?= number_format($diproses) ?></div>
            <div class="stat-helper">Sedang ditangani admin</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Perlu Perbaikan</div>
                <div class="stat-icon red">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>

            <div class="stat-value"><?= number_format($ditolak) ?></div>
            <div class="stat-helper">Permohonan ditolak</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-label">Selesai / Diambil</div>
                <div class="stat-icon green">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
            </div>

            <div class="stat-value"><?= number_format($selesaiDiambil) ?></div>
            <div class="stat-helper"><?= number_format($selesai) ?> selesai · <?= number_format($diambil) ?> diambil</div>
        </article>

    </section>

    <!-- MAIN CONTENT -->
    <div class="dashboard-grid">

        <!-- RECENT REQUESTS -->
        <section class="panel">

            <div class="panel-head">
                <div class="panel-heading">
                    <div class="panel-kicker">Aktivitas</div>
                    <div class="panel-title">Permohonan Terbaru</div>
                    <div class="panel-subtitle">
                        Lima pengajuan terakhir yang masuk ke sistem.
                    </div>
                </div>

                <a
                    href="<?= site_url('admin/permohonan') ?>"
                    class="panel-link"
                >
                    Lihat semua
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <?php if (empty($aktivitas)): ?>

                <div class="empty-table">
                    <div class="empty-table-icon">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>

                    <strong>Belum ada permohonan</strong>

                    <p>
                        Pengajuan mahasiswa akan tampil di sini.
                    </p>
                </div>

            <?php else: ?>

                <div class="table-wrap">
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Permohonan</th>
                                <th>Mahasiswa</th>
                                <th>Tujuan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($aktivitas as $item): ?>

                            <?php
                            $id = (int) ($item['id_permohonan'] ?? 0);
                            $status = strtoupper((string) ($item['nama_status'] ?? ''));

                            $meta = $statusMeta[$status] ?? [
                                'label' => ucwords(strtolower($status ?: 'Status')),
                                'class' => 'status-diambil',
                                'icon' => 'fa-regular fa-circle-dot',
                            ];

                            $namaMahasiswa = trim((string) ($item['nama_lengkap'] ?? '-'));
                            $nim = trim((string) ($item['nim'] ?? '-'));
                            $initial = strtoupper(substr($namaMahasiswa !== '-' ? $namaMahasiswa : 'M', 0, 1));
                            ?>

                            <tr>

                                <td>
                                    <div class="request-id">
                                        #REQ-<?= str_pad((string) $id, 4, '0', STR_PAD_LEFT) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="student-cell">
                                        <div class="student-mini-avatar">
                                            <?= esc($initial) ?>
                                        </div>

                                        <div class="student-name">
                                            <strong><?= esc($namaMahasiswa) ?></strong>
                                            <span><?= esc($nim) ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="destination-cell">
                                        <?= esc($item['nama_tujuan'] ?? '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="date-cell">
                                        <?= esc(adminFormatDate($item['tanggal_pengajuan'] ?? null)) ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill <?= esc($meta['class']) ?>">
                                        <i class="<?= esc($meta['icon']) ?>"></i>
                                        <?= esc($meta['label']) ?>
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="<?= site_url('admin/permohonan/' . $id) ?>"
                                        class="detail-btn"
                                    >
                                        Detail
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        </section>

        <!-- SUMMARY -->
        <aside>

            <section class="panel">

                <div class="panel-head">
                    <div class="panel-heading">
                        <div class="panel-kicker">Ringkasan</div>
                        <div class="panel-title">Distribusi Status</div>
                        <div class="panel-subtitle">
                            Kondisi seluruh permohonan saat ini.
                        </div>
                    </div>
                </div>

                <div class="summary-list">

                    <div class="summary-item">
                        <span class="summary-dot blue"></span>
                        <span class="summary-label">Diajukan</span>
                        <strong class="summary-value"><?= number_format($diajukan) ?></strong>
                    </div>

                    <div class="summary-item">
                        <span class="summary-dot amber"></span>
                        <span class="summary-label">Diproses</span>
                        <strong class="summary-value"><?= number_format($diproses) ?></strong>
                    </div>

                    <div class="summary-item">
                        <span class="summary-dot red"></span>
                        <span class="summary-label">Ditolak</span>
                        <strong class="summary-value"><?= number_format($ditolak) ?></strong>
                    </div>

                    <div class="summary-item">
                        <span class="summary-dot green"></span>
                        <span class="summary-label">Selesai</span>
                        <strong class="summary-value"><?= number_format($selesai) ?></strong>
                    </div>

                    <div class="summary-item">
                        <span class="summary-dot gray"></span>
                        <span class="summary-label">Diambil</span>
                        <strong class="summary-value"><?= number_format($diambil) ?></strong>
                    </div>

                </div>

                <?php
                $completionBase = $total > 0 ? $total : 1;
                $completionPercent = $total > 0
                    ? min(100, round(($selesaiDiambil / $completionBase) * 100))
                    : 0;
                ?>

                <div class="completion-box">

                    <div class="completion-top">
                        <strong>Tingkat penyelesaian</strong>
                        <span><?= $completionPercent ?>%</span>
                    </div>

                    <div class="progress-track">
                        <div
                            class="progress-fill"
                            style="width: <?= $completionPercent ?>%;"
                        ></div>
                    </div>

                    <div class="completion-note">
                        <?= number_format($selesaiDiambil) ?> dari <?= number_format($total) ?>
                        permohonan sudah mencapai tahap selesai atau telah diambil.
                    </div>

                </div>

            </section>

            <!-- QUICK ACCESS -->
            <section class="panel quick-actions">

                <div class="quick-actions-title">
                    Akses Cepat
                </div>

                <div class="action-grid">

                    <a
                        href="<?= site_url('admin/permohonan?status=1') ?>"
                        class="action-card"
                    >
                        <div class="action-icon">
                            <i class="fa-regular fa-paper-plane"></i>
                        </div>

                        <strong>Periksa Pengajuan</strong>
                        <span><?= number_format($diajukan) ?> menunggu pemeriksaan</span>
                    </a>

                    <a
                        href="<?= site_url('admin/permohonan?status=2') ?>"
                        class="action-card"
                    >
                        <div class="action-icon">
                            <i class="fa-solid fa-spinner"></i>
                        </div>

                        <strong>Pantau Proses</strong>
                        <span><?= number_format($diproses) ?> sedang diproses</span>
                    </a>

                    <a
                        href="<?= site_url('admin/laporan') ?>"
                        class="action-card"
                    >
                        <div class="action-icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>

                        <strong>Buka Laporan</strong>
                        <span>Lihat statistik dan tren permohonan</span>
                    </a>

                </div>

            </section>

        </aside>

    </div>

</div>

<?= $this->endSection() ?>
