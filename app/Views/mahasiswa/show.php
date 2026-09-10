<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<style>
    /* PAGE HEADER */
    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .detail-header-left h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.3px;
        margin-bottom: 4px;
    }

    .detail-header-left p {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
    }

    /* HEADER STATUS BADGE */
    .status-badge-lg {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 600;
    }

    .badge-diproses-lg {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .badge-selesai-lg {
        background-color: #d1fae5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .badge-diajukan-lg {
        background-color: #e0f2fe;
        color: #0284c7;
        border: 1px solid #bae6fd;
    }

    .badge-ditolak-lg {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    /* 2-COLUMN DETAIL LAYOUT */
    .detail-layout-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 24px;
        align-items: start;
    }

    /* CARD STYLES */
    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px 28px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        margin-bottom: 24px;
    }

    .detail-card:last-child {
        margin-bottom: 0;
    }

    .detail-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    /* INFORMASI PERMOHONAN 2x2 GRID */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 20px;
    }

    .info-item-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .info-item-value {
        font-size: 13.5px;
        color: #1e293b;
        font-weight: 500;
        line-height: 1.45;
    }

    /* UNGGAHAN BERKAS CARD */
    .berkas-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .berkas-progress-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .progress-bar-container {
        width: 100px;
        height: 6px;
        background-color: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background-color: #133863;
        border-radius: 999px;
    }

    .progress-label {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }

    /* BERKAS LIST */
    .berkas-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .berkas-row-item {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #ffffff;
        transition: border-color 0.15s;
    }

    .berkas-row-item:hover {
        border-color: #cbd5e1;
    }

    .berkas-file-meta {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .berkas-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background-color: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .berkas-file-name {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .berkas-file-subtext {
        font-size: 11.5px;
        color: #64748b;
    }

    /* STATUS PILL ON FILE */
    .file-status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .pill-selesai {
        background-color: #d1fae5;
        color: #047857;
    }

    .pill-diproses {
        background-color: #fef3c7;
        color: #b45309;
    }

    .pill-ditolak {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* REJECTION ALERT CARD */
    .rejection-alert-card {
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 12px;
        padding: 18px 22px;
        margin-top: 24px;
    }

    .rejection-header {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #991b1b;
        font-size: 13.5px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .rejection-desc {
        font-size: 12.5px;
        color: #7f1d1d;
        line-height: 1.45;
        margin-bottom: 14px;
    }

    .btn-reupload {
        background-color: #b91c1c;
        color: #ffffff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-reupload:hover {
        background-color: #991b1b;
    }

    /* BUKTI FISIK RIGHT CARD */
    .bukti-fisik-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .bukti-fisik-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .bukti-fisik-subtext {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
        margin-bottom: 16px;
    }

    .bukti-fisik-img-wrapper {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        cursor: pointer;
        transition: transform 0.15s ease;
    }

    .bukti-fisik-img-wrapper:hover {
        transform: scale(1.02);
    }

    .bukti-fisik-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    /* MODAL FOR IMAGE ZOOM & REUPLOAD */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: #ffffff;
        border-radius: 14px;
        max-width: 600px;
        width: 100%;
        padding: 24px;
        position: relative;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .modal-close-btn {
        position: absolute;
        top: 14px;
        right: 16px;
        background: none;
        border: none;
        font-size: 20px;
        color: #64748b;
        cursor: pointer;
    }

    @media (max-width: 960px) {
        .detail-layout-grid {
            grid-template-columns: 1fr;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
</style>

<?php
    // Prepare display values from data or mock defaults
    $reqIdDisplay = !empty($permohonan['id_permohonan']) 
        ? ('REQ-2023-' . str_pad($permohonan['id_permohonan'], 4, '0', STR_PAD_LEFT)) 
        : 'REQ-2023-0892';

    $statusRaw = strtoupper($permohonan['nama_status'] ?? 'DIPROSES');
    $statusClass = 'badge-diproses-lg';
    $statusIcon = '🔄';
    $statusText = 'Diproses';

    if ($statusRaw === 'SELESAI') {
        $statusClass = 'badge-selesai-lg';
        $statusIcon = '✓';
        $statusText = 'Selesai';
    } elseif ($statusRaw === 'DITOLAK') {
        $statusClass = 'badge-ditolak-lg';
        $statusIcon = '✕';
        $statusText = 'Ditolak';
    } elseif ($statusRaw === 'DIAJUKAN') {
        $statusClass = 'badge-diajukan-lg';
        $statusIcon = '⊙';
        $statusText = 'Diajukan';
    }

    $tglPengajuan = !empty($permohonan['tanggal_pengajuan'])
        ? date('d F Y, H:i \W\I\B', strtotime($permohonan['tanggal_pengajuan']))
        : '12 Oktober 2023, 09:45 WIB';

    $tujuanDisplay = $permohonan['nama_tujuan'] ?? 'Ketua Jurusan Teknologi Informasi';
    $keperluanDisplay = $permohonan['keperluan'] ?? 'Tanda Tangan Surat Pengantar Magang MBKM Genap 2023/2024';
    $deskripsiDisplay = !empty($permohonan['deskripsi']) 
        ? $permohonan['deskripsi'] 
        : 'Mohon bantuannya untuk menandatangani surat pengantar magang di PT Teknologi Nusantara. Berkas asli telah diserahkan ke admin jurusan.';

    $defaultBuktiImg = base_url('assets/images/bukti_dokumen.jpg');
?>

<!-- PAGE HEADER -->
<div class="detail-header">
    <div class="detail-header-left">
        <h1>Detail Permohonan</h1>
        <p><?= esc($reqIdDisplay) ?></p>
    </div>
    <div>
        <span class="status-badge-lg <?= $statusClass ?>">
            <span><?= $statusIcon ?></span>
            <span><?= esc($statusText) ?></span>
        </span>
    </div>
</div>

<!-- 2-COLUMN DETAIL LAYOUT -->
<div class="detail-layout-grid">
    <!-- LEFT COLUMN -->
    <div>
        <!-- CARD 1: INFORMASI PERMOHONAN -->
        <div class="detail-card">
            <h2 class="detail-card-title">Informasi Permohonan</h2>
            <div class="info-grid">
                <div>
                    <div class="info-item-label">Tanggal Pengajuan</div>
                    <div class="info-item-value"><?= esc($tglPengajuan) ?></div>
                </div>
                <div>
                    <div class="info-item-label">Tujuan</div>
                    <div class="info-item-value"><?= esc($tujuanDisplay) ?></div>
                </div>
                <div>
                    <div class="info-item-label">Keperluan</div>
                    <div class="info-item-value"><?= esc($keperluanDisplay) ?></div>
                </div>
                <div>
                    <div class="info-item-label">Keterangan Admin</div>
                    <div class="info-item-value"><?= esc($deskripsiDisplay) ?></div>
                </div>
            </div>
        </div>

        <!-- CARD 2: UNGGAHAN BERKAS -->
        <div class="detail-card">
            <div class="berkas-card-header">
                <h2 class="detail-card-title" style="margin-bottom:0;">Unggahan Berkas</h2>
                <div class="berkas-progress-wrap">
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: <?= esc($percentage ?? 50) ?>%;"></div>
                    </div>
                    <span class="progress-label">
                        <?= esc($selesaiBerkas ?? 1) ?> dari <?= esc($totalBerkas > 0 ? $totalBerkas : 2) ?> berkas selesai
                    </span>
                </div>
            </div>

            <div class="berkas-list">
                <?php if (!empty($berkas)): ?>
                    <?php foreach ($berkas as $idx => $b): ?>
                        <?php $isDone = !empty($b['selesai']) && $b['selesai'] == 1; ?>
                        <div class="berkas-row-item">
                            <div class="berkas-file-meta">
                                <div class="berkas-icon-box">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                </div>
                                <div>
                                    <div class="berkas-file-name"><?= esc($b['nama_berkas']) ?></div>
                                    <div class="berkas-file-subtext">245 KB • Diunggah <?= date('d M', strtotime($b['created_at'] ?? 'now')) ?></div>
                                </div>
                            </div>
                            <div>
                                <?php if ($isDone): ?>
                                    <span class="file-status-pill pill-selesai">✓ Selesai</span>
                                <?php else: ?>
                                    <span class="file-status-pill pill-diproses">🔄 Diproses</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Sample items matching Foto 3 -->
                    <div class="berkas-row-item">
                        <div class="berkas-file-meta">
                            <div class="berkas-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div class="berkas-file-name">Surat Pengajuan Magang.pdf</div>
                                <div class="berkas-file-subtext">245 KB • Diunggah 12 Okt</div>
                            </div>
                        </div>
                        <div>
                            <span class="file-status-pill pill-selesai">✓ Selesai</span>
                        </div>
                    </div>

                    <div class="berkas-row-item">
                        <div class="berkas-file-meta">
                            <div class="berkas-icon-box">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <div class="berkas-file-name">Transkrip Nilai Sementara.pdf</div>
                                <div class="berkas-file-subtext">1.2 MB • Diunggah 12 Okt</div>
                            </div>
                        </div>
                        <div>
                            <span class="file-status-pill pill-diproses">🔄 Diproses</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- CARD 3: REJECTION / REVISION ALERT CARD (CONTOH TAMPILAN SESUAI FOTO 3) -->
        <div class="rejection-alert-card">
            <div class="rejection-header">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <span>Terdapat Berkas yang Ditolak (Contoh Tampilan)</span>
            </div>
            <p class="rejection-desc">
                Surat pernyataan orang tua tidak menggunakan materai yang sah. Harap perbaiki dan unggah ulang.
            </p>
            <button type="button" class="btn-reupload" id="openReuploadModal">
                Ajukan Ulang Berkas
            </button>
        </div>
    </div>

    <!-- RIGHT COLUMN: BUKTI FISIK -->
    <div>
        <div class="bukti-fisik-card">
            <h2 class="bukti-fisik-title">Bukti Fisik</h2>
            <p class="bukti-fisik-subtext">Foto bukti pengumpulan berkas fisik ke admin jurusan.</p>
            <div class="bukti-fisik-img-wrapper" id="imgBuktiWrapper" title="Klik untuk memperbesar foto">
                <img src="<?= $defaultBuktiImg ?>" alt="Foto Bukti Fisik Berkas" class="bukti-fisik-img" id="imgBuktiPreview">
            </div>
        </div>
    </div>
</div>

<!-- MODAL IMAGE ZOOM -->
<div class="modal-overlay" id="imageModal">
    <div class="modal-content" style="max-width: 800px; text-align: center; padding: 18px;">
        <button type="button" class="modal-close-btn" id="closeImageModal">&times;</button>
        <h3 style="font-size: 15px; font-weight:700; color:#1e293b; margin-bottom: 12px; text-align: left;">
            Foto Bukti Penyerahan Berkas Fisik
        </h3>
        <img src="<?= $defaultBuktiImg ?>" alt="Bukti Fisik" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 8px;">
    </div>
</div>

<!-- MODAL REUPLOAD FORM -->
<div class="modal-overlay" id="reuploadModal">
    <div class="modal-content">
        <button type="button" class="modal-close-btn" id="closeReuploadModal">&times;</button>
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">
            Ajukan Ulang Berkas Perbaikan
        </h3>
        <p style="font-size: 13px; color: #64748b; margin-bottom: 18px;">
            Unggah berkas yang telah diperbaiki sesuai dengan catatan revisi admin.
        </p>

        <form action="<?= site_url('mahasiswa/permohonan/' . ($permohonan['id_permohonan'] ?? 1) . '/reupload') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div style="margin-bottom: 18px;">
                <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 6px;">
                    Pilih Berkas Perbaikan (PDF / Foto Bermaterai)
                </label>
                <input type="file" name="berkas_ulang" required class="form-control" style="padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; width: 100%;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" class="btn-cancel" id="cancelReuploadBtn" style="padding: 8px 16px; border: none; background: #f1f5f9; border-radius: 6px; cursor: pointer;">
                    Batal
                </button>
                <button type="submit" class="btn-submit" style="background-color: #133863; color: #fff; padding: 8px 18px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                    Unggah & Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL INTERACTIVITY SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image Zoom Modal
        const imgWrapper = document.getElementById('imgBuktiWrapper');
        const imageModal = document.getElementById('imageModal');
        const closeImageModal = document.getElementById('closeImageModal');

        if (imgWrapper && imageModal) {
            imgWrapper.addEventListener('click', () => imageModal.classList.add('active'));
            closeImageModal.addEventListener('click', () => imageModal.classList.remove('active'));
            imageModal.addEventListener('click', (e) => {
                if (e.target === imageModal) imageModal.classList.remove('active');
            });
        }

        // Reupload Modal
        const openReupload = document.getElementById('openReuploadModal');
        const reuploadModal = document.getElementById('reuploadModal');
        const closeReupload = document.getElementById('closeReuploadModal');
        const cancelReupload = document.getElementById('cancelReuploadBtn');

        if (openReupload && reuploadModal) {
            openReupload.addEventListener('click', () => reuploadModal.classList.add('active'));
            if (closeReupload) closeReupload.addEventListener('click', () => reuploadModal.classList.remove('active'));
            if (cancelReupload) cancelReupload.addEventListener('click', () => reuploadModal.classList.remove('active'));
            reuploadModal.addEventListener('click', (e) => {
                if (e.target === reuploadModal) reuploadModal.classList.remove('active');
            });
        }
    });
</script>

<?= $this->endSection() ?>
