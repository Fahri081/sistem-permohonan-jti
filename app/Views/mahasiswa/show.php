<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


    /* STATUS PROSES TIMELINE */
    .status-timeline-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px 28px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        margin-bottom: 24px;
    }

    .status-timeline {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-top: 4px;
    }

    .status-step {
        position: relative;
        display: grid;
        grid-template-columns: 28px 1fr;
        gap: 12px;
        min-height: 68px;
    }

    .status-step:last-child {
        min-height: 0;
    }

    .status-step-marker-wrap {
        position: relative;
        display: flex;
        justify-content: center;
    }

    .status-step:not(:last-child) .status-step-marker-wrap::after {
        content: "";
        position: absolute;
        top: 25px;
        bottom: 0;
        width: 2px;
        background: #e2e8f0;
    }

    .status-step.completed:not(:last-child) .status-step-marker-wrap::after,
    .status-step.current:not(:last-child) .status-step-marker-wrap::after {
        background: #133863;
    }

    .status-step-marker {
        position: relative;
        z-index: 1;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #cbd5e1;
        background: #ffffff;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        box-sizing: border-box;
    }

    .status-step.completed .status-step-marker,
    .status-step.current .status-step-marker {
        border-color: #133863;
        background: #133863;
        color: #ffffff;
    }

    .status-step-content {
        padding-bottom: 18px;
    }

    .status-step:last-child .status-step-content {
        padding-bottom: 0;
    }

    .status-step-title {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        line-height: 1.3;
    }

    .status-step.completed .status-step-title,
    .status-step.current .status-step-title {
        color: #133863;
    }

    .status-step-description {
        margin-top: 3px;
        font-size: 11.5px;
        color: #94a3b8;
        line-height: 1.45;
    }

    .status-step.current .status-step-description {
        color: #64748b;
    }

    .status-current-badge {
        display: inline-flex;
        align-items: center;
        margin-left: 6px;
        padding: 2px 7px;
        border-radius: 999px;
        background: #e0f2fe;
        color: #0284c7;
        font-size: 10px;
        font-weight: 700;
        vertical-align: 1px;
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

    /* MODAL FOR IMAGE ZOOM */
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


    .bukti-fisik-edit-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 16px;
    }

    .btn-edit-bukti {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #133863;
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-edit-bukti:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .edit-bukti-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 12px;
        margin: 16px 0 18px;
    }

    .edit-bukti-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px;
        background: #ffffff;
        transition: opacity .15s ease, border-color .15s ease;
    }

    .edit-bukti-card.is-removed {
        opacity: .45;
        border-color: #fecaca;
    }

    .edit-bukti-card img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
        border: 1px solid #e2e8f0;
        margin-bottom: 8px;
    }

    .edit-bukti-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .edit-bukti-label {
        min-width: 0;
        font-size: 11.5px;
        color: #475569;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-remove-existing {
        border: 0;
        background: #fff1f2;
        color: #dc2626;
        padding: 5px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        flex-shrink: 0;
    }

    /* =========================================
   UPLOAD BOX - UBAH BUKTI FISIK
========================================= */

.edit-upload-box {
    display: block;
    width: 100%;
    box-sizing: border-box;

    min-height: 120px;

    border: 2px dashed #cbd5e1;
    border-radius: 10px;

    background: #f8fafc;

    padding: 22px 16px;

    text-align: center;

    cursor: pointer;

    transition:
        border-color 0.15s ease,
        background-color 0.15s ease;
}

.edit-upload-box:hover {
    border-color: #1d4e8c;
    background: #f0f7ff;
}

.edit-upload-box strong,
.edit-upload-box span {
    display: block;
}

.edit-upload-box strong {
    color: #334155;
    font-size: 13px;
    margin-bottom: 4px;
}

.edit-upload-box span {
    color: #94a3b8;
    font-size: 11.5px;
    line-height: 1.5;
}

.edit-upload-box span:last-child {
    margin-top: 8px;
    color: #64748b;
}

.edit-upload-box input {
    margin-top: 10px;
    width: 100%;
}

    .edit-bukti-counter {
        font-size: 12px;
        color: #64748b;
        margin-top: 10px;
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


    .pickup-upload-area {
        margin-top: 14px;
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 20px 18px;
        background: #f8fafc;
        text-align: center;
        cursor: pointer;
        transition: .18s ease;
        outline: none;
    }

    .pickup-upload-area:hover,
    .pickup-upload-area:focus {
        border-color: #1d4e8c;
        background: #f0f7ff;
    }

    .pickup-upload-icon {
        width: 34px;
        height: 34px;
        margin: 0 auto 8px;
        border-radius: 10px;
        background: #eaf2ff;
        color: #1d4e8c;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
    }

    .pickup-upload-area strong {
        display: block;
        color: #334155;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .pickup-upload-area span,
    .pickup-upload-area small {
        display: block;
        color: #94a3b8;
        font-size: 11.5px;
        line-height: 1.55;
    }

    .pickup-upload-area small {
        margin-top: 7px;
        color: #64748b;
    }

    .pickup-selection-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 14px;
        padding: 11px 12px;
        border: 1px solid #dbe5f0;
        border-radius: 10px;
        background: #fff;
    }

    .pickup-selection-summary strong,
    .pickup-selection-summary span {
        display: block;
    }

    .pickup-selection-summary strong {
        color: #334155;
        font-size: 12.5px;
    }

    .pickup-selection-summary span {
        margin-top: 2px;
        color: #94a3b8;
        font-size: 11px;
    }

    .pickup-preview-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-top: 12px;
    }

    .pickup-preview-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #dbe5f0;
        border-radius: 11px;
        background: #fff;
    }

    .pickup-preview-card img {
        width: 100%;
        aspect-ratio: 1 / 1;
        display: block;
        object-fit: cover;
        background: #eef2f7;
    }

    .pickup-preview-meta {
        padding: 8px;
    }

    .pickup-preview-name {
        color: #475569;
        font-size: 10.5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .pickup-preview-buttons {
        display: flex;
        gap: 6px;
        margin-top: 7px;
    }

    .pickup-preview-buttons button {
        flex: 1;
        border: 0;
        border-radius: 7px;
        padding: 6px 7px;
        font-size: 10.5px;
        font-weight: 700;
        cursor: pointer;
    }

    .pickup-preview-btn {
        background: #eef4ff;
        color: #1d4e8c;
    }

    .pickup-replace-btn {
        background: #f1f5f9;
        color: #475569;
    }

    .pickup-preview-remove {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 27px;
        height: 27px;
        border: 0;
        border-radius: 50%;
        background: rgba(15, 23, 42, .78);
        color: #fff;
        font-size: 15px;
        cursor: pointer;
    }

    .pickup-preview-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 10px;
    }

    .pickup-secondary-btn,
    .pickup-danger-btn {
        border: 0;
        border-radius: 8px;
        padding: 8px 11px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .pickup-secondary-btn {
        background: #eef4ff;
        color: #1d4e8c;
    }

    .pickup-danger-btn {
        background: #fff1f2;
        color: #be123c;
    }

    .pickup-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
        background: rgba(15, 23, 42, .72);
    }

    .pickup-modal.is-open {
        display: flex;
    }

    .pickup-modal-card {
        width: min(760px, 100%);
        max-height: 92vh;
        overflow: hidden;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .24);
    }

    .pickup-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .pickup-modal-header strong {
        color: #1e293b;
        font-size: 13px;
    }

    .pickup-modal-close {
        border: 0;
        background: transparent;
        color: #64748b;
        font-size: 22px;
        cursor: pointer;
        line-height: 1;
    }

    .pickup-modal-body {
        padding: 16px;
        max-height: calc(92vh - 60px);
        overflow: auto;
    }

    .pickup-modal-image {
        width: 100%;
        max-height: 68vh;
        display: block;
        object-fit: contain;
        border-radius: 10px;
        background: #0f172a;
    }

    .pickup-modal-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 12px;
    }

    .pickup-modal-footer span {
        min-width: 52px;
        text-align: center;
        color: #64748b;
        font-size: 11.5px;
        font-weight: 700;
    }

    .pickup-secondary-btn:disabled {
        opacity: .45;
        cursor: not-allowed;
    }

    @media (max-width: 760px) {
        .pickup-preview-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* =========================================================
   EDIT BUKTI FISIK - RESPONSIVE HP
========================================================= */

@media (max-width: 600px) {

    .edit-bukti-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .edit-bukti-card {
        padding: 7px;
        border-radius: 9px;
    }

    .edit-bukti-card img {
        height: 105px;
        border-radius: 7px;
    }

    .edit-bukti-meta {
        gap: 5px;
        align-items: center;
    }

    .edit-bukti-label {
        font-size: 10.5px;
    }

    .btn-remove-existing {
        padding: 6px 7px;
        font-size: 10px;
        min-height: 32px;
    }

    .edit-upload-box {
        display: block;
        width: 100%;
        box-sizing: border-box;
        min-height: 110px;
        padding: 20px 14px;
    }

    .edit-bukti-counter {
        font-size: 11px;
        line-height: 1.5;
    }

    #editBuktiForm > div:last-child {
        flex-direction: column;
    }

    #editBuktiForm > div:last-child button {
        width: 100%;
        min-height: 42px;
    }

}

</style>

<?php
    $idPermohonan = (int) ($permohonan['id_permohonan'] ?? 0);
    $reqIdDisplay = $idPermohonan > 0
        ? ('REQ-2023-' . str_pad($idPermohonan, 4, '0', STR_PAD_LEFT))
        : '-';

    $statusRaw = strtoupper((string) ($permohonan['nama_status'] ?? ''));
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
    } elseif ($statusRaw === 'MENUNGGU VERIFIKASI PENGAMBILAN') {
        $statusClass = 'badge-diproses-lg';
        $statusIcon = '⏳';
        $statusText = 'Menunggu Verifikasi Pengambilan';
    } elseif ($statusRaw === 'DIAMBIL') {
        $statusClass = 'badge-selesai-lg';
        $statusIcon = '✓';
        $statusText = 'Diambil';
    }

    $tglPengajuan = !empty($permohonan['tanggal_pengajuan'])
        ? date('d F Y, H:i \W\I\B', strtotime($permohonan['tanggal_pengajuan']))
        : '-';

    $tujuanDisplay = !empty($permohonan['nama_tujuan'])
        ? $permohonan['nama_tujuan']
        : '-';

    $keperluanDisplay = !empty($permohonan['keperluan'])
        ? $permohonan['keperluan']
        : '-';

    $deskripsiDisplay = !empty($permohonan['deskripsi'])
        ? $permohonan['deskripsi']
        : 'Tidak ada deskripsi tambahan.';


    $statusId = (int) ($permohonan['id_status'] ?? 0);

$statusTimeline = [
    1 => [
        'title' => 'Diajukan',
        'description' => 'Permohonan berhasil dikirim dan menunggu pemeriksaan admin.',
    ],
    2 => [
        'title' => 'Diproses',
        'description' => 'Admin sedang memeriksa permohonan yang diajukan.',
    ],
    4 => [
        'title' => 'Selesai',
        'description' => 'Permohonan telah selesai diproses dan siap diambil.',
    ],
    5 => [
        'title' => 'Diambil',
        'description' => 'Dokumen telah diambil dan bukti pengambilan telah dikonfirmasi.',
    ],
];

    if ($statusId === 3) {
        $statusTimeline = [
            1 => [
                'title' => 'Diajukan',
                'description' => 'Permohonan berhasil dikirim.',
            ],
            2 => [
                'title' => 'Diproses',
                'description' => 'Admin telah memeriksa permohonan.',
            ],
            3 => [
                'title' => 'Ditolak',
                'description' => 'Permohonan memerlukan perbaikan dari mahasiswa.',
            ],
        ];
    }

    $timelineKeys = array_keys($statusTimeline);
    $currentTimelineIndex = array_search($statusId, $timelineKeys, true);
    $currentTimelineIndex = $currentTimelineIndex === false ? 0 : $currentTimelineIndex;

    $buktiFisik = is_array($buktiFisik ?? null) ? $buktiFisik : [];
    $totalBuktiFisik = count($buktiFisik);
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
                    <div class="info-item-label">Deskripsi</div>
                    <div class="info-item-value"><?= esc($deskripsiDisplay) ?></div>
                </div>
            </div>
        </div>

        <!-- STATUS PROSES -->
        <div class="status-timeline-card">
            <h2 class="detail-card-title" style="margin-bottom:18px;">Status Proses</h2>

            <div class="status-timeline">
                <?php foreach ($statusTimeline as $stepId => $step): ?>
                    <?php
                        $stepIndex = array_search($stepId, $timelineKeys, true);
                        $isCurrent = ((int) $stepId === $statusId);
                        $isCompleted = $stepIndex !== false && $stepIndex < $currentTimelineIndex;
                        $stepClass = $isCurrent
                            ? 'current'
                            : ($isCompleted ? 'completed' : '');
                    ?>

                    <div class="status-step <?= $stepClass ?>">
                        <div class="status-step-marker-wrap">
                            <div class="status-step-marker">
                                <?= $isCompleted ? '✓' : ($isCurrent ? '•' : '') ?>
                            </div>
                        </div>

                        <div class="status-step-content">
                            <div class="status-step-title">
                                <?= esc($step['title']) ?>
                                <?php if ($isCurrent): ?>
                                    <span class="status-current-badge">Status saat ini</span>
                                <?php endif; ?>
                            </div>

                            <div class="status-step-description">
                                <?= esc($step['description']) ?>
                                <?php if ((int) $stepId === 1 && ! empty($permohonan['tanggal_pengajuan'])): ?>
                                    • <?= esc(date('d M Y, H:i', strtotime($permohonan['tanggal_pengajuan']))) ?> WIB
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (in_array($statusRaw, ['SELESAI', 'MENUNGGU VERIFIKASI PENGAMBILAN', 'DIAMBIL'], true)): ?>
            <div class="detail-card" style="margin-top:18px;border:1px solid #dbe5f0;background:#fbfdff;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;">
                    <div>
                        <h2 class="detail-card-title" style="margin-bottom:6px;">Pengambilan Dokumen</h2>
                        <p style="margin:0;color:#64748b;font-size:12.5px;line-height:1.55;">
                            Konfirmasi pengambilan dokumen dengan mengunggah foto sebagai bukti.
                        </p>
                    </div>
                    <?php if ($statusRaw === 'DIAMBIL'): ?>
                        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:999px;background:#ecfdf3;color:#047857;font-size:11px;font-weight:700;white-space:nowrap;">✓ Sudah diambil</span>
                    <?php elseif ($statusRaw === 'MENUNGGU VERIFIKASI PENGAMBILAN'): ?>
                        <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:999px;background:#fff7ed;color:#b45309;font-size:11px;font-weight:700;white-space:nowrap;">⏳ Menunggu verifikasi</span>
                    <?php endif; ?>
                </div>

                <?php $buktiPengambilan = is_array($buktiPengambilan ?? null) ? $buktiPengambilan : null; ?>

                <?php if ($buktiPengambilan && ! empty($buktiPengambilan['nama_file'])): ?>
                    <div style="margin-top:14px;">
                        <img src="<?= esc(base_url('uploads/bukti_pengambilan/' . $buktiPengambilan['nama_file'])) ?>" alt="Bukti Pengambilan" style="width:100%;max-height:280px;object-fit:cover;border-radius:12px;border:1px solid #e2e8f0;display:block;">
                        <?php if (($buktiPengambilan['status_verifikasi'] ?? '') === 'ditolak'): ?>
                            <div style="margin-top:10px;padding:10px 12px;border-radius:9px;background:#fff1f2;color:#991b1b;font-size:12px;line-height:1.5;">
                                <strong>Bukti sebelumnya ditolak.</strong>
                                <?php if (! empty($buktiPengambilan['keterangan'])): ?><?= nl2br(esc($buktiPengambilan['keterangan'])) ?><?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($statusRaw === 'SELESAI'): ?>
                    <form
                        action="<?= site_url('mahasiswa/permohonan/' . $idPermohonan . '/pengambilan') ?>"
                        method="post"
                        enctype="multipart/form-data"
                        id="pickupUploadForm"
                        style="margin-top:14px;"
                    >
                        <?= csrf_field() ?>

                        <div
                            id="pickupUploadArea"
                            class="pickup-upload-area"
                            role="button"
                            tabindex="0"
                            aria-controls="pickupFileInput"
                            aria-label="Pilih foto bukti pengambilan"
                        >
                            <div class="pickup-upload-icon">↑</div>
                            <strong>Tambah Foto Bukti Pengambilan</strong>
                            <span>JPG, JPEG, PNG atau WEBP • maksimal 5 MB per foto • maksimal 10 foto</span>
                            <small>Klik area ini untuk memilih beberapa foto sekaligus</small>
                        </div>

                        <input
                            type="file"
                            name="bukti_pengambilan[]"
                            id="pickupFileInput"
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            multiple
                            style="display:none;"
                        >

                        <div id="pickupSelectionSummary" class="pickup-selection-summary" hidden>
                            <div>
                                <strong id="pickupSelectionCount">0 foto dipilih</strong>
                                <span>Periksa foto sebelum dikirim.</span>
                            </div>
                            <button type="button" id="pickupChooseMore" class="pickup-secondary-btn">
                                + Tambah Foto
                            </button>
                        </div>

                        <div id="pickupPreviewGrid" class="pickup-preview-grid"></div>

                        <div id="pickupPreviewActions" class="pickup-preview-actions" hidden>
                            <button type="button" id="pickupPreviewAll" class="pickup-secondary-btn">
                                Lihat Preview
                            </button>
                            <button type="button" id="pickupClearAll" class="pickup-danger-btn">
                                Hapus Semua
                            </button>
                        </div>

                        <div style="display:flex;justify-content:flex-end;margin-top:12px;">
                            <button
                                type="submit"
                                id="pickupSubmitButton"
                                disabled
                                style="background:#133863;color:#fff;padding:9px 16px;border:0;border-radius:8px;cursor:pointer;font-weight:700;opacity:.5;"
                            >
                                Kirim Konfirmasi Pengambilan
                            </button>
                        </div>
                    </form>
                <?php elseif ($statusRaw === 'MENUNGGU VERIFIKASI PENGAMBILAN'): ?>
                    <div style="margin-top:14px;padding:11px 12px;border-radius:9px;background:#fffbeb;color:#92400e;font-size:12px;line-height:1.5;">Bukti pengambilan sudah dikirim. Tunggu verifikasi admin sebelum status berubah menjadi <strong>Diambil</strong>.</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (
            $statusRaw === 'DITOLAK' ||
            ! empty($permohonan['keterangan_penolakan'])
        ): ?>
            <div class="rejection-alert-card">
                <div class="rejection-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Permohonan Ditolak</span>
                </div>
                <p class="rejection-desc">
                    <?= ! empty($permohonan['keterangan_penolakan'])
                        ? nl2br(esc($permohonan['keterangan_penolakan']))
                        : 'Admin meminta perbaikan pada berkas permohonan.' ?>
                </p>
                <?php if (in_array($statusRaw, ['DIAJUKAN', 'DITOLAK'], true)): ?>
                    <button
                        type="button"
                        class="btn-edit-bukti"
                        id="openEditBuktiModal"
                        onclick="document.getElementById('editBuktiModal').classList.add('active');"
                    >
                        <span>✎</span>
                        <span><?= $statusRaw === 'DITOLAK' ? 'Perbaiki Bukti Fisik' : 'Ubah Bukti Fisik' ?></span>
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT COLUMN: BUKTI FISIK -->
    <div>
        <div class="bukti-fisik-card">
            <h2 class="bukti-fisik-title">Bukti Fisik</h2>
            <p class="bukti-fisik-subtext">
                Foto bukti pengumpulan berkas fisik ke admin jurusan.
                <?= $totalBuktiFisik > 0 ? '(' . $totalBuktiFisik . ' foto)' : '' ?>
            </p>

            <?php if (! empty($buktiFisik)): ?>
                <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;">
                    <?php foreach ($buktiFisik as $index => $foto): ?>
                        <?php
                            $namaFoto = $foto['nama_file'] ?? '';
                            $fotoUrl = $namaFoto !== ''
                                ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                : '';
                        ?>
                        <?php if ($fotoUrl): ?>
                            <button
                                type="button"
                                class="bukti-fisik-img-wrapper"
                                data-image="<?= esc($fotoUrl) ?>"
                                data-index="<?= $index + 1 ?>"
                                title="Klik untuk memperbesar foto"
                                style="border:0;padding:0;background:none;width:100%;"
                            >
                                <img
                                    src="<?= esc($fotoUrl) ?>"
                                    alt="Foto Bukti Fisik <?= $index + 1 ?>"
                                    class="bukti-fisik-img"
                                    style="height:175px;"
                                >
                            </button>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="padding:28px 12px;text-align:center;border:1px dashed #cbd5e1;border-radius:10px;background:#f8fafc;">
                    <div style="font-size:26px;margin-bottom:8px;">📷</div>
                    <strong style="display:block;color:#334155;font-size:13px;margin-bottom:4px;">Foto belum tersedia</strong>
                    <span style="font-size:12px;color:#64748b;">Mahasiswa belum mengunggah bukti fisik.</span>
                </div>
            <?php endif; ?>

            <?php if (in_array($statusRaw, ['DIAJUKAN', 'DITOLAK'], true)): ?>
                <div class="bukti-fisik-edit-actions">
                    <button type="button" class="btn-edit-bukti" id="openEditBuktiModal" onclick="document.getElementById('editBuktiModal').classList.add('active');">
                        <span>✎</span>
                        <span>Ubah Bukti Fisik</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- MODAL IMAGE ZOOM -->
<div class="modal-overlay" id="imageModal">
    <div class="modal-content" style="max-width: 900px; text-align: center; padding: 18px;">
        <button type="button" class="modal-close-btn" id="closeImageModal">&times;</button>
        <h3 id="imageModalTitle" style="font-size: 15px; font-weight:700; color:#1e293b; margin-bottom: 12px; text-align: left;">
            Foto Bukti Penyerahan Berkas Fisik
        </h3>
        <img id="imageModalPreview" src="" alt="Bukti Fisik" style="width: 100%; max-height: 70vh; object-fit: contain; border-radius: 8px;">
    </div>
</div>


<!-- MODAL EDIT BUKTI FISIK -->
<?php if (in_array($statusRaw, ['DIAJUKAN', 'DITOLAK'], true)): ?>
<div class="modal-overlay" id="editBuktiModal">
    <div class="modal-content" style="max-width:760px;">
        <button type="button" class="modal-close-btn" id="closeEditBuktiModal" onclick="document.getElementById('editBuktiModal').classList.remove('active');">&times;</button>

        <h3 style="font-size:16px;font-weight:700;color:#1e293b;margin-bottom:8px;">
            Ubah Bukti Fisik
        </h3>

        <p style="font-size:13px;color:#64748b;line-height:1.45;margin-bottom:16px;">
            Hapus foto yang salah, pertahankan foto yang benar, atau tambahkan foto yang kurang.
        </p>

        <form
            action="<?= site_url('mahasiswa/permohonan/' . ($permohonan['id_permohonan'] ?? 0) . '/bukti-fisik') ?>"
            method="POST"
            enctype="multipart/form-data"
            id="editBuktiForm"
        >
            <?= csrf_field() ?>

            <?php if (! empty($buktiFisik)): ?>
                <div class="edit-bukti-grid" id="editBuktiGrid">
                    <?php foreach ($buktiFisik as $index => $foto): ?>
                        <?php
                            $idBukti = (int) ($foto['id_bukti'] ?? 0);
                            $namaFoto = (string) ($foto['nama_file'] ?? '');
                            $fotoUrl = $namaFoto !== ''
                                ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                : '';
                        ?>
                        <?php if ($idBukti > 0 && $fotoUrl): ?>
                            <div class="edit-bukti-card" data-bukti-card="<?= $idBukti ?>">
                                <img src="<?= esc($fotoUrl) ?>" alt="Bukti Fisik <?= $index + 1 ?>">

                                <div class="edit-bukti-meta">
                                    <span class="edit-bukti-label" title="<?= esc($namaFoto) ?>">
                                        Foto <?= $index + 1 ?>
                                    </span>

                                    <button
                                        type="button"
                                        class="btn-remove-existing"
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

            <label for="fotoBuktiTambahan" class="edit-upload-box">
                <strong style="display:block;color:#334155;font-size:13px;margin-bottom:4px;">
                    Tambahkan foto
                </strong>
                <span style="display:block;color:#94a3b8;font-size:11.5px;">
                    JPG, JPEG, PNG atau WEBP • maksimal 5 MB per foto
                </span>
                <span style="display:block;color:#64748b;font-size:11.5px;margin-top:8px;">
                    Klik area ini untuk memilih foto
                </span>
            </label>
            <input
                type="file"
                name="foto_bukti_tambahan[]"
                id="fotoBuktiTambahan"
                accept="image/png,image/jpeg,image/jpg,image/webp"
                multiple
                style="display:none;"
            >

            <div class="edit-bukti-counter" id="editBuktiCounter"></div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                <button
                    type="button"
                    id="cancelEditBuktiBtn"
                    onclick="document.getElementById('editBuktiModal').classList.remove('active');"
                    style="padding:9px 15px;border:0;background:#f1f5f9;color:#64748b;border-radius:7px;cursor:pointer;font-weight:600;"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    style="background:#133863;color:#fff;padding:9px 18px;border:0;border-radius:7px;cursor:pointer;font-weight:600;"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- MODAL REUPLOAD FORM -->


<!-- MODAL INTERACTIVITY SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image gallery / zoom
        const imageModal = document.getElementById('imageModal');
        const imageModalPreview = document.getElementById('imageModalPreview');
        const imageModalTitle = document.getElementById('imageModalTitle');
        const closeImageModal = document.getElementById('closeImageModal');

        document.querySelectorAll('.bukti-fisik-img-wrapper[data-image]').forEach(function(button) {
            button.addEventListener('click', function() {
                if (!imageModal || !imageModalPreview) return;

                imageModalPreview.src = this.dataset.image || '';
                if (imageModalTitle) {
                    imageModalTitle.textContent =
                        'Foto Bukti Penyerahan Berkas Fisik #' + (this.dataset.index || '');
                }

                imageModal.classList.add('active');
            });
        });

        if (imageModal && closeImageModal) {
            closeImageModal.addEventListener('click', () => {
                imageModal.classList.remove('active');
                imageModalPreview.src = '';
            });

            imageModal.addEventListener('click', (e) => {
                if (e.target === imageModal) {
                    imageModal.classList.remove('active');
                    imageModalPreview.src = '';
                }
            });
        }

        // =========================================================
// EDIT / PERBAIKI BUKTI FISIK
// =========================================================

const editBuktiModal = document.getElementById('editBuktiModal');
const openEditBuktiModal = document.getElementById('openEditBuktiModal');
const closeEditBuktiModal = document.getElementById('closeEditBuktiModal');
const cancelEditBuktiBtn = document.getElementById('cancelEditBuktiBtn');
const editBuktiForm = document.getElementById('editBuktiForm');
const fotoBuktiTambahan = document.getElementById('fotoBuktiTambahan');
const editBuktiCounter = document.getElementById('editBuktiCounter');
const editBuktiGrid = document.getElementById('editBuktiGrid');

const MAX_FOTO_EDIT = 10;
const MAX_SIZE_EDIT = 5 * 1024 * 1024;

const ALLOWED_TYPES_EDIT = [
    'image/jpeg',
    'image/png',
    'image/jpg',
    'image/webp'
];

let editSelectedFiles = [];


/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

// Hanya hitung foto lama yang MASIH dipertahankan
function getKeepCount() {
    if (!editBuktiForm) return 0;

    return editBuktiForm.querySelectorAll(
        'input[name="keep_bukti[]"]:not(:disabled)'
    ).length;
}


// Sinkronkan array file JS dengan input file HTML
function syncEditFileInput() {
    if (!fotoBuktiTambahan) return;

    const dt = new DataTransfer();

    editSelectedFiles.forEach(function (file) {
        dt.items.add(file);
    });

    fotoBuktiTambahan.files = dt.files;
}


// Tampilkan jumlah foto
function updateEditBuktiCounter() {
    if (!editBuktiCounter) return;

    const total = getKeepCount() + editSelectedFiles.length;

    editBuktiCounter.textContent =
        total +
        ' foto akan disimpan. Maksimal ' +
        MAX_FOTO_EDIT +
        ' foto.';
}


// Pesan SweetAlert
function showEditMessage(icon, title, text) {
    if (window.Swal) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text
        });
    } else {
        alert(title + '\n' + text);
    }
}


/*
|--------------------------------------------------------------------------
| Preview foto baru
|--------------------------------------------------------------------------
*/

function renderNewPhotoPreviews() {

    if (!editBuktiGrid) return;

    // Hapus preview foto baru yang lama
    editBuktiGrid
        .querySelectorAll('[data-new-photo-card]')
        .forEach(function (card) {
            card.remove();
        });

    editSelectedFiles.forEach(function (file, index) {

        const card = document.createElement('div');

        card.className = 'edit-bukti-card';
        card.setAttribute('data-new-photo-card', index);

        const image = document.createElement('img');

        image.alt = 'Foto Baru ' + (index + 1);

        // Preview menggunakan FileReader
        const reader = new FileReader();

        reader.onload = function (event) {
            image.src = event.target.result;
        };

        reader.readAsDataURL(file);


        /*
        |--------------------------------------------------------------------------
        | Meta
        |--------------------------------------------------------------------------
        */

        const meta = document.createElement('div');

        meta.className = 'edit-bukti-meta';


        const label = document.createElement('span');

        label.className = 'edit-bukti-label';

        label.textContent = 'Foto Baru ' + (index + 1);

        label.title = file.name;


        /*
        |--------------------------------------------------------------------------
        | Hapus foto baru
        |--------------------------------------------------------------------------
        */

        const removeButton = document.createElement('button');

        removeButton.type = 'button';

        removeButton.className = 'btn-remove-existing';

        removeButton.textContent = 'Hapus';


        removeButton.addEventListener('click', function () {

            editSelectedFiles.splice(index, 1);

            syncEditFileInput();

            renderNewPhotoPreviews();

            updateEditBuktiCounter();
        });


        meta.appendChild(label);
        meta.appendChild(removeButton);

        card.appendChild(image);
        card.appendChild(meta);

        editBuktiGrid.appendChild(card);
    });
}


/*
|--------------------------------------------------------------------------
| Reset ketika modal dibuka
|--------------------------------------------------------------------------
*/

function resetEditSelection() {

    editSelectedFiles = [];

    if (fotoBuktiTambahan) {
        fotoBuktiTambahan.value = '';
    }

    syncEditFileInput();


    // Pulihkan semua foto lama
    if (editBuktiForm) {

        editBuktiForm
            .querySelectorAll('[data-remove-bukti]')
            .forEach(function (button) {

                const id = button.dataset.removeBukti;

                const card = editBuktiForm.querySelector(
                    '[data-bukti-card="' + id + '"]'
                );

                const hidden = editBuktiForm.querySelector(
                    '[data-keep-input="' + id + '"]'
                );

                if (card) {
                    card.classList.remove('is-removed');
                }

                if (hidden) {
                    hidden.disabled = false;
                }

                button.textContent = 'Hapus';
            });
    }


    // Hapus preview foto baru
    if (editBuktiGrid) {

        editBuktiGrid
            .querySelectorAll('[data-new-photo-card]')
            .forEach(function (card) {
                card.remove();
            });
    }


    updateEditBuktiCounter();
}


/*
|--------------------------------------------------------------------------
| Buka modal
|--------------------------------------------------------------------------
*/

if (openEditBuktiModal && editBuktiModal) {

    openEditBuktiModal.addEventListener('click', function () {

        resetEditSelection();

        editBuktiModal.classList.add('active');
    });
}


/*
|--------------------------------------------------------------------------
| Tutup modal
|--------------------------------------------------------------------------
*/

if (closeEditBuktiModal && editBuktiModal) {

    closeEditBuktiModal.addEventListener('click', function () {

        editBuktiModal.classList.remove('active');
    });
}


if (cancelEditBuktiBtn && editBuktiModal) {

    cancelEditBuktiBtn.addEventListener('click', function () {

        editBuktiModal.classList.remove('active');
    });
}


if (editBuktiModal) {

    editBuktiModal.addEventListener('click', function (e) {

        if (e.target === editBuktiModal) {

            editBuktiModal.classList.remove('active');
        }
    });
}


/*
|--------------------------------------------------------------------------
| Tombol Hapus foto lama
|--------------------------------------------------------------------------
*/

if (editBuktiForm) {

    editBuktiForm
        .querySelectorAll('[data-remove-bukti]')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const id = this.dataset.removeBukti;

                const card = editBuktiForm.querySelector(
                    '[data-bukti-card="' + id + '"]'
                );

                const hidden = editBuktiForm.querySelector(
                    '[data-keep-input="' + id + '"]'
                );

                if (!card || !hidden) return;


                // Kalau sedang dipertahankan → hapus
                if (!hidden.disabled) {

                    hidden.disabled = true;

                    card.classList.add('is-removed');

                    this.textContent = 'Pertahankan';

                }

                // Kalau sudah dihapus → kembalikan
                else {

                    hidden.disabled = false;

                    card.classList.remove('is-removed');

                    this.textContent = 'Hapus';
                }


                updateEditBuktiCounter();
            });
    });
}


/*
|--------------------------------------------------------------------------
| Pilih foto baru
|--------------------------------------------------------------------------
*/

if (fotoBuktiTambahan) {

    fotoBuktiTambahan.addEventListener('change', function () {

        const currentKeep = getKeepCount();

        const incomingFiles = Array.from(this.files || []);


        for (const file of incomingFiles) {

            // Validasi format
            if (!ALLOWED_TYPES_EDIT.includes(file.type)) {

                showEditMessage(
                    'error',
                    'Format tidak didukung',
                    file.name +
                    ' harus berupa JPG, JPEG, PNG, atau WEBP.'
                );

                continue;
            }


            // Validasi ukuran
            if (file.size > MAX_SIZE_EDIT) {

                showEditMessage(
                    'error',
                    'Ukuran terlalu besar',
                    file.name +
                    ' melebihi batas 5 MB.'
                );

                continue;
            }


            // Cek duplikat
            const duplicate = editSelectedFiles.some(function (existing) {

                return (
                    existing.name === file.name &&
                    existing.size === file.size &&
                    existing.lastModified === file.lastModified
                );
            });


            if (duplicate) {
                continue;
            }


            // Cek maksimal 10 foto
            if (
                currentKeep +
                editSelectedFiles.length >=
                MAX_FOTO_EDIT
            ) {

                showEditMessage(
                    'warning',
                    'Batas foto tercapai',
                    'Maksimal ' +
                    MAX_FOTO_EDIT +
                    ' foto yang dapat disimpan.'
                );

                break;
            }


            editSelectedFiles.push(file);
        }


        // Sinkronkan input
        syncEditFileInput();


        // Tampilkan preview foto baru
        renderNewPhotoPreviews();


        // Update counter
        updateEditBuktiCounter();
    });
}


/*
|--------------------------------------------------------------------------
| Submit
|--------------------------------------------------------------------------
*/

if (editBuktiForm) {

    editBuktiForm.addEventListener('submit', function (e) {

        const total =
            getKeepCount() +
            editSelectedFiles.length;


        if (total < 1) {

            e.preventDefault();

            showEditMessage(
                'warning',
                'Bukti fisik belum ada',
                'Pertahankan minimal satu foto atau tambahkan foto baru.'
            );

            return;
        }


        if (total > MAX_FOTO_EDIT) {

            e.preventDefault();

            showEditMessage(
                'warning',
                'Terlalu banyak foto',
                'Maksimal ' +
                MAX_FOTO_EDIT +
                ' foto yang dapat disimpan.'
            );

            return;
        }


        // Pastikan file baru ikut terkirim
        syncEditFileInput();
    });
}


/*
|--------------------------------------------------------------------------
| Counter awal
|--------------------------------------------------------------------------
*/

updateEditBuktiCounter();

    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('pickupUploadForm');
    const input = document.getElementById('pickupFileInput');
    const uploadArea = document.getElementById('pickupUploadArea');
    const chooseMore = document.getElementById('pickupChooseMore');
    const grid = document.getElementById('pickupPreviewGrid');
    const summary = document.getElementById('pickupSelectionSummary');
    const countText = document.getElementById('pickupSelectionCount');
    const actions = document.getElementById('pickupPreviewActions');
    const previewAll = document.getElementById('pickupPreviewAll');
    const clearAll = document.getElementById('pickupClearAll');
    const submitButton = document.getElementById('pickupSubmitButton');

    if (!form || !input || !uploadArea || !grid || !summary || !actions || !submitButton) {
        return;
    }

    const MAX_FILES = 10;
    const MAX_SIZE = 5 * 1024 * 1024;
    const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

    let selectedFiles = [];
    let modalCurrentIndex = 0;
    let modalObjectUrl = null;

    function isDuplicate(file, currentFiles) {
        return currentFiles.some(existing =>
            existing.name === file.name &&
            existing.size === file.size &&
            existing.lastModified === file.lastModified
        );
    }

    function syncInputFiles() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
    }

    function ensurePreviewModal() {
        let modal = document.getElementById('pickupPreviewModal');

        if (modal) {
            return modal;
        }

        modal = document.createElement('div');
        modal.id = 'pickupPreviewModal';
        modal.className = 'pickup-modal';
        modal.innerHTML = `
            <div class="pickup-modal-card" role="dialog" aria-modal="true" aria-label="Preview foto bukti pengambilan">
                <div class="pickup-modal-header">
                    <strong id="pickupModalTitle">Preview Foto</strong>
                    <button type="button" class="pickup-modal-close" id="pickupModalClose" aria-label="Tutup preview">×</button>
                </div>
                <div class="pickup-modal-body">
                    <img id="pickupModalImage" class="pickup-modal-image" src="" alt="Preview Bukti Pengambilan">
                    <div class="pickup-modal-footer">
                        <button type="button" id="pickupModalPrev" class="pickup-secondary-btn">← Sebelumnya</button>
                        <span id="pickupModalCounter">1 / 1</span>
                        <button type="button" id="pickupModalNext" class="pickup-secondary-btn">Berikutnya →</button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        const close = function () {
            modal.classList.remove('is-open');
            if (modalObjectUrl) {
                URL.revokeObjectURL(modalObjectUrl);
                modalObjectUrl = null;
            }
        };

        modal.addEventListener('click', function (event) {
            if (event.target === modal || event.target.id === 'pickupModalClose') {
                close();
            }
        });

        document.getElementById('pickupModalPrev').addEventListener('click', function () {
            if (! selectedFiles.length) return;
            modalCurrentIndex = (modalCurrentIndex - 1 + selectedFiles.length) % selectedFiles.length;
            showModalPhoto(modalCurrentIndex);
        });

        document.getElementById('pickupModalNext').addEventListener('click', function () {
            if (! selectedFiles.length) return;
            modalCurrentIndex = (modalCurrentIndex + 1) % selectedFiles.length;
            showModalPhoto(modalCurrentIndex);
        });

        document.addEventListener('keydown', function (event) {
            if (! modal.classList.contains('is-open')) return;

            if (event.key === 'Escape') {
                close();
            } else if (event.key === 'ArrowLeft') {
                if (! selectedFiles.length) return;
                modalCurrentIndex = (modalCurrentIndex - 1 + selectedFiles.length) % selectedFiles.length;
                showModalPhoto(modalCurrentIndex);
            } else if (event.key === 'ArrowRight') {
                if (! selectedFiles.length) return;
                modalCurrentIndex = (modalCurrentIndex + 1) % selectedFiles.length;
                showModalPhoto(modalCurrentIndex);
            }
        });

        return modal;
    }

    function showModalPhoto(index) {
        const modal = ensurePreviewModal();
        const image = document.getElementById('pickupModalImage');
        const title = document.getElementById('pickupModalTitle');
        const counter = document.getElementById('pickupModalCounter');
        const prev = document.getElementById('pickupModalPrev');
        const next = document.getElementById('pickupModalNext');

        if (! selectedFiles[index]) return;

        if (modalObjectUrl) {
            URL.revokeObjectURL(modalObjectUrl);
        }

        modalObjectUrl = URL.createObjectURL(selectedFiles[index]);
        image.src = modalObjectUrl;
        title.textContent = 'Preview Foto ' + (index + 1);
        counter.textContent = (index + 1) + ' / ' + selectedFiles.length;
        prev.disabled = selectedFiles.length <= 1;
        next.disabled = selectedFiles.length <= 1;
        modal.classList.add('is-open');
    }

    function renderPreview() {
        grid.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'pickup-preview-card';

            const image = document.createElement('img');
            image.alt = 'Preview foto ' + (index + 1);
            image.src = URL.createObjectURL(file);
            image.addEventListener('load', function () {
                try {
                    URL.revokeObjectURL(image.src);
                } catch (e) {
                    // Tidak perlu melakukan apa-apa jika browser sudah membersihkan URL.
                }
            }, {once: true});

            const meta = document.createElement('div');
            meta.className = 'pickup-preview-meta';

            const name = document.createElement('div');
            name.className = 'pickup-preview-name';
            name.title = file.name;
            name.textContent = file.name;

            const buttons = document.createElement('div');
            buttons.className = 'pickup-preview-buttons';

            const previewButton = document.createElement('button');
            previewButton.type = 'button';
            previewButton.className = 'pickup-preview-btn';
            previewButton.textContent = 'Preview';
            previewButton.addEventListener('click', function () {
                modalCurrentIndex = index;
                showModalPhoto(index);
            });

            const editButton = document.createElement('button');
            editButton.type = 'button';
            editButton.className = 'pickup-replace-btn';
            editButton.textContent = 'Edit';
            editButton.addEventListener('click', function () {
                const replacementInput = document.createElement('input');
                replacementInput.type = 'file';
                replacementInput.accept = 'image/png,image/jpeg,image/jpg,image/webp';
                replacementInput.style.display = 'none';
                document.body.appendChild(replacementInput);

                replacementInput.addEventListener('change', function () {
                    const replacement = replacementInput.files && replacementInput.files[0];

                    if (! replacement) {
                        replacementInput.remove();
                        return;
                    }

                    if (! ALLOWED_TYPES.includes(replacement.type)) {
                        showMessage('Format tidak sesuai', 'Gunakan JPG, JPEG, PNG, atau WEBP.');
                        replacementInput.remove();
                        return;
                    }

                    if (replacement.size > MAX_SIZE) {
                        showMessage('Ukuran terlalu besar', 'Ukuran setiap foto maksimal 5 MB.');
                        replacementInput.remove();
                        return;
                    }

                    const others = selectedFiles.filter((_, fileIndex) => fileIndex !== index);
                    if (isDuplicate(replacement, others)) {
                        showMessage('Foto sudah dipilih', 'Pilih file yang berbeda.');
                        replacementInput.remove();
                        return;
                    }

                    selectedFiles[index] = replacement;
                    syncInputFiles();
                    renderPreview();
                    replacementInput.remove();
                }, {once: true});

                replacementInput.click();
            });

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'pickup-preview-remove';
            removeButton.setAttribute('aria-label', 'Hapus ' + file.name);
            removeButton.textContent = '×';
            removeButton.addEventListener('click', function () {
                selectedFiles.splice(index, 1);
                syncInputFiles();
                renderPreview();
            });

            buttons.appendChild(previewButton);
            buttons.appendChild(editButton);
            meta.appendChild(name);
            meta.appendChild(buttons);
            card.appendChild(image);
            card.appendChild(removeButton);
            card.appendChild(meta);
            grid.appendChild(card);
        });

        const jumlah = selectedFiles.length;
        summary.hidden = jumlah === 0;
        actions.hidden = jumlah === 0;
        submitButton.disabled = jumlah === 0;
        submitButton.style.opacity = jumlah === 0 ? '.5' : '1';

        if (countText) {
            countText.textContent = jumlah + ' foto dipilih';
        }
    }

    function showMessage(title, text) {
        if (window.Swal) {
            Swal.fire({icon: 'warning', title, text});
        } else {
            alert(title + '\n' + text);
        }
    }

    function addFiles(files) {
        const incoming = Array.from(files || []);
        let skipped = 0;

        for (const file of incoming) {
            if (selectedFiles.length >= MAX_FILES) {
                skipped++;
                continue;
            }

            if (! ALLOWED_TYPES.includes(file.type) || file.size > MAX_SIZE || isDuplicate(file, selectedFiles)) {
                skipped++;
                continue;
            }

            selectedFiles.push(file);
        }

        syncInputFiles();
        renderPreview();

        if (skipped > 0) {
            if (window.Swal) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sebagian foto tidak ditambahkan',
                    text: 'Periksa format, ukuran maksimal 5 MB, duplikat, dan batas maksimal 10 foto.'
                });
            }
        }
    }

    function chooseFiles() {
        input.click();
    }

    uploadArea.addEventListener('click', chooseFiles);
    uploadArea.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            chooseFiles();
        }
    });

    if (chooseMore) {
        chooseMore.addEventListener('click', chooseFiles);
    }

    input.addEventListener('change', function () {
        addFiles(input.files);
        input.value = '';
    });

    if (previewAll) {
        previewAll.addEventListener('click', function () {
            if (! selectedFiles.length) return;
            modalCurrentIndex = 0;
            showModalPhoto(0);
        });
    }

    if (clearAll) {
        clearAll.addEventListener('click', function () {
            selectedFiles = [];
            syncInputFiles();
            renderPreview();
        });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (selectedFiles.length === 0) {
            showMessage('Foto belum dipilih', 'Pilih minimal satu foto bukti pengambilan.');
            return;
        }

        // Pastikan semua foto yang sudah dipilih benar-benar masuk ke input file
        // sebelum form dikirim ke CodeIgniter.
        syncInputFiles();

        if (!input.files || input.files.length === 0) {
            showMessage('Upload belum siap', 'Foto sudah dipilih, tetapi browser belum memasukkannya ke form. Silakan pilih ulang foto.');
            return;
        }

        submitButton.disabled = true;
        submitButton.textContent = 'Mengirim...';
        submitButton.style.opacity = '0.7';
        submitButton.style.cursor = 'wait';

        // Gunakan native submit agar validasi browser pada file input hidden
        // tidak membatalkan pengiriman form.
        HTMLFormElement.prototype.submit.call(form);
    });

    renderPreview();
});
</script>

<?= $this->endSection() ?>
