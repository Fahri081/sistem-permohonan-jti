<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php
    $tanggalMulai = $tanggalMulai ?? date('Y-m-01');
    $tanggalAkhir = $tanggalAkhir ?? date('Y-m-t');

    $total = (int) ($total ?? 0);
    $statusData = $status ?? [
        'diajukan' => 0,
        'diproses' => 0,
        'ditolak'  => 0,
        'selesai'  => 0,
        'diambil'  => 0,
    ];

    $tujuanData = is_array($tujuan ?? null) ? $tujuan : [];
    $trenData = is_array($tren ?? null) ? $tren : [];
    $bulananData = is_array($bulanan ?? null) ? $bulanan : [];

    $selesaiDanDiambil = (int) ($statusData['selesai'] ?? 0) + (int) ($statusData['diambil'] ?? 0);
    $persentaseSelesai = $total > 0
        ? round(($selesaiDanDiambil / $total) * 100)
        : 0;

    $labelsStatus = ['Diajukan', 'Diproses', 'Ditolak', 'Selesai', 'Diambil'];
    $valuesStatus = [
        (int) ($statusData['diajukan'] ?? 0),
        (int) ($statusData['diproses'] ?? 0),
        (int) ($statusData['ditolak'] ?? 0),
        (int) ($statusData['selesai'] ?? 0),
        (int) ($statusData['diambil'] ?? 0),
    ];

    $tujuanLabels = [];
    $tujuanValues = [];
    foreach ($tujuanData as $row) {
        $tujuanLabels[] = (string) ($row['nama_tujuan'] ?? 'Tanpa Tujuan');
        $tujuanValues[] = (int) ($row['total'] ?? 0);
    }

    $trenLabels = [];
    $trenValues = [];
    foreach ($trenData as $row) {
        $trenLabels[] = (string) ($row['label'] ?? '-');
        $trenValues[] = (int) ($row['total'] ?? 0);
    }
?>

<style>
    .report-page {
        display: grid;
        gap: 22px;
    }

    .report-hero {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 28px 30px;
        background: linear-gradient(135deg, #142E52 0%, #2563EB 62%, #4F46E5 100%);
        color: #fff;
        box-shadow: 0 18px 40px rgba(20, 46, 82, .16);
    }

    .report-hero::after {
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -75px;
        top: -115px;
        background: rgba(255, 255, 255, .10);
    }

    .report-hero::before {
        content: "";
        position: absolute;
        width: 170px;
        height: 170px;
        border-radius: 50%;
        right: 110px;
        bottom: -105px;
        background: rgba(255, 255, 255, .07);
    }

    .report-hero-inner {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
    }

    .report-kicker {
        margin: 0 0 7px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: rgba(255,255,255,.72);
    }

    .report-hero h1 {
        margin: 0;
        font-size: clamp(24px, 3vw, 32px);
        line-height: 1.15;
        letter-spacing: -.02em;
    }

    .report-hero p {
        margin: 9px 0 0;
        color: rgba(255,255,255,.82);
        font-size: 14px;
        max-width: 620px;
    }

    .report-calendar-icon {
        width: 62px;
        height: 62px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        border-radius: 18px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.14);
        font-size: 26px;
    }

    .filter-card,
    .stat-card,
    .chart-card,
    .table-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .05);
    }

    .filter-card {
        padding: 18px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .filter-group label {
        display: block;
        margin: 0 0 7px;
        color: #475467;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .filter-group input {
        width: 100%;
        box-sizing: border-box;
        height: 44px;
        border: 1px solid #D6DEEA;
        border-radius: 12px;
        padding: 0 13px;
        color: #172033;
        background: #FAFBFD;
        outline: none;
        font: inherit;
    }

    .filter-group input:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
        background: #fff;
    }

    .filter-actions {
        display: flex;
        gap: 9px;
    }

    .btn-primary-report,
    .btn-reset-report {
        height: 44px;
        border-radius: 12px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary-report {
        border: 0;
        color: #fff;
        background: linear-gradient(135deg, #2563EB, #4F46E5);
    }

    .btn-reset-report {
        border: 1px solid #D6DEEA;
        color: #475467;
        background: #fff;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .stat-card {
        padding: 20px;
        min-width: 0;
    }

    .stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: #EAF1FF;
        color: #2563EB;
    }

    .stat-card h3 {
        margin: 18px 0 5px;
        font-size: 30px;
        letter-spacing: -.03em;
        color: #142E52;
    }

    .stat-card p {
        margin: 0;
        color: #667085;
        font-size: 13px;
        font-weight: 700;
    }

    .stat-progress {
        margin-top: 14px;
        height: 7px;
        background: #EEF2F7;
        border-radius: 999px;
        overflow: hidden;
    }

    .stat-progress > span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #2563EB, #4F46E5);
    }

    .main-charts {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 18px;
    }

    .chart-card {
        padding: 20px;
        min-width: 0;
    }

    .card-heading {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
    }

    .card-heading h2 {
        margin: 0;
        color: #172033;
        font-size: 16px;
    }

    .card-heading p {
        margin: 5px 0 0;
        color: #667085;
        font-size: 12px;
    }

    .chart-wrap {
        height: 300px;
        position: relative;
    }

    .chart-wrap.small {
        height: 300px;
    }

    .secondary-grid {
        display: grid;
        grid-template-columns: .95fr 1.05fr;
        gap: 18px;
    }

    .table-card {
        overflow: hidden;
    }

    .table-card-header {
        padding: 20px;
        border-bottom: 1px solid #EEF2F6;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th,
    .report-table td {
        padding: 13px 18px;
        text-align: left;
        border-bottom: 1px solid #EEF2F6;
    }

    .report-table th {
        color: #667085;
        font-size: 11px;
        letter-spacing: .07em;
        text-transform: uppercase;
        background: #FBFCFE;
    }

    .report-table td {
        color: #344054;
        font-size: 13px;
    }

    .report-table tr:last-child td {
        border-bottom: 0;
    }

    .empty-report {
        padding: 30px 20px;
        text-align: center;
        color: #667085;
    }

    .empty-report i {
        font-size: 25px;
        margin-bottom: 9px;
        color: #98A2B3;
    }

    .report-note {
        padding: 14px 16px;
        border-radius: 14px;
        border: 1px dashed #C8D6F2;
        background: #F6F9FF;
        color: #475467;
        font-size: 12px;
        line-height: 1.6;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .main-charts,
        .secondary-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 720px) {
        .report-hero {
            padding: 23px 20px;
        }

        .report-hero-inner {
            align-items: flex-start;
        }

        .report-calendar-icon {
            display: none;
        }

        .filter-form,
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            width: 100%;
        }

        .filter-actions > * {
            flex: 1;
        }

        .chart-wrap,
        .chart-wrap.small {
            height: 250px;
        }

        .report-table {
            min-width: 610px;
        }

        .table-scroll {
            overflow-x: auto;
        }
    }
</style>

<div class="report-page">

    <section class="report-hero">
        <div class="report-hero-inner">
            <div>
                <div class="report-kicker">JTI Signature • Academic Services</div>
                <h1>Laporan & Statistik</h1>
                <p>
                    Pantau volume permohonan, distribusi status, tren pengajuan,
                    dan tujuan layanan berdasarkan periode yang dipilih.
                </p>
            </div>
            <div class="report-calendar-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
    </section>

    <section class="filter-card">
        <form class="filter-form" method="get" action="<?= site_url('admin/laporan') ?>">
            <div class="filter-group">
                <label for="mulai">Tanggal Mulai</label>
                <input type="date" id="mulai" name="mulai" value="<?= esc($tanggalMulai) ?>" required>
            </div>

            <div class="filter-group">
                <label for="akhir">Tanggal Akhir</label>
                <input type="date" id="akhir" name="akhir" value="<?= esc($tanggalAkhir) ?>" required>
            </div>

            <div class="filter-actions">
                <button class="btn-primary-report" type="submit">
                    <i class="fa-solid fa-filter"></i>
                    Terapkan
                </button>

                <a class="btn-reset-report" href="<?= site_url('admin/laporan') ?>">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="stats-grid">
        <article class="stat-card">
            <div class="stat-top">
                <p>Total Permohonan</p>
                <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
            </div>
            <h3><?= number_format($total) ?></h3>
            <p>Dalam periode terpilih</p>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <p>Masuk / Diajukan</p>
                <div class="stat-icon"><i class="fa-regular fa-paper-plane"></i></div>
            </div>
            <h3><?= number_format((int) ($statusData['diajukan'] ?? 0)) ?></h3>
            <p>Menunggu pemeriksaan admin</p>
            <div class="stat-progress">
                <span style="width: <?= $total > 0 ? round(($statusData['diajukan'] / $total) * 100) : 0 ?>%"></span>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <p>Sedang Diproses</p>
                <div class="stat-icon"><i class="fa-solid fa-spinner"></i></div>
            </div>
            <h3><?= number_format((int) ($statusData['diproses'] ?? 0)) ?></h3>
            <p>Permohonan dalam pemeriksaan</p>
            <div class="stat-progress">
                <span style="width: <?= $total > 0 ? round(($statusData['diproses'] / $total) * 100) : 0 ?>%"></span>
            </div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <p>Selesai / Diambil</p>
                <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            </div>
            <h3><?= $persentaseSelesai ?>%</h3>
            <p><?= number_format($selesaiDanDiambil) ?> permohonan selesai</p>
            <div class="stat-progress">
                <span style="width: <?= $persentaseSelesai ?>%"></span>
            </div>
        </article>
    </section>

    <section class="main-charts">
        <article class="chart-card">
            <div class="card-heading">
                <div>
                    <h2>Distribusi Status</h2>
                    <p>Jumlah permohonan pada setiap tahap proses.</p>
                </div>
            </div>
            <div class="chart-wrap small">
                <canvas id="statusChart"></canvas>
            </div>
        </article>

        <article class="chart-card">
            <div class="card-heading">
                <div>
                    <h2>Volume per Tujuan</h2>
                    <p>Layanan yang paling banyak diajukan.</p>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="tujuanChart"></canvas>
            </div>
        </article>
    </section>

    <section class="secondary-grid">
        <article class="chart-card">
            <div class="card-heading">
                <div>
                    <h2>Tren Permohonan</h2>
                    <p>Pergerakan jumlah pengajuan dalam periode terpilih.</p>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="trendChart"></canvas>
            </div>
        </article>

        <article class="table-card">
            <div class="table-card-header">
                <div class="card-heading" style="margin-bottom:0;">
                    <div>
                        <h2>Ringkasan Bulanan</h2>
                        <p>Rekap jumlah pengajuan per bulan.</p>
                    </div>
                </div>
            </div>

            <div class="table-scroll">
                <?php if (! empty($bulananData)): ?>
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Periode</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bulananData as $row): ?>
                                <tr>
                                    <td><?= esc($row['bulan'] ?? $row['periode'] ?? '-') ?></td>
                                    <td><strong><?= number_format((int) ($row['total'] ?? 0)) ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-report">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <div>Belum ada data bulanan untuk periode ini.</div>
                    </div>
                <?php endif; ?>
            </div>
        </article>
    </section>

    <div class="report-note">
        <strong>Periode aktif:</strong>
        <?= esc(date('d M Y', strtotime($tanggalMulai))) ?>
        — 
        <?= esc(date('d M Y', strtotime($tanggalAkhir))) ?>.
        Data laporan mengikuti tanggal pengajuan permohonan.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusLabels = <?= json_encode($labelsStatus, JSON_UNESCAPED_UNICODE) ?>;
    const statusValues = <?= json_encode($valuesStatus) ?>;

    const tujuanLabels = <?= json_encode($tujuanLabels, JSON_UNESCAPED_UNICODE) ?>;
    const tujuanValues = <?= json_encode($tujuanValues) ?>;

    const trendLabels = <?= json_encode($trenLabels, JSON_UNESCAPED_UNICODE) ?>;
    const trendValues = <?= json_encode($trenValues) ?>;

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    boxWidth: 9,
                    padding: 16
                }
            }
        }
    };

    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    borderWidth: 0,
                    backgroundColor: [
                        '#2563EB',
                        '#4F46E5',
                        '#DC2626',
                        '#059669',
                        '#0F766E'
                    ]
                }]
            },
            options: {
                ...commonOptions,
                cutout: '67%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 9,
                            padding: 14
                        }
                    }
                }
            }
        });
    }

    const tujuanCanvas = document.getElementById('tujuanChart');
    if (tujuanCanvas) {
        new Chart(tujuanCanvas, {
            type: 'bar',
            data: {
                labels: tujuanLabels,
                datasets: [{
                    label: 'Permohonan',
                    data: tujuanValues,
                    borderRadius: 8,
                    backgroundColor: '#2563EB',
                    maxBarThickness: 28
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    y: {
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    const trendCanvas = document.getElementById('trendChart');
    if (trendCanvas) {
        new Chart(trendCanvas, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Pengajuan',
                    data: trendValues,
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, .10)',
                    fill: true,
                    tension: .35,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    const mulai = document.getElementById('mulai');
    const akhir = document.getElementById('akhir');

    if (mulai && akhir) {
        mulai.addEventListener('change', function () {
            akhir.min = mulai.value;
        });

        akhir.addEventListener('change', function () {
            mulai.max = akhir.value;
        });

        if (mulai.value) {
            akhir.min = mulai.value;
        }
        if (akhir.value) {
            mulai.max = akhir.value;
        }
    }
});
</script>

<?= $this->endSection() ?>
