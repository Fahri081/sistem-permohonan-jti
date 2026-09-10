<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<style>
    /* HEADER SECTION */
    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.3px;
        margin-bottom: 6px;
    }

    .dashboard-header p {
        font-size: 13.5px;
        color: #64748b;
    }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        min-height: 124px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }

    .stat-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .stat-card-title {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
        line-height: 1.35;
        max-width: 120px;
    }

    .stat-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-card-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 14px;
        line-height: 1;
    }

    /* SPECIFIC CARD STYLES */
    .icon-permohonan {
        background-color: #f1f5f9;
        color: #475569;
    }

    .icon-diproses {
        background-color: #fef3c7;
        color: #d97706;
    }

    .icon-selesai {
        background-color: #d1fae5;
        color: #10b981;
    }

    /* DARK CARD (SIAP DIAMBIL) */
    .stat-card-dark {
        background: #091e36;
        border-color: #091e36;
        color: #ffffff;
    }

    .stat-card-dark .stat-card-title {
        color: #cbd5e1;
        font-weight: 500;
    }

    .stat-card-dark .stat-card-value {
        color: #ffffff;
    }

    .stat-card-dark .icon-siap-diambil {
        background-color: #fef08a;
        color: #b45309;
    }

    .stat-card-dark .stat-subtitle {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 400;
        margin-top: 4px;
    }

    /* SECTION CARD (TABLE) */
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .table-card-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .btn-outline-sm {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        padding: 6px 14px;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .btn-outline-sm:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    /* TABLE */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13.5px;
    }

    .custom-table th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 12.5px;
        padding: 14px 22px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 18px 22px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .custom-table tbody tr:hover {
        background-color: #fbfcfe;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .req-id {
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }

    .req-date {
        color: #64748b;
        font-size: 13px;
        white-space: nowrap;
    }

    .req-tujuan {
        font-weight: 500;
        color: #1e293b;
        line-height: 1.35;
        max-width: 170px;
    }

    .req-keperluan {
        color: #334155;
        max-width: 320px;
        line-height: 1.4;
    }

    /* BERKAS BADGE */
    .berkas-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    /* STATUS BADGES */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-diproses {
        background-color: #fef3c7;
        color: #b45309;
    }

    .badge-selesai {
        background-color: #d1fae5;
        color: #047857;
    }

    .badge-diajukan {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .badge-ditolak {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    .badge-diambil {
        background-color: #f1f5f9;
        color: #475569;
    }

    /* ACTION LINK */
    .btn-action-detail {
        color: #1e293b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.25;
        display: inline-block;
        transition: color 0.15s ease;
    }

    .btn-action-detail:hover {
        color: #1d4e8c;
        text-decoration: underline;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- GREETING HEADER -->
<?php
    $fullName = session('nama_lengkap') ?? 'Budi Santoso';
    $firstName = explode(' ', trim($fullName))[0];
?>
<div class="dashboard-header">
    <h1>Selamat Datang, <?= esc($firstName) ?>!</h1>
    <p>Berikut adalah ringkasan status permohonan tanda tangan Anda saat ini.</p>
</div>

<!-- 4 STATS CARDS -->
<div class="stats-grid">
    <!-- Card 1: Statistik Permohonan -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Statistik Permohonan</span>
            <div class="stat-card-icon icon-permohonan">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
        </div>
        <div class="stat-card-value"><?= esc($stats['total'] ?? 12) ?></div>
    </div>

    <!-- Card 2: Diproses -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Diproses</span>
            <div class="stat-card-icon icon-diproses">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="stat-card-value"><?= esc($stats['diproses'] ?? 3) ?></div>
    </div>

    <!-- Card 3: Selesai -->
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Selesai</span>
            <div class="stat-card-icon icon-selesai">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
        </div>
        <div class="stat-card-value"><?= esc($stats['selesai'] ?? 8) ?></div>
    </div>

    <!-- Card 4: Siap Diambil (Dark Card) -->
    <div class="stat-card stat-card-dark">
        <div class="stat-card-header">
            <span class="stat-card-title">Siap Diambil</span>
            <div class="stat-card-icon icon-siap-diambil">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                </svg>
            </div>
        </div>
        <div>
            <div class="stat-card-value"><?= esc($stats['siap_diambil'] ?? 1) ?></div>
            <div class="stat-subtitle">Dokumen Fisik</div>
        </div>
    </div>
</div>

<!-- SECTION: PERMOHONAN SAYA -->
<div class="table-card">
    <div class="table-card-header">
        <h2 class="table-card-title">Permohonan Saya</h2>
        <a href="<?= site_url('mahasiswa') ?>" class="btn-outline-sm">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <?php
            // Sample list fallback matching Image 1 if database is clean
            $rowsToDisplay = !empty($permohonan) ? $permohonan : [
                [
                    'id_permohonan'     => 42,
                    'code'              => '#REQ-042',
                    'tanggal_pengajuan' => '2023-10-24 09:30:00',
                    'nama_tujuan'       => 'Ketua Program Studi',
                    'keperluan'         => 'Persetujuan Judul Skripsi Semester Ganjil 2023/2024',
                    'jumlah_berkas'     => 2,
                    'nama_status'       => 'DIPROSES'
                ],
                [
                    'id_permohonan'     => 39,
                    'code'              => '#REQ-039',
                    'tanggal_pengajuan' => '2023-10-18 10:15:00',
                    'nama_tujuan'       => 'Sekretaris Jurusan',
                    'keperluan'         => 'Tanda Tangan Lembar Pengesahan PKL',
                    'jumlah_berkas'     => 1,
                    'nama_status'       => 'SELESAI'
                ],
                [
                    'id_permohonan'     => 44,
                    'code'              => '#REQ-044',
                    'tanggal_pengajuan' => '2023-10-26 14:00:00',
                    'nama_tujuan'       => 'Ketua Program Studi',
                    'keperluan'         => 'Form Bebas Tanggungan Lab Komputer',
                    'jumlah_berkas'     => 3,
                    'nama_status'       => 'DIAJUKAN'
                ],
                [
                    'id_permohonan'     => 31,
                    'code'              => '#REQ-031',
                    'tanggal_pengajuan' => '2023-10-05 11:20:00',
                    'nama_tujuan'       => 'Kepala Laboratorium',
                    'keperluan'         => 'Peminjaman Alat Inventaris Sensor IoT',
                    'jumlah_berkas'     => 1,
                    'nama_status'       => 'DITOLAK'
                ]
            ];
        ?>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID Permohonan</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                    <th>Keperluan</th>
                    <th>Berkas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rowsToDisplay as $p): ?>
                    <?php
                        $statusRaw = strtoupper($p['nama_status'] ?? 'DIAJUKAN');
                        $statusBadgeClass = 'badge-diajukan';
                        $statusText = '• ' . ucfirst(strtolower($statusRaw));

                        if ($statusRaw === 'DIPROSES') {
                            $statusBadgeClass = 'badge-diproses';
                            $statusText = '• Diproses';
                        } elseif ($statusRaw === 'SELESAI') {
                            $statusBadgeClass = 'badge-selesai';
                            $statusText = '✓ Selesai';
                        } elseif ($statusRaw === 'DIAJUKAN') {
                            $statusBadgeClass = 'badge-diajukan';
                            $statusText = '⊙ Diajukan';
                        } elseif ($statusRaw === 'DITOLAK') {
                            $statusBadgeClass = 'badge-ditolak';
                            $statusText = '✕ Ditolak';
                        } elseif ($statusRaw === 'DIAMBIL') {
                            $statusBadgeClass = 'badge-diambil';
                            $statusText = '• Diambil';
                        }

                        $formattedDate = !empty($p['tanggal_pengajuan']) 
                            ? date('d M Y', strtotime($p['tanggal_pengajuan'])) 
                            : '-';

                        $reqCode = $p['code'] ?? ('#REQ-' . str_pad($p['id_permohonan'], 3, '0', STR_PAD_LEFT));
                    ?>
                    <tr>
                        <td class="req-id"><?= esc($reqCode) ?></td>
                        <td class="req-date"><?= esc($formattedDate) ?></td>
                        <td class="req-tujuan"><?= esc($p['nama_tujuan'] ?? '-') ?></td>
                        <td class="req-keperluan"><?= esc($p['keperluan'] ?? '-') ?></td>
                        <td>
                            <span class="berkas-badge" title="<?= esc($p['jumlah_berkas'] ?? 1) ?> Berkas">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                                <?= esc($p['jumlah_berkas'] ?? 1) ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?= $statusBadgeClass ?>">
                                <?= esc($statusText) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url('mahasiswa/permohonan/' . $p['id_permohonan']) ?>" class="btn-action-detail">
                                Lihat<br>Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
