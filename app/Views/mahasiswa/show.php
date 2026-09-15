<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
    $idPermohonan = (int) ($permohonan['id_permohonan'] ?? 0);
    $reqIdDisplay = $idPermohonan > 0
        ? ('REQ-' . str_pad((string) $idPermohonan, 4, '0', STR_PAD_LEFT))
        : '-';

    $statusId = (int) ($permohonan['id_status'] ?? 0);
    $statusRaw = strtoupper((string) ($permohonan['nama_status'] ?? 'DIPROSES'));

    $statusConfig = [
        'DIAJUKAN' => [
            'label' => 'Diajukan',
            'icon' => '○',
            'class' => 'status-blue',
            'soft' => 'soft-blue',
        ],
        'DIPROSES' => [
            'label' => 'Diproses',
            'icon' => '↻',
            'class' => 'status-indigo',
            'soft' => 'soft-indigo',
        ],
        'DITOLAK' => [
            'label' => 'Ditolak',
            'icon' => '!',
            'class' => 'status-red',
            'soft' => 'soft-red',
        ],
        'SELESAI' => [
            'label' => 'Selesai',
            'icon' => '✓',
            'class' => 'status-green',
            'soft' => 'soft-green',
        ],
        'DIAMBIL' => [
            'label' => 'Diambil',
            'icon' => '✓',
            'class' => 'status-green',
            'soft' => 'soft-green',
        ],
    ];

    $cfg = $statusConfig[$statusRaw] ?? $statusConfig['DIPROSES'];

    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $formatDate = static function ($dateValue, $withTime = true) use ($months) {
        if (empty($dateValue)) {
            return '-';
        }

        $timestamp = strtotime((string) $dateValue);
        if ($timestamp === false) {
            return '-';
        }

        $text = date('d', $timestamp) . ' ' . ($months[(int) date('n', $timestamp)] ?? date('F', $timestamp)) . ' ' . date('Y', $timestamp);
        if ($withTime) {
            $text .= ', ' . date('H:i', $timestamp) . ' WIB';
        }

        return $text;
    };

    $tglPengajuan = $formatDate($permohonan['tanggal_pengajuan'] ?? null);
    $tujuanDisplay = trim((string) ($permohonan['nama_tujuan'] ?? '')) ?: '-';
    $keperluanDisplay = trim((string) ($permohonan['keperluan'] ?? '')) ?: '-';
    $deskripsiDisplay = trim((string) ($permohonan['deskripsi'] ?? '')) ?: 'Tidak ada deskripsi tambahan.';
    $penolakanDisplay = trim((string) ($permohonan['keterangan_penolakan'] ?? ''));

    $buktiFisik = is_array($buktiFisik ?? null) ? $buktiFisik : [];
    $totalBuktiFisik = count($buktiFisik);

    $timeline = [
        [
            'id' => 1,
            'title' => 'Diajukan',
            'description' => 'Permohonan berhasil dikirim dan tercatat di sistem.',
        ],
        [
            'id' => 2,
            'title' => 'Diproses',
            'description' => 'Admin sedang memeriksa permohonan Anda.',
        ],
        [
            'id' => 4,
            'title' => 'Selesai',
            'description' => 'Permohonan telah selesai diproses oleh admin.',
        ],
        [
            'id' => 5,
            'title' => 'Diambil',
            'description' => 'Dokumen hasil permohonan telah diambil.',
        ],
    ];

    if ($statusId === 3 || $statusRaw === 'DITOLAK') {
        $timeline = [
            [
                'id' => 1,
                'title' => 'Diajukan',
                'description' => 'Permohonan berhasil dikirim dan tercatat di sistem.',
            ],
            [
                'id' => 2,
                'title' => 'Diproses',
                'description' => 'Admin telah memeriksa permohonan Anda.',
            ],
            [
                'id' => 3,
                'title' => 'Ditolak',
                'description' => 'Permohonan memerlukan perbaikan sebelum dapat diproses kembali.',
            ],
        ];
    }

    $currentIndex = null;
    foreach ($timeline as $index => $step) {
        if ((int) $step['id'] === $statusId) {
            $currentIndex = $index;
            break;
        }
    }

    if ($currentIndex === null) {
        $currentIndex = 0;
    }

    $allowEditEvidence = in_array($statusId, [1, 3], true) || in_array($statusRaw, ['DIAJUKAN', 'DITOLAK'], true);
?>

<style>
    .detail-page {
        max-width: 1240px;
        margin: 0 auto;
        padding-bottom: 32px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667085;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 18px;
        transition: color .18s ease, transform .18s ease;
    }

    .back-link:hover {
        color: #2563eb;
        transform: translateX(-2px);
    }

    .detail-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        padding: 28px 30px;
        border-radius: 20px;
        background: linear-gradient(135deg, #142e52 0%, #1d4ed8 58%, #4f46e5 100%);
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 16px 34px rgba(20, 46, 82, .15);
    }

    .detail-hero::before,
    .detail-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        background: rgba(255,255,255,.08);
        pointer-events: none;
    }

    .detail-hero::before {
        width: 210px;
        height: 210px;
        right: -65px;
        top: -90px;
    }

    .detail-hero::after {
        width: 130px;
        height: 130px;
        right: 140px;
        bottom: -75px;
    }

    .hero-copy,
    .hero-status {
        position: relative;
        z-index: 1;
    }

    .hero-kicker {
        font-size: 11px;
        line-height: 1;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: rgba(255,255,255,.72);
        margin-bottom: 10px;
    }

    .hero-title {
        margin: 0 0 8px;
        font-size: 28px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,.80);
        font-size: 13px;
    }

    .hero-meta-separator {
        opacity: .5;
    }

    .hero-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(8px);
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .hero-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255,255,255,.10);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(320px, .95fr);
        gap: 22px;
        align-items: start;
    }

    .left-stack,
    .right-stack {
        min-width: 0;
    }

    .ui-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 5px 18px rgba(15,23,42,.04);
        overflow: hidden;
    }

    .ui-card + .ui-card {
        margin-top: 22px;
    }

    .card-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 24px 0;
    }

    .card-title-wrap {
        min-width: 0;
    }

    .card-title {
        margin: 0;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: -.01em;
    }

    .card-subtitle {
        margin: 5px 0 0;
        color: #667085;
        font-size: 12px;
        line-height: 1.5;
    }

    .card-body {
        padding: 22px 24px 24px;
    }

    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        border: 1px solid transparent;
        font-size: 11px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-blue { background: #eaf1ff; color: #1d4ed8; border-color: #d8e5ff; }
    .status-indigo { background: #eef2ff; color: #4338ca; border-color: #e0e7ff; }
    .status-red { background: #fef2f2; color: #dc2626; border-color: #fee2e2; }
    .status-green { background: #ecfdf3; color: #059669; border-color: #d1fae5; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 14px;
    }

    .info-item {
        padding: 15px 16px;
        border: 1px solid #edf1f7;
        border-radius: 14px;
        background: #fbfcff;
    }

    .info-label {
        margin-bottom: 7px;
        color: #98a2b3;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .07em;
    }

    .info-value {
        color: #172033;
        font-size: 13px;
        font-weight: 650;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .description-box {
        margin-top: 14px;
        padding: 16px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #edf1f7;
    }

    .description-box .info-label {
        margin-bottom: 8px;
    }

    .description-text {
        margin: 0;
        color: #475467;
        font-size: 13px;
        line-height: 1.7;
        white-space: pre-line;
    }

    .timeline {
        padding: 6px 24px 24px;
    }

    .timeline-step {
        position: relative;
        display: grid;
        grid-template-columns: 30px 1fr;
        gap: 13px;
        min-height: 78px;
    }

    .timeline-step:last-child {
        min-height: 0;
    }

    .timeline-rail {
        position: relative;
        display: flex;
        justify-content: center;
    }

    .timeline-rail::after {
        content: '';
        position: absolute;
        top: 26px;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-step.done .timeline-rail::after,
    .timeline-step.current .timeline-rail::after {
        background: #2563eb;
    }

    .timeline-step.rejected .timeline-rail::after {
        background: #fecaca;
    }

    .timeline-marker {
        position: relative;
        z-index: 1;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 2px solid #d0d5dd;
        background: #fff;
        color: #98a2b3;
        font-size: 11px;
        font-weight: 900;
        box-sizing: border-box;
    }

    .timeline-step.done .timeline-marker,
    .timeline-step.current .timeline-marker {
        border-color: #2563eb;
        background: #2563eb;
        color: #fff;
        box-shadow: 0 0 0 5px #eaf1ff;
    }

    .timeline-step.rejected .timeline-marker {
        border-color: #dc2626;
        background: #dc2626;
        color: #fff;
        box-shadow: 0 0 0 5px #fef2f2;
    }

    .timeline-content {
        padding-bottom: 18px;
    }

    .timeline-title-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 7px;
    }

    .timeline-title {
        color: #98a2b3;
        font-size: 13px;
        font-weight: 800;
    }

    .timeline-step.done .timeline-title,
    .timeline-step.current .timeline-title {
        color: #172033;
    }

    .timeline-step.rejected .timeline-title {
        color: #b42318;
    }

    .timeline-note {
        margin: 4px 0 0;
        color: #98a2b3;
        font-size: 11.5px;
        line-height: 1.55;
    }

    .timeline-step.current .timeline-note {
        color: #667085;
    }

    .timeline-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 8px;
        border-radius: 999px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 9.5px;
        font-weight: 800;
    }

    .timeline-step.rejected .timeline-badge {
        background: #fef2f2;
        color: #dc2626;
    }

    .rejection-box {
        margin-top: 22px;
        padding: 17px 18px;
        border: 1px solid #fecaca;
        border-radius: 15px;
        background: linear-gradient(180deg, #fff7f7 0%, #fff 100%);
    }

    .rejection-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b42318;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .rejection-text {
        margin: 0;
        color: #7a271a;
        font-size: 12.5px;
        line-height: 1.65;
        white-space: pre-line;
    }

    .evidence-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border-radius: 999px;
        background: #f2f4f7;
        color: #667085;
        font-size: 10.5px;
        font-weight: 800;
    }

    .evidence-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 11px;
    }

    .evidence-item {
        position: relative;
        display: block;
        padding: 0;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        background: #f8fafc;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .evidence-item:hover {
        transform: translateY(-2px);
        border-color: #bfd0f7;
        box-shadow: 0 8px 20px rgba(37,99,235,.10);
    }

    .evidence-img {
        display: block;
        width: 100%;
        height: 165px;
        object-fit: cover;
    }

    .evidence-caption {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 9px 10px;
        background: #fff;
    }

    .evidence-caption strong {
        color: #344054;
        font-size: 10.5px;
        font-weight: 800;
    }

    .evidence-caption span {
        color: #98a2b3;
        font-size: 10px;
    }

    .evidence-empty {
        padding: 28px 18px;
        text-align: center;
        border: 1px dashed #d0d5dd;
        border-radius: 14px;
        background: #fafbfc;
    }

    .empty-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 11px;
        border-radius: 12px;
        background: #eef2f6;
        color: #667085;
    }

    .empty-title {
        color: #344054;
        font-size: 12.5px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .empty-text {
        color: #98a2b3;
        font-size: 11.5px;
        line-height: 1.5;
    }

    .edit-evidence-box {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #eef2f6;
    }

    .btn-primary,
    .btn-secondary,
    .btn-danger-soft {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: .18s ease;
    }

    .btn-primary {
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow: 0 7px 16px rgba(37,99,235,.18);
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(37,99,235,.22);
    }

    .btn-secondary {
        color: #344054;
        background: #fff;
        border-color: #d0d5dd;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #b8c0cc;
    }

    .btn-danger-soft {
        color: #dc2626;
        background: #fff5f5;
        border-color: #fecaca;
    }

    .quick-note {
        display: flex;
        gap: 11px;
        padding: 14px 15px;
        border-radius: 13px;
        background: #f7f9fc;
        border: 1px solid #edf1f7;
    }

    .quick-note + .quick-note {
        margin-top: 10px;
    }

    .quick-note-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eaf1ff;
        color: #2563eb;
    }

    .quick-note-title {
        margin: 0 0 3px;
        color: #344054;
        font-size: 11.5px;
        font-weight: 800;
    }

    .quick-note-text {
        margin: 0;
        color: #667085;
        font-size: 11px;
        line-height: 1.55;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15,23,42,.68);
        backdrop-filter: blur(3px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-card {
        width: min(880px, 100%);
        max-height: 88vh;
        overflow: auto;
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,.35);
        box-shadow: 0 24px 60px rgba(15,23,42,.26);
    }

    .modal-card.image-modal {
        width: min(920px, 100%);
        padding: 14px;
    }

    .modal-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 22px 24px 0;
    }

    .modal-title {
        margin: 0;
        color: #172033;
        font-size: 17px;
        font-weight: 800;
    }

    .modal-subtitle {
        margin: 5px 0 0;
        color: #667085;
        font-size: 12px;
        line-height: 1.55;
    }

    .modal-close {
        width: 36px;
        height: 36px;
        flex: 0 0 auto;
        border: 0;
        border-radius: 10px;
        background: #f2f4f7;
        color: #667085;
        cursor: pointer;
        font-size: 20px;
        line-height: 1;
    }

    .modal-close:hover {
        background: #eaecf0;
    }

    .modal-body {
        padding: 20px 24px 24px;
    }

    .edit-evidence-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px,1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .edit-evidence-card {
        padding: 8px;
        border: 1px solid #e4e7ec;
        border-radius: 13px;
        background: #fff;
        transition: opacity .18s ease, border-color .18s ease;
    }

    .edit-evidence-card.removed {
        opacity: .45;
        border-color: #fca5a5;
    }

    .edit-evidence-img {
        display: block;
        width: 100%;
        height: 108px;
        object-fit: cover;
        border-radius: 9px;
        margin-bottom: 8px;
    }

    .edit-evidence-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .edit-evidence-label {
        min-width: 0;
        color: #475467;
        font-size: 10.5px;
        font-weight: 700;
    }

    .btn-remove {
        flex-shrink: 0;
        border: 0;
        border-radius: 7px;
        padding: 6px 8px;
        background: #fff1f2;
        color: #dc2626;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .btn-remove.keep {
        background: #ecfdf3;
        color: #059669;
    }

    .upload-zone {
        padding: 18px;
        text-align: center;
        border: 2px dashed #d0d5dd;
        border-radius: 15px;
        background: #fafbfc;
    }

    .upload-zone:hover {
        border-color: #93b4f8;
        background: #f8faff;
    }

    .upload-zone-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        border-radius: 12px;
        background: #eaf1ff;
        color: #2563eb;
    }

    .upload-zone-title {
        margin: 0 0 4px;
        color: #344054;
        font-size: 12.5px;
        font-weight: 800;
    }

    .upload-zone-text {
        margin: 0 0 11px;
        color: #98a2b3;
        font-size: 11px;
    }

    .upload-zone input {
        width: 100%;
        font-size: 11px;
    }

    .upload-counter {
        margin-top: 9px;
        color: #667085;
        font-size: 10.5px;
        text-align: left;
    }

    .modal-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 18px;
    }

    .image-preview {
        display: block;
        width: 100%;
        max-height: 74vh;
        object-fit: contain;
        border-radius: 14px;
        background: #0f172a;
    }

    .image-caption {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 3px 2px;
    }

    .image-caption strong {
        color: #344054;
        font-size: 12px;
        font-weight: 800;
    }

    .image-caption span {
        color: #98a2b3;
        font-size: 10.5px;
    }

    @media (max-width: 960px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .detail-page {
            padding-bottom: 20px;
        }

        .detail-hero {
            flex-direction: column;
            align-items: flex-start;
            padding: 22px;
            border-radius: 17px;
        }

        .hero-title {
            font-size: 23px;
        }

        .card-head,
        .card-body,
        .modal-head,
        .modal-body {
            padding-left: 18px;
            padding-right: 18px;
        }

        .info-grid,
        .evidence-grid {
            grid-template-columns: 1fr;
        }

        .evidence-img {
            height: 210px;
        }

        .modal-overlay {
            padding: 10px;
        }
    }
</style>

<div class="detail-page">
    <a href="<?= site_url('mahasiswa/permohonan') ?>" class="back-link">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5"></path>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Permohonan Saya</span>
    </a>

    <section class="detail-hero">
        <div class="hero-copy">
            <div class="hero-kicker">Detail Permohonan</div>
            <h1 class="hero-title"><?= esc($reqIdDisplay) ?></h1>
            <div class="hero-meta">
                <span>Diajukan <?= esc($tglPengajuan) ?></span>
                <span class="hero-meta-separator">•</span>
                <span><?= esc($tujuanDisplay) ?></span>
            </div>
        </div>

        <div class="hero-status">
            <span class="hero-status-dot"></span>
            <span><?= esc($cfg['label']) ?></span>
        </div>
    </section>

    <div class="detail-grid">
        <div class="left-stack">
            <section class="ui-card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <h2 class="card-title">Informasi Permohonan</h2>
                        <p class="card-subtitle">Rincian utama dari permohonan yang Anda ajukan.</p>
                    </div>
                    <span class="status-chip <?= esc($cfg['class']) ?>">
                        <span><?= esc($cfg['icon']) ?></span>
                        <span><?= esc($cfg['label']) ?></span>
                    </span>
                </div>

                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Tanggal Pengajuan</div>
                            <div class="info-value"><?= esc($tglPengajuan) ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Tujuan</div>
                            <div class="info-value"><?= esc($tujuanDisplay) ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Keperluan</div>
                            <div class="info-value"><?= esc($keperluanDisplay) ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">ID Permohonan</div>
                            <div class="info-value"><?= esc($reqIdDisplay) ?></div>
                        </div>
                    </div>

                    <div class="description-box">
                        <div class="info-label">Deskripsi</div>
                        <p class="description-text"><?= esc($deskripsiDisplay) ?></p>
                    </div>

                    <?php if ($statusId === 3 || $statusRaw === 'DITOLAK' || $penolakanDisplay !== ''): ?>
                        <div class="rejection-box">
                            <div class="rejection-title">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                    <line x1="12" y1="9" x2="12" y2="13"></line>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span>Catatan Perbaikan</span>
                            </div>
                            <p class="rejection-text">
                                <?= $penolakanDisplay !== ''
                                    ? esc($penolakanDisplay)
                                    : 'Permohonan perlu diperbaiki sebelum dapat diproses kembali.' ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="ui-card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <h2 class="card-title">Perjalanan Permohonan</h2>
                        <p class="card-subtitle">Ikuti perkembangan permohonan Anda dari waktu ke waktu.</p>
                    </div>
                </div>

                <div class="timeline">
                    <?php foreach ($timeline as $index => $step): ?>
                        <?php
                            $stepId = (int) $step['id'];
                            $isCurrent = $stepId === $statusId;
                            $isDone = $currentIndex > $index && !$isCurrent;
                            $isRejected = $stepId === 3 && ($statusId === 3 || $statusRaw === 'DITOLAK');
                            $classes = trim(
                                ($isCurrent ? 'current ' : '') .
                                ($isDone ? 'done ' : '') .
                                ($isRejected ? 'rejected' : '')
                            );
                        ?>

                        <div class="timeline-step <?= esc($classes) ?>">
                            <div class="timeline-rail">
                                <div class="timeline-marker">
                                    <?php if ($isRejected): ?>
                                        !
                                    <?php elseif ($isDone): ?>
                                        ✓
                                    <?php elseif ($isCurrent): ?>
                                        •
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="timeline-content">
                                <div class="timeline-title-row">
                                    <div class="timeline-title"><?= esc($step['title']) ?></div>
                                    <?php if ($isCurrent): ?>
                                        <span class="timeline-badge">Status saat ini</span>
                                    <?php endif; ?>
                                </div>
                                <p class="timeline-note">
                                    <?= esc($step['description']) ?>
                                    <?php if ($stepId === 1 && !empty($permohonan['tanggal_pengajuan'])): ?>
                                        • <?= esc($formatDate($permohonan['tanggal_pengajuan'])) ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>

        <div class="right-stack">
            <section class="ui-card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <h2 class="card-title">Bukti Pengumpulan</h2>
                        <p class="card-subtitle">Foto sebagai bukti bahwa berkas fisik telah dikumpulkan.</p>
                    </div>
                    <span class="evidence-count">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <?= $totalBuktiFisik ?> foto
                    </span>
                </div>

                <div class="card-body">
                    <?php if ($totalBuktiFisik > 0): ?>
                        <div class="evidence-grid">
                            <?php foreach ($buktiFisik as $index => $foto): ?>
                                <?php
                                    $namaFoto = trim((string) ($foto['nama_file'] ?? ''));
                                    $fotoUrl = $namaFoto !== ''
                                        ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                        : '';
                                ?>

                                <?php if ($fotoUrl): ?>
                                    <button
                                        type="button"
                                        class="evidence-item js-open-image"
                                        data-image="<?= esc($fotoUrl) ?>"
                                        data-index="<?= $index + 1 ?>"
                                    >
                                        <img
                                            src="<?= esc($fotoUrl) ?>"
                                            alt="Bukti pengumpulan foto <?= $index + 1 ?>"
                                            class="evidence-img"
                                            loading="lazy"
                                        >
                                        <div class="evidence-caption">
                                            <strong>Foto <?= $index + 1 ?></strong>
                                            <span>Klik untuk lihat</span>
                                        </div>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="evidence-empty">
                            <div class="empty-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <div class="empty-title">Foto belum tersedia</div>
                            <div class="empty-text">Belum ada foto bukti pengumpulan yang tersimpan pada permohonan ini.</div>
                        </div>
                    <?php endif; ?>

                    <?php if ($allowEditEvidence): ?>
                        <div class="edit-evidence-box">
                            <div class="quick-note">
                                <div class="quick-note-icon">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="quick-note-title"><?= $statusId === 3 ? 'Perlu perbaikan' : 'Masih dapat diubah' ?></p>
                                    <p class="quick-note-text">
                                        <?= $statusId === 3
                                            ? 'Perbaiki foto bukti sesuai catatan admin, lalu kirim kembali untuk diperiksa.'
                                            : 'Anda dapat menghapus foto yang salah atau menambahkan foto hingga maksimal 10 foto.' ?>
                                    </p>
                                </div>
                            </div>

                            <div style="margin-top:12px;display:flex;justify-content:flex-end;">
                                <button type="button" class="btn-primary" id="openEditBuktiModal">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                    </svg>
                                    <span>Ubah Bukti Fisik</span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="ui-card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <h2 class="card-title">Informasi Proses</h2>
                        <p class="card-subtitle">Hal yang perlu diperhatikan selama permohonan diproses.</p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="quick-note">
                        <div class="quick-note-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="9"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div>
                            <p class="quick-note-title">Pantau status secara berkala</p>
                            <p class="quick-note-text">Perubahan status permohonan akan ditampilkan pada halaman ini dan notifikasi akun.</p>
                        </div>
                    </div>

                    <div class="quick-note">
                        <div class="quick-note-icon" style="background:#ecfdf3;color:#059669;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="quick-note-title">Bukti pengumpulan</p>
                            <p class="quick-note-text">Simpan foto yang jelas dan sesuai dengan kondisi pengumpulan berkas fisik.</p>
                        </div>
                    </div>

                    <?php if ($statusId === 5): ?>
                        <div class="quick-note">
                            <div class="quick-note-icon" style="background:#ecfdf3;color:#059669;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 12 2 2 4-4"></path>
                                    <path d="M20 7h-4l-1-2H9L8 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="quick-note-title">Permohonan sudah diambil</p>
                                <p class="quick-note-text">Permohonan ini telah selesai sampai tahap pengambilan.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- IMAGE MODAL -->
<div class="modal-overlay" id="imageModal" aria-hidden="true">
    <div class="modal-card image-modal">
        <button type="button" class="modal-close" id="closeImageModal" aria-label="Tutup">&times;</button>
        <img id="imagePreview" src="" alt="Preview bukti pengumpulan" class="image-preview">
        <div class="image-caption">
            <strong id="imagePreviewTitle">Foto Bukti 1</strong>
            <span>Klik area di luar modal untuk menutup</span>
        </div>
    </div>
</div>

<!-- EDIT BUKTI FISIK MODAL -->
<?php if ($allowEditEvidence): ?>
    <div class="modal-overlay" id="editBuktiModal" aria-hidden="true">
        <div class="modal-card">
            <div class="modal-head">
                <div>
                    <h3 class="modal-title">Ubah Bukti Fisik</h3>
                    <p class="modal-subtitle">Pertahankan foto yang benar, hapus foto yang kurang sesuai, atau tambahkan foto baru.</p>
                </div>
                <button type="button" class="modal-close" id="closeEditBuktiModal" aria-label="Tutup">&times;</button>
            </div>

            <div class="modal-body">
                <form
                    action="<?= site_url('mahasiswa/permohonan/' . $idPermohonan . '/bukti-fisik') ?>"
                    method="POST"
                    enctype="multipart/form-data"
                    id="editBuktiForm"
                >
                    <?= csrf_field() ?>

                    <?php if ($totalBuktiFisik > 0): ?>
                        <div class="edit-evidence-grid" id="editEvidenceGrid">
                            <?php foreach ($buktiFisik as $index => $foto): ?>
                                <?php
                                    $idBukti = (int) ($foto['id_bukti'] ?? 0);
                                    $namaFoto = trim((string) ($foto['nama_file'] ?? ''));
                                    $fotoUrl = $namaFoto !== ''
                                        ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                        : '';
                                ?>

                                <?php if ($idBukti > 0 && $fotoUrl): ?>
                                    <div class="edit-evidence-card" data-bukti-card="<?= $idBukti ?>">
                                        <img src="<?= esc($fotoUrl) ?>" alt="Foto <?= $index + 1 ?>" class="edit-evidence-img">

                                        <div class="edit-evidence-meta">
                                            <span class="edit-evidence-label">Foto <?= $index + 1 ?></span>

                                            <button
                                                type="button"
                                                class="btn-remove"
                                                data-remove-bukti="<?= $idBukti ?>"
                                            >
                                                Hapus
                                            </button>
                                        </div>

                                        <input
                                            type="hidden"
                                            name="keep_bukti[]"
                                            value="<?= $idBukti ?>"
                                            data-keep-input="<?= $idBukti ?>"
                                        >
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="upload-zone">
                        <div class="upload-zone-icon">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3v12"></path>
                                <path d="m7 8 5-5 5 5"></path>
                                <path d="M5 21h14"></path>
                            </svg>
                        </div>
                        <p class="upload-zone-title">Tambahkan foto bukti</p>
                        <p class="upload-zone-text">JPG, JPEG, PNG atau WEBP • maksimal 5 MB per foto • maksimal 10 foto</p>
                        <input
                            type="file"
                            name="foto_bukti_tambahan[]"
                            id="fotoBuktiTambahan"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            multiple
                        >
                        <div class="upload-counter" id="editBuktiCounter"></div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" id="cancelEditBuktiBtn">Batal</button>
                        <button type="submit" class="btn-primary">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9"></path>
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageModal = document.getElementById('imageModal');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewTitle = document.getElementById('imagePreviewTitle');
    const closeImageModal = document.getElementById('closeImageModal');

    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
    }

    function openModal(modal) {
        if (!modal) return;
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
    }

    document.querySelectorAll('.js-open-image').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!imageModal || !imagePreview) return;
            imagePreview.src = this.dataset.image || '';
            if (imagePreviewTitle) {
                imagePreviewTitle.textContent = 'Foto Bukti ' + (this.dataset.index || '');
            }
            openModal(imageModal);
        });
    });

    if (closeImageModal) {
        closeImageModal.addEventListener('click', function () {
            closeModal(imageModal);
            if (imagePreview) imagePreview.src = '';
        });
    }

    if (imageModal) {
        imageModal.addEventListener('click', function (event) {
            if (event.target === imageModal) {
                closeModal(imageModal);
                if (imagePreview) imagePreview.src = '';
            }
        });
    }

    const editModal = document.getElementById('editBuktiModal');
    const openEditButton = document.getElementById('openEditBuktiModal');
    const closeEditButton = document.getElementById('closeEditBuktiModal');
    const cancelEditButton = document.getElementById('cancelEditBuktiBtn');
    const editForm = document.getElementById('editBuktiForm');
    const fileInput = document.getElementById('fotoBuktiTambahan');
    const counter = document.getElementById('editBuktiCounter');

    const MAX_FILES = 10;
    const MAX_SIZE = 5 * 1024 * 1024;
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    let selectedFiles = [];

    function getKeepCount() {
        if (!editForm) return 0;
        return editForm.querySelectorAll('input[name="keep_bukti[]"]:not(:disabled)').length;
    }

    function syncFileInput() {
        if (!fileInput) return;

        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }

    function updateCounter() {
        if (!counter) return;
        const total = getKeepCount() + selectedFiles.length;
        counter.textContent = total + ' foto akan disimpan. Maksimal ' + MAX_FILES + ' foto.';
    }

    function resetEditState() {
        selectedFiles = [];
        syncFileInput();

        if (!editForm) return;

        editForm.querySelectorAll('[data-remove-bukti]').forEach(function (button) {
            const id = button.dataset.removeBukti;
            const card = editForm.querySelector('[data-bukti-card="' + id + '"]');
            const hidden = editForm.querySelector('[data-keep-input="' + id + '"]');

            if (card) card.classList.remove('removed');
            if (hidden) hidden.disabled = false;

            button.classList.remove('keep');
            button.textContent = 'Hapus';
        });

        updateCounter();
    }

    if (openEditButton && editModal) {
        openEditButton.addEventListener('click', function () {
            resetEditState();
            openModal(editModal);
        });
    }

    [closeEditButton, cancelEditButton].forEach(function (button) {
        if (!button || !editModal) return;
        button.addEventListener('click', function () {
            closeModal(editModal);
        });
    });

    if (editModal) {
        editModal.addEventListener('click', function (event) {
            if (event.target === editModal) {
                closeModal(editModal);
            }
        });
    }

    if (editForm) {
        editForm.querySelectorAll('[data-remove-bukti]').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.dataset.removeBukti;
                const card = editForm.querySelector('[data-bukti-card="' + id + '"]');
                const hidden = editForm.querySelector('[data-keep-input="' + id + '"]');

                if (!card || !hidden) return;

                const isRemoved = hidden.disabled;

                if (isRemoved) {
                    hidden.disabled = false;
                    card.classList.remove('removed');
                    this.classList.remove('keep');
                    this.textContent = 'Hapus';
                } else {
                    hidden.disabled = true;
                    card.classList.add('removed');
                    this.classList.add('keep');
                    this.textContent = 'Pertahankan';
                }

                updateCounter();
            });
        });
    }

    if (fileInput) {
        fileInput.addEventListener('change', function () {
            const currentKeep = getKeepCount();
            const availableSlots = Math.max(0, MAX_FILES - currentKeep);
            const incomingFiles = Array.from(this.files || []);

            selectedFiles = selectedFiles.slice(0, availableSlots);

            for (const file of incomingFiles) {
                if (selectedFiles.length >= availableSlots) break;

                if (!ALLOWED_TYPES.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: file.name + ' harus berupa JPG, JPEG, PNG, atau WEBP.'
                    });
                    continue;
                }

                if (file.size > MAX_SIZE) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran terlalu besar',
                        text: file.name + ' melebihi batas 5 MB.'
                    });
                    continue;
                }

                const duplicate = selectedFiles.some(function (existing) {
                    return existing.name === file.name &&
                        existing.size === file.size &&
                        existing.lastModified === file.lastModified;
                });

                if (!duplicate) {
                    selectedFiles.push(file);
                }
            }

            syncFileInput();
            updateCounter();
        });
    }

    if (editForm) {
        editForm.addEventListener('submit', function (event) {
            const total = getKeepCount() + selectedFiles.length;

            if (total < 1) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti fisik belum ada',
                    text: 'Pertahankan minimal satu foto atau tambahkan foto baru.'
                });
                return;
            }

            if (total > MAX_FILES) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Terlalu banyak foto',
                    text: 'Maksimal ' + MAX_FILES + ' foto yang dapat disimpan.'
                });
                return;
            }

            syncFileInput();
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;

        closeModal(imageModal);
        closeModal(editModal);
        if (imagePreview) imagePreview.src = '';
    });

    updateCounter();
});
</script>

<?= $this->endSection() ?>
