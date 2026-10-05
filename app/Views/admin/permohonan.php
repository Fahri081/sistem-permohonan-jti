<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
$rows = is_array($permohonan ?? null) ? $permohonan : [];
$keywordValue = esc($keyword ?? ($_GET['keyword'] ?? ''));
$statusValue = (string) (
    $statusFilter ??
    ($_GET['status'] ?? '')
);

$statusMap = [
    1 => [
        'label' => 'Diajukan',
        'class' => 'submitted',
        'desc'  => 'Menunggu pemeriksaan',
    ],

    2 => [
        'label' => 'Diproses',
        'class' => 'processing',
        'desc'  => 'Sedang diproses',
    ],

    3 => [
        'label' => 'Ditolak',
        'class' => 'rejected',
        'desc'  => 'Perlu perbaikan',
    ],

    4 => [
        'label' => 'Selesai',
        'class' => 'done',
        'desc'  => 'Dokumen selesai',
    ],

    5 => [
        'label' => 'Diambil',
        'class' => 'picked',
        'desc'  => 'Sudah diambil',
    ],
];

$pendingPickupStatusId = (int) (
    $pendingPickupStatusId ?? 0
);

if ($pendingPickupStatusId > 0) {
    $statusMap[$pendingPickupStatusId] = [
        'label' => 'Menunggu Verifikasi',
        'class' => 'pending',
        'desc'  => 'Menunggu verifikasi pengambilan',
    ];
}

$getStatusId = static function (array $item): int {
    if (isset($item['id_status'])) return (int) $item['id_status'];
    if (isset($item['status_id'])) return (int) $item['status_id'];
    if (isset($item['status_permohonan'])) return (int) $item['status_permohonan'];
    return 0;
};

$getStatusName = static function (array $item) use ($statusMap, $getStatusId): string {
    $id = $getStatusId($item);
    if (isset($statusMap[$id])) return $statusMap[$id]['label'];
    return (string) ($item['nama_status'] ?? $item['status'] ?? 'Tidak diketahui');
};

$statistik = is_array($statistik ?? null)
    ? $statistik
    : [];

$total = (int) ($statistik['total'] ?? 0);
$diajukan = (int) ($statistik['diajukan'] ?? 0);
$diproses = (int) ($statistik['diproses'] ?? 0);
$ditolak = (int) ($statistik['ditolak'] ?? 0);
$selesai = (int) ($statistik['selesai'] ?? 0);
$diambil = (int) ($statistik['diambil'] ?? 0);
$menungguPengambilan = (int) (  
    $statistik['menunggu_pengambilan'] ?? 0
);
$jumlahHasil = count($rows);

$formatDate = static function ($value): string {
    if (!$value) return '-';
    $timestamp = strtotime((string) $value);
    return $timestamp ? date('d M Y', $timestamp) : (string) $value;
};

$initials = static function ($name): string {
    $name = trim((string) $name);
    if ($name === '') return 'M';
    $parts = preg_split('/\s+/', $name);
    $result = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) $result .= strtoupper(substr($parts[count($parts) - 1], 0, 1));
    return substr($result, 0, 2);
};
?>

<style>
    .admin-requests-page { --navy:#142E52; --blue:#2563EB; --soft:#EAF1FF; --indigo:#4F46E5; --success:#059669; --warning:#D97706; --danger:#DC2626; --text:#172033; --muted:#667085; --border:#E2E8F0; --bg:#F4F7FC; color:var(--text); }
    .admin-requests-page * { box-sizing:border-box; }
    .admin-requests-hero { background:linear-gradient(135deg,#142E52 0%,#1f4380 55%,#4F46E5 100%); color:#fff; border-radius:22px; padding:30px; position:relative; overflow:hidden; box-shadow:0 16px 36px rgba(20,46,82,.16); }
    .admin-requests-hero::after { content:""; position:absolute; width:260px; height:260px; border-radius:50%; right:-80px; top:-110px; background:rgba(255,255,255,.10); }
    .hero-eyebrow { font-size:12px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; opacity:.75; margin-bottom:10px; }
    .hero-title { margin:0; font-size:30px; line-height:1.2; font-weight:800; letter-spacing:-.03em; position:relative; z-index:1; }
    .hero-copy { margin:9px 0 0; max-width:720px; color:rgba(255,255,255,.80); font-size:14px; line-height:1.7; position:relative; z-index:1; }

    .request-stats {
    display: grid;
    grid-template-columns: repeat(7, minmax(0, 1fr));
    gap: 12px;
    margin: 18px 0;
}

.request-stat {
    min-width: 0;
    padding: 16px;
}

.request-stat-label {
    color: var(--muted);
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.request-stat-value {
    font-size: 24px;
    font-weight: 800;
    margin-top: 7px;
}
    .request-stat { background:#fff; border:1px solid var(--border); border-radius:16px; padding:18px; box-shadow:0 8px 24px rgba(15,23,42,.05); }
    .request-stat-top { display:flex; justify-content:space-between; gap:10px; align-items:center; }
    .request-stat-label { color:var(--muted); font-size:12px; font-weight:700; }
    .request-stat-value { font-size:25px; font-weight:800; margin-top:7px; }
    .request-dot { width:9px; height:9px; border-radius:50%; background:#94A3B8; flex:0 0 auto; }
    .request-stat.submitted .request-dot {
    background: #2563EB;
}

.request-stat.processing .request-dot {
    background: #D97706;
}

.request-stat.rejected .request-dot {
    background: #DC2626;
}

.request-stat.done .request-dot {
    background: #059669;
}

.request-stat.picked .request-dot {
    background: #4F46E5;
}

.request-stat.pending .request-dot {
    background: #64748B;
}

    .request-panel { background:#fff; border:1px solid var(--border); border-radius:18px; overflow:hidden; box-shadow:0 10px 28px rgba(15,23,42,.05); }
    .request-panel-head { padding:20px 20px 16px; border-bottom:1px solid var(--border); }
    .request-panel-title-row { display:flex; align-items:flex-start; justify-content:space-between; gap:20px; margin-bottom:16px; }
    .request-panel-title { margin:0; font-size:19px; font-weight:800; }
    .request-panel-subtitle { margin:5px 0 0; color:var(--muted); font-size:13px; }
    .request-count { font-size:12px; font-weight:800; color:var(--navy); background:var(--soft); padding:8px 11px; border-radius:999px; white-space:nowrap; }
    .request-filters { display:grid; grid-template-columns:minmax(0,1fr) 190px auto; gap:10px; }
    .request-input, .request-select { width:100%; border:1px solid var(--border); background:#fff; border-radius:11px; padding:11px 13px; font:inherit; font-size:13px; color:var(--text); outline:none; transition:.18s ease; }
    .request-input:focus, .request-select:focus { border-color:#93C5FD; box-shadow:0 0 0 4px rgba(37,99,235,.10); }
    .request-search-wrap { position:relative; }
    .request-search-wrap svg { position:absolute; width:16px; height:16px; left:13px; top:50%; transform:translateY(-50%); color:#94A3B8; pointer-events:none; }
    .request-search-wrap .request-input { padding-left:39px; }
    .btn-filter { border:0; border-radius:11px; padding:11px 16px; font-weight:800; font-size:13px; cursor:pointer; background:linear-gradient(135deg,#2563EB,#4F46E5); color:#fff; box-shadow:0 8px 16px rgba(37,99,235,.18); }
    .btn-reset { display:inline-flex; align-items:center; justify-content:center; padding:11px 14px; border:1px solid var(--border); border-radius:11px; background:#fff; color:var(--muted); text-decoration:none; font-size:13px; font-weight:700; }
    .filter-actions { display:flex; gap:8px; }

    .table-wrap { width:100%; overflow:auto; }
    .request-table { width:100%; border-collapse:collapse; min-width:900px; }
    .request-table th { padding:13px 18px; background:#F8FAFC; border-bottom:1px solid var(--border); color:#7B8798; font-size:10px; text-transform:uppercase; letter-spacing:.08em; font-weight:800; text-align:left; }
    .request-table td { padding:16px 18px; border-bottom:1px solid #EEF2F7; vertical-align:middle; font-size:13px; }
    .request-table tbody tr:hover { background:#FBFDFF; }
    .request-table tbody tr:last-child td { border-bottom:0; }
    .req-id { font-weight:800; color:var(--navy); white-space:nowrap; }
    .student-cell { display:flex; align-items:center; gap:11px; min-width:190px; }
    .student-avatar { width:36px; height:36px; border-radius:12px; background:var(--soft); color:var(--blue); display:grid; place-items:center; font-weight:800; font-size:12px; flex:0 0 auto; }
    .student-name { font-weight:800; color:var(--text); }
    .student-nim { margin-top:3px; color:var(--muted); font-size:11px; }
    .purpose-cell { max-width:270px; }
    .purpose-title { font-weight:700; line-height:1.45; }
    .date-cell { white-space:nowrap; color:#475467; }
    .status-badge { display:inline-flex; align-items:center; gap:7px; border-radius:999px; padding:7px 10px; font-size:11px; font-weight:800; white-space:nowrap; }
    .status-badge::before { content:""; width:7px; height:7px; border-radius:50%; background:currentColor; opacity:.85; }
    .status-badge.submitted {
    color: #1D4ED8;
    background: #EEF4FF;
}

.status-badge.processing {
    color: #B45309;
    background: #FFF7E8;
}

.status-badge.rejected {
    color: #B91C1C;
    background: #FFF0F0;
}

.status-badge.done {
    color: #047857;
    background: #ECFDF5;
}

.status-badge.picked {
    color: #4338CA;
    background: #EEF2FF;
}

.status-badge.pending {
    color: #475569;
    background: #F1F5F9;
}

.status-badge.unknown {
    color: #475467;
    background: #F2F4F7;
}
    .action-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    min-width: 78px;
    min-height: 42px;

    padding: 8px 11px;

    border: 1px solid #DCE6F5;
    border-radius: 10px;

    color: var(--blue);
    background: #EEF6FF;

    font-size: 12px;
    font-weight: 800;

    text-decoration: none;

    /* PENTING UNTUK MOBILE */
    white-space: nowrap;
    overflow-wrap: normal;
    word-break: normal;

    flex-shrink: 0;

    box-sizing: border-box;
}

.action-link:hover {
    background: #DBEAFE;
}

    .empty-state { padding:52px 24px; text-align:center; }
    .empty-icon { width:56px; height:56px; margin:0 auto 14px; border-radius:18px; background:#F1F5F9; color:#64748B; display:grid; place-items:center; }
    .empty-title { font-size:17px; font-weight:800; margin-bottom:6px; }
    .empty-copy { max-width:440px; margin:0 auto; color:var(--muted); font-size:13px; line-height:1.7; }
    .pagination-wrap { padding:15px 18px; border-top:1px solid var(--border); display:flex; justify-content:space-between; gap:16px; align-items:center; color:var(--muted); font-size:12px; flex-wrap:wrap; }
    .pagination-info { line-height:1.5; }
    .pagination-info strong { color:var(--text); font-weight:800; }
    .pagination-controls { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
    .pagination-btn { min-width:34px; height:34px; padding:0 10px; border:1px solid var(--border); border-radius:10px; display:inline-flex; align-items:center; justify-content:center; color:#475467; background:#fff; text-decoration:none; font-size:12px; font-weight:800; transition:.15s ease; }
    .pagination-btn:hover { background:#F8FAFC; border-color:#CBD5E1; color:var(--navy); }
    .pagination-btn.active { background:var(--blue); border-color:var(--blue); color:#fff; }
    .pagination-btn.disabled { color:#98A2B3; background:#F8FAFC; pointer-events:none; }
    .pagination-ellipsis { padding:0 3px; color:#98A2B3; font-weight:800; }


   @media (max-width: 700px) {
        .pagination-wrap { align-items:flex-start; }
        .pagination-controls { width:100%; }
    }

   @media (max-width: 1000px) {
    .request-stats {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (max-width: 760px) {
    .admin-requests-hero {
        padding: 24px;
        border-radius: 18px;
    }

    .hero-title {
        font-size: 24px;
    }

    .request-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .request-panel-head {
        padding: 16px;
    }

    .request-panel-title-row {
        display: block;
    }

    .request-count {
        display: inline-block;
        margin-top: 9px;
    }

    .request-filters {
        grid-template-columns: 1fr;
    }

    .filter-actions {
        width: 100%;
    }

    .filter-actions > * {
        flex: 1;
    }
}

@media (max-width: 480px) {
    .request-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .request-stat {
        padding: 14px;
    }

    .request-stat-value {
        font-size: 21px;
    }
}
</style>

<div class="admin-requests-page">
    <section class="admin-requests-hero">
        <div class="hero-eyebrow">Manajemen Layanan Akademik</div>
        <h1 class="hero-title">Semua Permohonan</h1>
        <p class="hero-copy">Kelola, periksa, dan pantau seluruh permohonan mahasiswa dalam satu tampilan yang rapi.</p>
    </section>

    <section class="request-stats" aria-label="Ringkasan permohonan">

    <!-- TOTAL -->
    <div class="request-stat">
        <div class="request-stat-top">
            <span class="request-stat-label">Total</span>
            <span class="request-dot"></span>
        </div>

        <div class="request-stat-value">
            <?= $total ?>
        </div>
    </div>


    <!-- DIAJUKAN -->
    <div class="request-stat submitted">
        <div class="request-stat-top">
            <span class="request-stat-label">Diajukan</span>
            <span class="request-dot"></span>
        </div>

        <div class="request-stat-value">
            <?= $diajukan ?>
        </div>
    </div>


    <!-- DIPROSES -->
    <div class="request-stat processing">
        <div class="request-stat-top">
            <span class="request-stat-label">Diproses</span>
            <span class="request-dot"></span>
        </div>

        <div class="request-stat-value">
            <?= $diproses ?>
        </div>
    </div>


    <!-- DITOLAK -->
    <div class="request-stat rejected">
        <div class="request-stat-top">
            <span class="request-stat-label">Ditolak</span>
            <span class="request-dot"></span>
        </div>

        <div class="request-stat-value">
            <?= $ditolak ?>
        </div>
    </div>


    <!-- SELESAI -->
    <div class="request-stat done">
        <div class="request-stat-top">
            <span class="request-stat-label">Selesai</span>
            <span class="request-dot"></span>
        </div>

        <div class="request-stat-value">
            <?= $selesai ?>
        </div>
    </div>


   <!-- DIAMBIL -->
<div class="request-stat picked">
    <div class="request-stat-top">
        <span class="request-stat-label">Diambil</span>
        <span class="request-dot"></span>
    </div>

    <div class="request-stat-value">
        <?= $diambil ?>
    </div>
</div>


<!-- MENUNGGU VERIFIKASI -->
<div class="request-stat pending">
    <div class="request-stat-top">
        <span class="request-stat-label">
            Menunggu Verifikasi
        </span>

        <span class="request-dot"></span>
    </div>

    <div class="request-stat-value">
        <?= $menungguPengambilan ?>
    </div>
</div>
</section>
    <section class="request-panel">
        <div class="request-panel-head">
            <div class="request-panel-title-row">
                <div>
                    <h2 class="request-panel-title">Daftar Permohonan</h2>
                    <p class="request-panel-subtitle">Cari berdasarkan mahasiswa, NIM, tujuan, status, atau ID permohonan.</p>
                </div>
                <div class="request-count"><?= $jumlahHasil ?> permohonan</div>
            </div>

            <form method="get" action="<?= site_url('admin/permohonan') ?>" class="request-filters">
                <div class="request-search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"></circle><path d="m20 20-3.5-3.5"></path></svg>
                    <input class="request-input" type="search" name="keyword" value="<?= $keywordValue ?>" placeholder="Cari nama, NIM, ID, tujuan, atau status...">
                </div>
                <select class="request-select" name="status" aria-label="Filter status">
                    <option value="">Semua status</option>
                    <?php foreach ($statusMap as $id => $meta): ?>
                        <option value="<?= $id ?>" <?= $statusValue === (string) $id ? 'selected' : '' ?>><?= esc($meta['label']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter">Terapkan</button>
                    <a class="btn-reset" href="<?= site_url('admin/permohonan') ?>">Reset</a>
                </div>
            </form>
        </div>

        <?php if ($rows): ?>
            <div class="table-wrap">
                <table class="request-table">
                    <thead>
                        <tr>
                            <th>ID Permohonan</th>
                            <th>Mahasiswa</th>
                            <th>Tujuan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $item): ?>
                        <?php
                        $statusId = $getStatusId($item);
                        $statusName = $getStatusName($item);
                        $statusMeta = $statusMap[$statusId] ?? ['class' => 'unknown'];
                        $studentName = $item['nama_mahasiswa'] ?? $item['nama_user'] ?? $item['nama'] ?? 'Mahasiswa';
                        $nim = $item['nim'] ?? '-';
                        $target = $item['nama_tujuan'] ?? $item['tujuan'] ?? 'Tidak diketahui';
                        $purpose = $item['keperluan'] ?? $item['deskripsi'] ?? '-';
                        $id = $item['id_permohonan'] ?? $item['id'] ?? '-';
                        $date = $item['created_at'] ?? $item['tanggal_pengajuan'] ?? $item['tanggal'] ?? null;
                        ?>
                        <tr>
                            <td><div class="req-id">#REQ-<?= str_pad((string) $id, 4, '0', STR_PAD_LEFT) ?></div></td>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar"><?= esc($initials($studentName)) ?></div>
                                    <div>
                                        <div class="student-name"><?= esc($studentName) ?></div>
                                        <div class="student-nim">NIM <?= esc($nim) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="purpose-cell">
                                <div class="purpose-title"><?= esc($target) ?></div>
                                <div class="student-nim"><?= esc(mb_strimwidth((string) $purpose, 0, 60, '…', 'UTF-8')) ?></div>
                            </td>
                            <td class="date-cell"><?= esc($formatDate($date)) ?></td>
                            <td>
                                <span class="status-badge <?= esc($statusMeta['class']) ?>"><?= esc($statusName) ?></span>
                            </td>
                            <td>
                                <a class="action-link" href="<?= site_url('admin/permohonan/' . $id) ?>">
                                    Detail
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h13"></path><path d="m13 6 6 6-6 6"></path></svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3h8l4 4v14H7z"></path><path d="M15 3v5h5"></path><path d="M10 13h6M10 17h4"></path></svg>
                </div>
                <div class="empty-title">Belum ada permohonan</div>
                <p class="empty-copy">Tidak ada data yang cocok dengan pencarian atau filter yang digunakan.</p>
            </div>
        <?php endif; ?>

<?php
        $totalFiltered = (int) ($totalFiltered ?? $jumlahHasil);
        $currentPage = max(1, (int) ($currentPage ?? 1));
        $totalPages = max(1, (int) ($totalPages ?? 1));
        $perPage = max(1, (int) ($perPage ?? 10));

        $firstItem = $totalFiltered > 0
            ? (($currentPage - 1) * $perPage) + 1
            : 0;
        $lastItem = $totalFiltered > 0
            ? min($currentPage * $perPage, $totalFiltered)
            : 0;

        $buildPageUrl = static function (int $page) use ($keywordValue, $statusValue): string {
            $params = ['page' => $page];

            if ($keywordValue !== '') {
                $params['keyword'] = html_entity_decode($keywordValue, ENT_QUOTES, 'UTF-8');
            }

            if ($statusValue !== '') {
                $params['status'] = $statusValue;
            }

            return site_url('admin/permohonan') . '?' . http_build_query($params);
        };

        $visiblePages = [];
        if ($totalPages <= 7) {
            $visiblePages = range(1, $totalPages);
        } else {
            $visiblePages[] = 1;

            $startPage = max(2, $currentPage - 1);
            $endPage = min($totalPages - 1, $currentPage + 1);

            if ($startPage > 2) {
                $visiblePages[] = '...';
            }

            for ($pageNumber = $startPage; $pageNumber <= $endPage; $pageNumber++) {
                $visiblePages[] = $pageNumber;
            }

            if ($endPage < $totalPages - 1) {
                $visiblePages[] = '...';
            }

            $visiblePages[] = $totalPages;
        }
        ?>

        <div class="pagination-wrap">
            <div class="pagination-info">
                <?php if ($totalFiltered > 0): ?>
                    Menampilkan <strong><?= $firstItem ?>–<?= $lastItem ?></strong> dari <strong><?= $totalFiltered ?></strong> permohonan
                <?php else: ?>
                    Tidak ada permohonan yang cocok
                <?php endif; ?>
            </div>

            <?php if ($totalFiltered > 0 && $totalPages > 1): ?>
                <div class="pagination-controls" aria-label="Navigasi halaman">
                    <?php if ($currentPage > 1): ?>
                        <a class="pagination-btn" href="<?= esc($buildPageUrl($currentPage - 1)) ?>" aria-label="Halaman sebelumnya">‹</a>
                    <?php else: ?>
                        <span class="pagination-btn disabled" aria-hidden="true">‹</span>
                    <?php endif; ?>

                    <?php foreach ($visiblePages as $pageNumber): ?>
                        <?php if ($pageNumber === '...'): ?>
                            <span class="pagination-ellipsis">…</span>
                        <?php else: ?>
                            <a
                                class="pagination-btn <?= $currentPage === (int) $pageNumber ? 'active' : '' ?>"
                                href="<?= esc($buildPageUrl((int) $pageNumber)) ?>"
                                <?= $currentPage === (int) $pageNumber ? 'aria-current="page"' : '' ?>
                            >
                                <?= $pageNumber ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a class="pagination-btn" href="<?= esc($buildPageUrl($currentPage + 1)) ?>" aria-label="Halaman berikutnya">›</a>
                    <?php else: ?>
                        <span class="pagination-btn disabled" aria-hidden="true">›</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<?= $this->endSection() ?>
