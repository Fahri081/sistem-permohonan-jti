<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Detail Permohonan - JTI Signature
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$status = strtoupper((string) ($permohonan['nama_status'] ?? ''));
$statusClass = strtolower($status);
$idPermohonan = (int) ($permohonan['id_permohonan'] ?? 0);
$namaMahasiswa = (string) ($permohonan['nama_lengkap'] ?? '-');
$initial = strtoupper(substr(trim($namaMahasiswa), 0, 1));

$buktiFisik = is_array($buktiFisik ?? null) ? $buktiFisik : [];

// Fallback tambahan untuk data lama jika controller belum mengirim buktiFisik.
if (empty($buktiFisik) && ! empty($permohonan['bukti_fisik'])) {
    $buktiFisik[] = [
        'id_bukti' => null,
        'id_permohonan' => $idPermohonan,
        'nama_file' => $permohonan['bukti_fisik'],
    ];
}

$totalFoto = count($buktiFisik);

$tanggalPengajuan = ! empty($permohonan['tanggal_pengajuan'])
    ? date('d M Y, H:i', strtotime($permohonan['tanggal_pengajuan'])) . ' WIB'
    : '-';

$statusDescriptions = [
    'DIAJUKAN' => 'Permohonan baru menunggu pemeriksaan admin.',
    'DIPROSES' => 'Permohonan sedang diproses oleh admin.',
    'DITOLAK'  => 'Permohonan memerlukan perbaikan.',
    'SELESAI'  => 'Permohonan sudah selesai diproses.',
    'DIAMBIL'  => 'Permohonan sudah diambil mahasiswa.',
];

$initialReason = (string) ($permohonan['keterangan_penolakan'] ?? '');
$buktiPengambilan = is_array($buktiPengambilan ?? null)
    ? $buktiPengambilan
    : [];
?>

<style>
    .admin-detail-page {
        max-width: 1240px;
        margin: 0 auto;
        padding: 18px 24px 36px;
        box-sizing: border-box;
    }

    .admin-detail-header {
        margin-bottom: 18px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e2e8f0;
    }

    .admin-header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
    }

    .admin-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .admin-back:hover {
        color: #133863;
    }

    .admin-detail-main-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-top: 11px;
    }

    .admin-detail-heading {
        min-width: 0;
    }

    .admin-detail-eyebrow {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .09em;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .admin-detail-heading h1 {
        margin: 0;
        font-size: 23px;
        line-height: 1.2;
        color: #0f172a;
    }

    .admin-detail-subtitle {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 12px;
    }

    .admin-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 999px;
        border: 1px solid #cbd5e1;
        background: #fff;
        font-size: 11.5px;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .admin-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #94a3b8;
    }

    .admin-status-badge.diajukan {
        color: #0369a1;
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .admin-status-badge.diajukan .admin-status-dot {
        background: #0284c7;
    }

    .admin-status-badge.diproses {
        color: #92400e;
        background: #fffbeb;
        border-color: #fde68a;
    }

    .admin-status-badge.diproses .admin-status-dot {
        background: #d97706;
    }

    .admin-status-badge.ditolak {
        color: #991b1b;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .admin-status-badge.ditolak .admin-status-dot {
        background: #dc2626;
    }

    .admin-status-badge.selesai,
    .admin-status-badge.diambil {
        color: #047857;
        background: #ecfdf5;
        border-color: #a7f3d0;
    }

    .admin-status-badge.selesai .admin-status-dot,
    .admin-status-badge.diambil .admin-status-dot {
        background: #059669;
    }

    .admin-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.55fr) minmax(360px, .85fr);
        gap: 20px;
        align-items: start;
    }

    .admin-main-column,
    .admin-side-column {
        min-width: 0;
    }

    .admin-card {
        position: relative;
        z-index: 1;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 22px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .03);
        margin-bottom: 18px;
        box-sizing: border-box;
    }

    .admin-card:last-child {
        margin-bottom: 0;
    }

    .admin-card-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 16px;
    }

    .admin-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .admin-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        flex: 0 0 34px;
        background: #eff6ff;
        color: #2563eb;
    }

    .admin-card-icon.navy {
        background: #eff3f8;
        color: #133863;
    }

    .admin-card-icon.green {
        background: #ecfdf5;
        color: #059669;
    }

    .admin-card-title h2 {
        margin: 0;
        font-size: 15px;
        color: #0f172a;
    }

    .admin-card-title p {
        margin: 3px 0 0;
        font-size: 11px;
        color: #94a3b8;
        line-height: 1.4;
    }

    .admin-student-top {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr);
        gap: 14px;
        align-items: center;
    }

    .admin-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: #e8f1fb;
        color: #133863;
        font-size: 17px;
        font-weight: 800;
    }

    .admin-student-name {
        margin: 0;
        font-size: 16px;
        color: #0f172a;
    }

    .admin-student-role {
        margin: 3px 0 0;
        font-size: 11px;
        color: #64748b;
    }

    .admin-contact-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }

    .admin-field-label {
        display: block;
        margin-bottom: 5px;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .admin-field-value {
        display: block;
        color: #334155;
        font-size: 12px;
        line-height: 1.45;
        overflow-wrap: anywhere;
    }

    .admin-request-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 20px;
    }

    .admin-request-item.full {
        grid-column: 1 / -1;
    }

    .admin-request-item .admin-field-value.highlight {
        color: #133863;
        font-weight: 700;
    }

    .admin-description {
        background: #f8fafc;
        border: 1px solid #eef2f7;
        border-radius: 9px;
        padding: 10px 12px;
        color: #475569;
        min-height: 48px;
        font-size: 12px;
        line-height: 1.5;
    }

    .admin-status-card {
        position: static;
    }

    .admin-side-status {
        padding: 13px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
    }

    .admin-side-status strong {
        display: block;
        color: #0f172a;
        font-size: 15px;
        margin-bottom: 3px;
    }

    .admin-side-status span {
        color: #64748b;
        font-size: 11px;
        line-height: 1.45;
    }

    .admin-photo-count {
        padding: 5px 8px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 10.5px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-photo-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .admin-photo-item {
        position: relative;
        display: block;
        overflow: hidden;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        aspect-ratio: 4 / 3;
    }

    .admin-photo-item img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .18s ease;
    }

    .admin-photo-item:hover img {
        transform: scale(1.025);
    }

    .admin-photo-number {
        position: absolute;
        left: 7px;
        top: 7px;
        padding: 4px 6px;
        border-radius: 999px;
        background: rgba(15, 23, 42, .72);
        color: #fff;
        font-size: 9.5px;
        font-weight: 700;
    }

    .admin-photo-empty {
        padding: 26px 14px;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        text-align: center;
        background: #f8fafc;
    }

    .admin-photo-empty i {
        font-size: 22px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .admin-photo-empty strong {
        display: block;
        font-size: 12px;
        color: #334155;
    }

    .admin-photo-empty span {
        display: block;
        margin-top: 4px;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.4;
    }

    .admin-decision-card {
        padding-bottom: 19px;
    }

    .admin-control {
        margin-bottom: 14px;
    }

    .admin-control:last-child {
        margin-bottom: 0;
    }

    .admin-control label {
        display: block;
        margin-bottom: 6px;
        color: #475569;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .admin-control select,
    .admin-control textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background: #fff;
        color: #334155;
        font: inherit;
        font-size: 12px;
        box-sizing: border-box;
    }

    .admin-control select {
        height: 40px;
        padding: 0 11px;
        cursor: pointer;
    }

    .admin-control textarea {
        min-height: 94px;
        padding: 10px 11px;
        resize: vertical;
        line-height: 1.45;
    }

    .admin-control select:focus,
    .admin-control textarea:focus {
        outline: none;
        border-color: #1d4e8c;
        box-shadow: 0 0 0 3px rgba(29, 78, 140, .10);
    }

    .admin-decision-note {
        margin-top: -2px;
        margin-bottom: 13px;
        color: #94a3b8;
        font-size: 10.5px;
        line-height: 1.45;
    }

    .admin-save-button {
        width: 100%;
        height: 41px;
        border: 0;
        border-radius: 8px;
        background: #133863;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .admin-save-button:hover {
        background: #0f2e52;
    }

    @media (max-width: 1050px) {
        .admin-detail-grid {
            grid-template-columns: 1fr;
        }

        .admin-status-card {
            position: static;
        }
    }

    @media (max-width: 720px) {
        .admin-detail-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .admin-contact-grid,
        .admin-request-grid {
            grid-template-columns: 1fr;
        }

        .admin-request-item.full {
            grid-column: auto;
        }

        .admin-photo-grid {
            grid-template-columns: 1fr;
        }

        .admin-card {
            padding: 18px;
        }
    }


/* =========================================
   ADMIN AVATAR - TOPBAR
   Khusus avatar admin di navbar
========================================= */

.admin-topbar .admin-avatar {
    width: 38px;
    height: 38px;

    border-radius: 12px;

    background: linear-gradient(
        135deg,
        var(--royal),
        var(--indigo)
    );

    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 12px;
    font-weight: 800;

    box-shadow: 0 6px 14px rgba(37, 99, 235, .2);
}


/* MOBILE */

@media (max-width: 560px) {

    .admin-topbar .admin-avatar {
        width: 37px;
        height: 37px;
        border-radius: 10px;
    }

}
</style>

<div class="admin-detail-page">

    <div class="admin-detail-header">
        <div class="admin-header-top">
            <a href="<?= site_url('admin/permohonan') ?>" class="admin-back">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Daftar Permohonan
            </a>

            <span class="admin-status-badge <?= esc($statusClass) ?>">
                <span class="admin-status-dot"></span>
                <?= esc($status !== '' ? ucfirst(strtolower($status)) : 'Tidak diketahui') ?>
            </span>
        </div>

        <div class="admin-detail-main-row">
            <div class="admin-detail-heading">
                <div class="admin-detail-eyebrow">Detail Permohonan</div>
                <h1>REQ-<?= str_pad($idPermohonan, 4, '0', STR_PAD_LEFT) ?></h1>
                <p class="admin-detail-subtitle">
                    Diajukan <?= esc($tanggalPengajuan) ?>
                </p>
            </div>
        </div>
    </div>

    <div class="admin-detail-grid">

        <main class="admin-main-column">

            <section class="admin-card">
                <div class="admin-card-title-row">
                    <div class="admin-card-title">
                        <div class="admin-card-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <h2>Informasi Mahasiswa</h2>
                            <p>Data mahasiswa yang mengajukan permohonan.</p>
                        </div>
                    </div>
                </div>

                <div class="admin-student-top">
                    <div class="admin-avatar"><?= esc($initial ?: 'M') ?></div>
                    <div>
                        <h3 class="admin-student-name"><?= esc($namaMahasiswa) ?></h3>
                        <p class="admin-student-role">Mahasiswa / Pemohon</p>
                    </div>
                </div>

                <div class="admin-contact-grid">
                    <div>
                        <span class="admin-field-label">NIM</span>
                        <span class="admin-field-value"><?= esc($permohonan['nim'] ?? '-') ?></span>
                    </div>

                    <div>
                        <span class="admin-field-label">Email</span>
                        <span class="admin-field-value"><?= esc($permohonan['email'] ?? '-') ?></span>
                    </div>

                    <div>
                        <span class="admin-field-label">No. Handphone</span>
                        <span class="admin-field-value"><?= esc($permohonan['no_hp'] ?? '-') ?></span>
                    </div>
                </div>
            </section>

            <section class="admin-card">
                <div class="admin-card-title-row">
                    <div class="admin-card-title">
                        <div class="admin-card-icon navy">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <div>
                            <h2>Informasi Permohonan</h2>
                            <p>Detail permintaan tanda tangan yang diajukan mahasiswa.</p>
                        </div>
                    </div>
                </div>

                <div class="admin-request-grid">
                    <div class="admin-request-item">
                        <span class="admin-field-label">Tujuan Tanda Tangan</span>
                        <span class="admin-field-value highlight">
                            <?= esc($permohonan['nama_tujuan'] ?? '-') ?>
                        </span>
                    </div>

                    <div class="admin-request-item">
                        <span class="admin-field-label">Tanggal Pengajuan</span>
                        <span class="admin-field-value">
                            <?= esc($tanggalPengajuan) ?>
                        </span>
                    </div>

                    <div class="admin-request-item full">
                        <span class="admin-field-label">Keperluan</span>
                        <span class="admin-field-value">
                            <?= esc($permohonan['keperluan'] ?? '-') ?>
                        </span>
                    </div>

                    <div class="admin-request-item full">
                        <span class="admin-field-label">Deskripsi</span>
                        <div class="admin-description">
                            <?php if (! empty($permohonan['deskripsi'])): ?>
                                <?= nl2br(esc($permohonan['deskripsi'])) ?>
                            <?php else: ?>
                                <span style="color:#94a3b8;">Tidak ada deskripsi tambahan.</span>
                            <?php endif; ?>     
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <aside class="admin-side-column">

            <section class="admin-card">
                <div class="admin-card-title-row">
                    <div class="admin-card-title">
                        <div class="admin-card-icon navy">
                            <i class="fa-regular fa-images"></i>
                        </div>
                        <div>
                            <h2>Bukti Pengumpulan Berkas Fisik</h2>
                            <p>Foto sebagai bukti mahasiswa telah menempatkan berkas fisik di ruang pengumpulan.</p>
                        </div>
                    </div>

                    <span class="admin-photo-count">
                        <?= $totalFoto ?> foto
                    </span>
                </div>

                <?php if (! empty($buktiFisik)): ?>
                    <div class="admin-photo-grid">
                        <?php foreach ($buktiFisik as $index => $foto): ?>
                            <?php
                                $namaFoto = (string) ($foto['nama_file'] ?? '');
                                $fotoUrl = $namaFoto !== ''
                                    ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                    : '';
                            ?>

                            <?php if ($fotoUrl): ?>
                                <a
                                    href="<?= esc($fotoUrl) ?>"
                                    target="_blank"
                                    rel="noopener"
                                    class="admin-photo-item"
                                    title="Buka foto <?= $index + 1 ?>"
                                >
                                    <img
                                        src="<?= esc($fotoUrl) ?>"
                                        alt="Bukti pengumpulan foto <?= $index + 1 ?>"
                                    >
                                    <span class="admin-photo-number">Foto <?= $index + 1 ?></span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="admin-photo-empty">
                        <i class="fa-regular fa-image"></i>
                        <strong>Belum ada foto bukti</strong>
                        <span>Mahasiswa belum mengunggah foto bukti pengumpulan berkas fisik.</span>
                    </div>
                <?php endif; ?>
            </section>

<?php if (! empty($buktiPengambilan)): ?>

    <section class="admin-card" style="margin-bottom:18px;">

        <div class="admin-card-title-row">

            <div class="admin-card-title">

                <div class="admin-card-icon navy">
                    <i class="fa-regular fa-circle-check"></i>
                </div>

                <div>
                    <h2>Bukti Pengambilan</h2>

                    <p>
                        Foto yang dikirim mahasiswa sebagai bukti bahwa dokumen sudah diambil.
                    </p>
                </div>

            </div>

            <span class="admin-photo-count">
                <?= count($buktiPengambilan) ?> foto
            </span>

        </div>


        <div
            class="admin-photo-grid"
            style="margin-top:14px;"
        >

            <?php foreach ($buktiPengambilan as $index => $bukti): ?>

                <?php
                    $pickupNamaFile = (string) ($bukti['nama_file'] ?? '');

                    $pickupUrl = $pickupNamaFile !== ''
                        ? base_url('uploads/bukti_pengambilan/' . $pickupNamaFile)
                        : '';

                    $pickupStatus = strtolower(
                        (string) ($bukti['status_verifikasi'] ?? 'menunggu')
                    );

                    $pickupStatusLabel = match ($pickupStatus) {
                        'diterima' => 'Diterima',
                        'ditolak'  => 'Ditolak',
                        default    => 'Menunggu verifikasi',
                    };
                ?>

                <?php if ($pickupUrl): ?>

                    <div style="
                        border:1px solid #e2e8f0;
                        border-radius:10px;
                        overflow:hidden;
                        background:#fff;
                    ">

                        <a
                            href="<?= esc($pickupUrl) ?>"
                            target="_blank"
                            rel="noopener"
                            class="admin-photo-item"
                            style="
                                display:block;
                                border:0;
                                border-radius:0;
                            "
                        >

                            <img
                                src="<?= esc($pickupUrl) ?>"
                                alt="Bukti Pengambilan Foto <?= $index + 1 ?>"
                            >

                            <span class="admin-photo-number">
                                Foto <?= $index + 1 ?>
                            </span>

                        </a>


                        <div style="
                            padding:10px 12px;
                            font-size:11px;
                            color:#64748b;
                        ">

                            Status:

                            <strong style="
                                color:
                                <?= $pickupStatus === 'diterima'
                                    ? '#047857'
                                    : ($pickupStatus === 'ditolak'
                                        ? '#b91c1c'
                                        : '#b45309') ?>;
                            ">
                                <?= esc($pickupStatusLabel) ?>
                            </strong>

                        </div>

                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        </div>


        <?php
            $adaYangMenunggu = false;

            foreach ($buktiPengambilan as $bukti) {
                if (
                    strtolower(
                        (string) ($bukti['status_verifikasi'] ?? '')
                    ) === 'menunggu'
                ) {
                    $adaYangMenunggu = true;
                    break;
                }
            }
        ?>


        <?php if ($adaYangMenunggu && ($permohonan['nama_status'] ?? '') === 'MENUNGGU VERIFIKASI PENGAMBILAN'): ?>

            <form
                method="post"
                action="<?= site_url(
                    'admin/permohonan/' .
                    $idPermohonan .
                    '/verifikasi-pengambilan'
                ) ?>"
                style="margin-top:14px;"
            >

                <?= csrf_field() ?>

                <label
                    for="catatanVerifikasi"
                    style="
                        display:block;
                        font-size:12px;
                        font-weight:700;
                        color:#334155;
                        margin-bottom:6px;
                    "
                >
                    Catatan verifikasi
                </label>

                <textarea
                    name="catatan_verifikasi"
                    id="catatanVerifikasi"
                    rows="3"
                    placeholder="Isi catatan jika diperlukan..."
                    style="
                        width:100%;
                        resize:vertical;
                        box-sizing:border-box;
                        border:1px solid #cbd5e1;
                        border-radius:9px;
                        padding:10px 12px;
                        font:inherit;
                        font-size:12px;
                    "
                ></textarea>


                <div style="
                    display:flex;
                    gap:10px;
                    margin-top:10px;
                ">

                    <button
                        type="submit"
                        name="keputusan"
                        value="DITERIMA"
                        style="
                            flex:1;
                            border:0;
                            border-radius:8px;
                            padding:10px 12px;
                            background:#059669;
                            color:#fff;
                            font-weight:700;
                            cursor:pointer;
                        "
                    >
                        ✓ Verifikasi Semua &amp; Tandai Diambil
                    </button>


                    <button
                        type="submit"
                        name="keputusan"
                        value="DITOLAK"
                        style="
                            flex:1;
                            border:0;
                            border-radius:8px;
                            padding:10px 12px;
                            background:#dc2626;
                            color:#fff;
                            font-weight:700;
                            cursor:pointer;
                        "
                    >
                        Tolak Semua Bukti
                    </button>

                </div>

            </form>

        <?php endif; ?>

    </section>

<?php endif; ?>
            

            <?php if (! in_array(
    $status,
    [
        'SELESAI',
        'MENUNGGU VERIFIKASI PENGAMBILAN',
        'DIAMBIL'
    ],
    true
)): ?>

    <section class="admin-card admin-decision-card">

        <div class="admin-card-title-row">

            <div class="admin-card-title">

                <div class="admin-card-icon">
                    <i class="fa-solid fa-gavel"></i>
                </div>

                <div>
                    <h2>Keputusan Admin</h2>

                    <p>
                        Tentukan status permohonan setelah melakukan pemeriksaan.
                        Status Diambil ditentukan melalui verifikasi bukti pengambilan mahasiswa.
                    </p>
                </div>

            </div>

        </div>


        <form
            method="post"
            action="<?= site_url(   
                'admin/permohonan/' .
                $idPermohonan .
                '/status'
            ) ?>"
            id="statusForm"
        >

            <?= csrf_field() ?>


            <div class="admin-control">

                <label for="status">
                    Status Permohonan
                </label>

                <select
                    name="status"
                    id="status"
                    required
                    onchange="handleStatusTransition(this)"
                >

                    <option
                        value="DIAJUKAN"
                        <?= $status === 'DIAJUKAN'
                            ? 'selected'
                            : '' ?>
                    >
                        Diajukan
                    </option>


                    <option
                        value="DIPROSES"
                        <?= $status === 'DIPROSES'
                            ? 'selected'
                            : '' ?>
                    >
                        Diproses
                    </option>


                    <option
                        value="DITOLAK"
                        <?= $status === 'DITOLAK'
                            ? 'selected'
                            : '' ?>
                    >
                        Ditolak
                    </option>


                    <option
                        value="SELESAI"
                        <?= $status === 'SELESAI'
                            ? 'selected'
                            : '' ?>
                    >
                        Selesai
                    </option>

                </select>

            </div>

            <script>
            function handleStatusTransition(select) {
                const currentStatus = <?= json_encode($status) ?>;
                const selectedStatus = select.value;

                const statusLabels = {
                    DIAJUKAN: 'Diajukan',
                    DIPROSES: 'Diproses',
                    DITOLAK: 'Ditolak',
                    SELESAI: 'Selesai'
                };

                const allowedTransitions = {
                    DIAJUKAN: ['DIPROSES', 'DITOLAK'],
                    DIPROSES: ['DITOLAK', 'SELESAI'],
                    DITOLAK: ['DIPROSES'],
                    SELESAI: []
                };

                if (selectedStatus === currentStatus) {
                    toggleRejectionReasonInline(select.value);
                    return;
                }

                const allowed = allowedTransitions[currentStatus] || [];

                if (!allowed.includes(selectedStatus)) {
                    select.value = currentStatus;

                    const currentLabel =
                        statusLabels[currentStatus] || currentStatus;

                    const selectedLabel =
                        statusLabels[selectedStatus] || selectedStatus;

                    const allowedText = allowed.length
                        ? allowed.map(function (status) {
                            return statusLabels[status] || status;
                        }).join(' atau ')
                        : 'tidak ada';

                    if (window.Swal) {
                        Swal.fire({
                            iconHtml: '<i class="fa-solid fa-route"></i>',
                            title: 'Perubahan Status Belum Sesuai Alur',
                            text:
                                'Status ' + selectedLabel +
                                ' belum dapat dipilih dari status ' +
                                currentLabel +
                                '. Pilihan yang tersedia: ' +
                                allowedText + '.',
                            confirmButtonText: 'Mengerti',
                            buttonsStyling: false,
                            customClass: {
                                popup: 'jti-swal-popup',
                                icon: 'jti-swal-icon jti-swal-icon-warning',
                                title: 'jti-swal-title',
                                htmlContainer: 'jti-swal-text',
                                actions: 'jti-swal-actions',
                                confirmButton: 'jti-swal-confirm'
                            }
                        });
                    } else {
                        window.alert(
                            'Perubahan status belum sesuai alur. ' +
                            'Status ' + selectedLabel +
                            ' tidak dapat dipilih dari status ' +
                            currentLabel +
                            '. Pilihan yang tersedia: ' +
                            allowedText + '.'
                        );
                    }
                }

                toggleRejectionReasonInline(select.value);
            }

            function toggleRejectionReasonInline(selectedStatus) {
                const reasonWrap =
                    document.getElementById('rejectionReasonWrap');

                const reason =
                    document.getElementById('keterangan_penolakan');

                if (!reasonWrap) {
                    return;
                }

                const rejected = selectedStatus === 'DITOLAK';

                reasonWrap.style.display =
                    rejected ? 'block' : 'none';

                if (reason) {
                    reason.required = rejected;
                }
            }
            </script>


            <div
                class="admin-control"
                id="rejectionReasonWrap"
                style="<?= $status === 'DITOLAK'
                    ? ''
                    : 'display:none;' ?>"
            >

                <label for="keterangan_penolakan">
                    Alasan Penolakan
                </label>

                <textarea
                    name="keterangan_penolakan"
                    id="keterangan_penolakan"
                    placeholder="Jelaskan bagian yang perlu diperbaiki mahasiswa..."
                ><?= esc($initialReason) ?></textarea>

            </div>


            <?php if ($status !== 'DITOLAK'): ?>

                <div class="admin-decision-note">

                    Alasan penolakan hanya diperlukan ketika status diubah menjadi
                    <strong>Ditolak</strong>.

                </div>

            <?php endif; ?>


            <button
                type="submit"
                class="admin-save-button"
            >

                <i class="fa-solid fa-floppy-disk"></i>

                Simpan Perubahan

            </button>

        </form>

    </section>

<?php endif; ?>

        </aside>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<style>
/* JTI Signature - SweetAlert */
.jti-swal-popup {
    width: min(430px, calc(100vw - 32px)) !important;
    padding: 28px 26px 24px !important;
    border: 1px solid #E2E8F0 !important;
    border-radius: 20px !important;
    background: #FFFFFF !important;
    box-shadow: 0 24px 70px rgba(20, 46, 82, .18) !important;
}

.jti-swal-icon {
    width: 58px !important;
    height: 58px !important;
    margin: 0 auto 16px !important;
    border: 0 !important;
    border-radius: 16px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 22px !important;
}

.jti-swal-icon-warning {
    background: #FFF7E8 !important;
    color: #D97706 !important;
}

.jti-swal-icon-danger {
    background: #FFF1F0 !important;
    color: #DC2626 !important;
}

.jti-swal-title {
    margin: 0 !important;
    color: #142E52 !important;
    font-size: 18px !important;
    line-height: 1.3 !important;
    font-weight: 800 !important;
    letter-spacing: -.02em !important;
}

.jti-swal-text {
    margin: 9px auto 0 !important;
    max-width: 340px;
    color: #667085 !important;
    font-size: 12px !important;
    line-height: 1.6 !important;
}

.jti-swal-actions {
    gap: 9px !important;
    margin-top: 22px !important;
}

.jti-swal-confirm,
.jti-swal-cancel {
    min-width: 112px;
    min-height: 40px;
    padding: 0 16px !important;
    border-radius: 10px !important;
    border: 0 !important;
    font-size: 11px !important;
    font-weight: 800 !important;
    cursor: pointer !important;
}

.jti-swal-confirm {
    background: #2563EB !important;
    color: #FFFFFF !important;
    box-shadow: 0 8px 18px rgba(37, 99, 235, .18) !important;
}

.jti-swal-confirm:hover {
    background: #1D4ED8 !important;
}

.jti-swal-cancel {
    background: #F4F7FC !important;
    color: #475467 !important;
    border: 1px solid #E2E8F0 !important;
}

.jti-swal-cancel:hover {
    background: #EEF2F7 !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(function () {
    function initRejectionControl() {
        const form = document.getElementById('statusForm');
        const statusSelect = document.getElementById('status');
        const reasonWrap = document.getElementById('rejectionReasonWrap');
        const reason = document.getElementById('keterangan_penolakan');

        if (!statusSelect || !reasonWrap) {
            return;
        }

        function toggleReason() {
            const rejected = statusSelect.value === 'DITOLAK';

            reasonWrap.style.display = rejected ? 'block' : 'none';

            if (rejected && reason) {
                reason.required = true;
            } else if (reason) {
                reason.required = false;
                reason.value = '';
            }
        }

        statusSelect.addEventListener('change', toggleReason);

        // Jalankan juga saat halaman pertama kali dimuat.
        toggleReason();

        if (form) {
            form.addEventListener('submit', function (event) {
                const status = statusSelect.value;
                const message = reason ? reason.value.trim() : '';

                if (status !== 'DITOLAK') {
                    return;
                }

                if (message === '') {
                    event.preventDefault();

                    Swal.fire({
                        iconHtml: '<i class="fa-solid fa-pen-to-square"></i>',
                        title: 'Alasan Penolakan Diperlukan',
                        text: 'Jelaskan alasan penolakan agar mahasiswa mengetahui bagian yang perlu diperbaiki.',
                        confirmButtonText: 'Kembali ke Formulir',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'jti-swal-popup',
                            icon: 'jti-swal-icon jti-swal-icon-warning',
                            title: 'jti-swal-title',
                            htmlContainer: 'jti-swal-text',
                            actions: 'jti-swal-actions',
                            confirmButton: 'jti-swal-confirm'
                        }
                    });

                    if (reason) {
                        reason.focus();
                    }

                    return;
                }

                event.preventDefault();

                Swal.fire({
                    iconHtml: '<i class="fa-solid fa-file-circle-xmark"></i>',
                    title: 'Tolak Permohonan?',
                    text: 'Permohonan akan diubah menjadi Ditolak dan mahasiswa akan menerima alasan penolakan.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        popup: 'jti-swal-popup',
                        icon: 'jti-swal-icon jti-swal-icon-danger',
                        title: 'jti-swal-title',
                        htmlContainer: 'jti-swal-text',
                        actions: 'jti-swal-actions',
                        confirmButton: 'jti-swal-confirm',
                        cancelButton: 'jti-swal-cancel'
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRejectionControl);
    } else {
        initRejectionControl();
    }
})();
</script>

<?= $this->endSection() ?>
