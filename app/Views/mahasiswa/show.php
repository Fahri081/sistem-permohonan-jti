<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<style>
    .request-hero {
        background: linear-gradient(135deg, #2148c7 0%, #3267ff 100%);
        border-radius: 12px;
        padding: 24px 22px;
        color: #fff;
        margin-bottom: 18px;
        box-shadow: 0 8px 18px rgba(37, 99, 235, .18);
    }

    .request-hero-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .request-hero small {
        display: block;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .55px;
        text-transform: uppercase;
        opacity: .9;
        margin-bottom: 4px;
    }

    .request-hero h1 {
        margin: 0;
        font-size: 25px;
        line-height: 1.1;
        font-weight: 800;
        letter-spacing: -.35px;
    }

    .request-hero .hero-meta {
        margin-top: 7px;
        font-size: 12px;
        font-weight: 500;
        opacity: .9;
    }

    .request-status {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255,255,255,.17);
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 11px;
        font-weight: 700;
        margin-top: 1px;
    }

    .request-content-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 270px;
        gap: 16px;
        align-items: start;
    }

    .request-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .035);
    }

    .request-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 14px;
    }

    .request-card h2 {
        margin: 0;
        color: #172033;
        font-size: 15px;
        font-weight: 800;
    }

    .request-card-subtitle {
        margin: 2px 0 0;
        color: #94a3b8;
        font-size: 11px;
        line-height: 1.4;
    }

    .mini-status {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        border: 1px solid #dbeafe;
        background: #f8fbff;
        color: #2563eb;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .info-grid-compact {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .info-box {
        min-width: 0;
        border: 1px solid #edf1f6;
        background: #f8fafc;
        border-radius: 9px;
        padding: 11px 12px;
        min-height: 58px;
    }

    .info-box.full {
        grid-column: 1 / -1;
    }

    .info-label {
        color: #9aa7b8;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .35px;
        margin-bottom: 5px;
    }

    .info-value {
        color: #26354a;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.35;
        word-break: break-word;
    }

    .evidence-card {
        min-height: 300px;
    }

    .evidence-preview {
        border: 1px solid #e6ebf2;
        border-radius: 8px;
        overflow: hidden;
        background: #f8fafc;
        position: relative;
        aspect-ratio: 1 / .86;
        cursor: pointer;
    }

    .evidence-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .evidence-empty {
        width: 100%;
        height: 100%;
        min-height: 150px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 12px;
        color: #94a3b8;
    }

    .evidence-empty-icon {
        width: 36px;
        height: 36px;
        border: 1px solid #dbe3ee;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .evidence-empty strong {
        color: #64748b;
        font-size: 10px;
        margin-bottom: 4px;
    }

    .evidence-empty span {
        font-size: 9px;
        line-height: 1.35;
    }

    .evidence-caption {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        margin-top: 9px;
    }

    .evidence-caption strong {
        color: #172033;
        font-size: 12px;
    }

    .evidence-caption button {
        border: 0;
        background: transparent;
        color: #64748b;
        font-size: 9px;
        font-weight: 700;
        padding: 0;
        cursor: pointer;
    }

    .evidence-caption button:hover {
        color: #2563eb;
    }

    .detail-back {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #64748b;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .detail-back:hover { color: #2563eb; }

    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 3000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
        background: rgba(15, 23, 42, .62);
    }

    .modal-overlay.active { display: flex; }

    .modal-box {
        width: min(760px, 100%);
        max-height: 90vh;
        overflow: auto;
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 25px 60px rgba(0,0,0,.2);
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 12px;
        border: 0;
        background: transparent;
        color: #64748b;
        font-size: 23px;
        cursor: pointer;
    }

    .modal-box h3 {
        margin: 0 30px 5px 0;
        font-size: 16px;
        color: #172033;
    }

    .modal-box p {
        margin: 0 0 15px;
        color: #64748b;
        font-size: 12px;
    }

    .modal-preview {
        width: 100%;
        max-height: 68vh;
        object-fit: contain;
        border-radius: 9px;
        background: #f8fafc;
    }

    .edit-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .edit-item {
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 7px;
    }

    .edit-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 9px;
        display: block;
        margin-bottom: 7px;
    }

    .edit-item-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .remove-photo {
        border: 0;
        border-radius: 8px;
        background: #fff1f2;
        color: #dc2626;
        padding: 5px 8px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        background: #f8fafc;
        padding: 16px;
        text-align: center;
    }

    .upload-area strong {
        display: block;
        color: #334155;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .upload-area span {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        margin-bottom: 14px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 16px;
    }

    .modal-actions button {
        border: 0;
        border-radius: 8px;
        padding: 8px 13px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-cancel { background: #f1f5f9; color: #475569; }
    .btn-save { background: #2563eb; color: #fff; }

    @media (max-width: 760px) {
        .request-content-grid { grid-template-columns: 1fr; }
        .evidence-card { min-height: 0; }
    }
</style>

<?php
    $idPermohonan = (int) ($permohonan['id_permohonan'] ?? 0);
    $reqIdDisplay = $idPermohonan > 0
        ? 'REQ-' . str_pad((string) $idPermohonan, 4, '0', STR_PAD_LEFT)
        : 'REQ-0000';

    $statusRaw = strtoupper((string) ($permohonan['nama_status'] ?? 'DIAJUKAN'));
    $statusTextMap = [
        'DIAJUKAN' => 'Diajukan',
        'DIPROSES' => 'Diproses',
        'DITOLAK' => 'Ditolak',
        'SELESAI' => 'Selesai',
        'DIAMBIL' => 'Diambil',
    ];
    $statusText = $statusTextMap[$statusRaw] ?? ucfirst(strtolower($statusRaw));

    $tglPengajuan = ! empty($permohonan['tanggal_pengajuan'])
        ? date('d F Y, H:i', strtotime($permohonan['tanggal_pengajuan'])) . ' WIB'
        : '-';

    $tujuanDisplay = ! empty($permohonan['nama_tujuan']) ? $permohonan['nama_tujuan'] : '-';
    $keperluanDisplay = ! empty($permohonan['keperluan']) ? $permohonan['keperluan'] : '-';
    $deskripsiDisplay = ! empty($permohonan['deskripsi']) ? $permohonan['deskripsi'] : '-';
    $buktiFisik = is_array($buktiFisik ?? null) ? $buktiFisik : [];
    $totalBuktiFisik = count($buktiFisik);
?>

<a href="<?= site_url('mahasiswa/permohonan') ?>" class="detail-back">← &nbsp;Permohonan Saya</a>

<section class="request-hero">
    <div class="request-hero-top">
        <div>
            <small>Detail Permohonan</small>
            <h1><?= esc($reqIdDisplay) ?></h1>
            <div class="hero-meta">
                Diajukan <?= esc($tglPengajuan) ?> · <?= esc($tujuanDisplay) ?>
            </div>
        </div>
        <span class="request-status">● &nbsp;<?= esc($statusText) ?></span>
    </div>
</section>

<div class="request-content-grid">
    <section class="request-card">
        <div class="request-card-header">
            <div>
                <h2>Informasi Permohonan</h2>
                <p class="request-card-subtitle">Rincian utama dari permohonan yang diajukan.</p>
            </div>
            <span class="mini-status">● &nbsp;<?= esc($statusText) ?></span>
        </div>

        <div class="info-grid-compact">
            <div class="info-box">
                <div class="info-label">Tanggal Pengajuan</div>
                <div class="info-value"><?= esc($tglPengajuan) ?></div>
            </div>
            <div class="info-box">
                <div class="info-label">Tujuan</div>
                <div class="info-value"><?= esc($tujuanDisplay) ?></div>
            </div>
            <div class="info-box">
                <div class="info-label">Keperluan</div>
                <div class="info-value"><?= esc($keperluanDisplay) ?></div>
            </div>
            <div class="info-box">
                <div class="info-label">ID Permohonan</div>
                <div class="info-value"><?= esc($reqIdDisplay) ?></div>
            </div>
            <div class="info-box full">
                <div class="info-label">Deskripsi</div>
                <div class="info-value"><?= esc($deskripsiDisplay) ?></div>
            </div>
        </div>
    </section>

    <section class="request-card evidence-card">
        <div class="request-card-header">
            <div>
                <h2>Bukti Pengumpulan</h2>
                <p class="request-card-subtitle">Foto sebagai bukti dikumpulkan.</p>
            </div>
            <span class="mini-status">1 foto</span>
        </div>

        <?php if (! empty($buktiFisik)): ?>
            <?php $foto = $buktiFisik[0]; ?>
            <?php $namaFoto = (string) ($foto['nama_file'] ?? ''); ?>
            <?php $fotoUrl = $namaFoto !== '' ? base_url('uploads/bukti_fisik/' . $namaFoto) : ''; ?>

            <?php if ($fotoUrl): ?>
                <button
                    type="button"
                    class="evidence-preview"
                    data-image="<?= esc($fotoUrl) ?>"
                    data-title="Foto <?= $totalBuktiFisik > 1 ? '1 dari ' . $totalBuktiFisik : '1' ?>"
                    style="border:0;padding:0;width:100%;"
                >
                    <img src="<?= esc($fotoUrl) ?>" alt="Bukti Pengumpulan">
                </button>
            <?php else: ?>
                <div class="evidence-preview"><div class="evidence-empty"><div class="evidence-empty-icon">⌁</div><strong>Foto belum tersedia</strong><span>Belum ada bukti fisik.</span></div></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="evidence-preview">
                <div class="evidence-empty">
                    <div class="evidence-empty-icon">⌁</div>
                    <strong>Foto belum tersedia</strong>
                    <span>Mahasiswa belum mengunggah bukti fisik.</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="evidence-caption">
            <strong>Foto 1</strong>
            <?php if (! empty($buktiFisik) && ! empty($fotoUrl)): ?>
                <button type="button" id="viewEvidenceBtn">Klik untuk lihat</button>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php if ($statusRaw === 'DIAJUKAN'): ?>
<div style="display:flex;justify-content:flex-end;margin-top:10px;">
    <button type="button" id="openEditBuktiModal" style="border:1px solid #dbe3ee;background:#fff;color:#2563eb;border-radius:8px;padding:7px 10px;font-size:9px;font-weight:700;cursor:pointer;">
        Ubah Bukti Fisik
    </button>
</div>
<?php endif; ?>

<!-- IMAGE MODAL -->
<div class="modal-overlay" id="imageModal">
    <div class="modal-box" style="max-width:900px;text-align:center;">
        <button type="button" class="modal-close" id="closeImageModal">&times;</button>
        <h3 id="imageModalTitle">Foto Bukti Pengumpulan</h3>
        <p>Klik tombol tutup untuk kembali ke detail permohonan.</p>
        <img id="imageModalPreview" class="modal-preview" src="" alt="Bukti Pengumpulan">
    </div>
</div>

<!-- EDIT MODAL -->
<?php if ($statusRaw === 'DIAJUKAN'): ?>
<div class="modal-overlay" id="editBuktiModal">
    <div class="modal-box">
        <button type="button" class="modal-close" id="closeEditBuktiModal">&times;</button>
        <h3>Ubah Bukti Fisik</h3>
        <p>Hapus foto yang salah atau tambahkan foto yang kurang.</p>

        <form action="<?= site_url('mahasiswa/permohonan/' . $idPermohonan . '/bukti-fisik') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <?php if (! empty($buktiFisik)): ?>
                <div class="edit-grid">
                    <?php foreach ($buktiFisik as $index => $fotoItem): ?>
                        <?php
                            $idBukti = (int) ($fotoItem['id_bukti'] ?? 0);
                            $namaItem = (string) ($fotoItem['nama_file'] ?? '');
                            $urlItem = $namaItem !== '' ? base_url('uploads/bukti_fisik/' . $namaItem) : '';
                        ?>
                        <?php if ($idBukti > 0 && $urlItem): ?>
                            <div class="edit-item" data-bukti-card="<?= $idBukti ?>">
                                <img src="<?= esc($urlItem) ?>" alt="Foto <?= $index + 1 ?>">
                                <div class="edit-item-footer">
                                    <span style="font-size:10px;color:#475569;font-weight:700;">Foto <?= $index + 1 ?></span>
                                    <button type="button" class="remove-photo" data-remove-bukti="<?= $idBukti ?>">Hapus</button>
                                </div>
                                <input type="hidden" name="keep_bukti[]" value="<?= $idBukti ?>" data-keep-input="<?= $idBukti ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="upload-area">
                <strong>Tambahkan foto</strong>
                <span>JPG, JPEG, PNG atau WEBP • maksimal 5 MB per foto</span>
                <input type="file" name="foto_bukti_tambahan[]" id="fotoBuktiTambahan" accept="image/png,image/jpeg,image/jpg,image/webp" multiple>
            </div>

            <div id="editBuktiCounter" style="font-size:10px;color:#64748b;margin-top:8px;"></div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="cancelEditBuktiBtn">Batal</button>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
(function () {
    const imageModal = document.getElementById('imageModal');
    const imagePreview = document.getElementById('imageModalPreview');
    const imageTitle = document.getElementById('imageModalTitle');
    const closeImage = document.getElementById('closeImageModal');
    const evidencePreview = document.querySelector('.evidence-preview[data-image]');
    const viewEvidence = document.getElementById('viewEvidenceBtn');

    function openImage() {
        if (!evidencePreview || !imageModal || !imagePreview) return;
        imagePreview.src = evidencePreview.dataset.image || '';
        if (imageTitle) imageTitle.textContent = evidencePreview.dataset.title || 'Foto Bukti Pengumpulan';
        imageModal.classList.add('active');
    }

    function closeImageModal() {
        if (imageModal) imageModal.classList.remove('active');
    }

    if (evidencePreview) evidencePreview.addEventListener('click', openImage);
    if (viewEvidence) viewEvidence.addEventListener('click', openImage);
    if (closeImage) closeImage.addEventListener('click', closeImageModal);
    if (imageModal) imageModal.addEventListener('click', function (e) { if (e.target === imageModal) closeImageModal(); });

    const editModal = document.getElementById('editBuktiModal');
    const openEdit = document.getElementById('openEditBuktiModal');
    const closeEdit = document.getElementById('closeEditBuktiModal');
    const cancelEdit = document.getElementById('cancelEditBuktiBtn');

    function closeEditModal() { if (editModal) editModal.classList.remove('active'); }
    if (openEdit) openEdit.addEventListener('click', function () { editModal.classList.add('active'); });
    if (closeEdit) closeEdit.addEventListener('click', closeEditModal);
    if (cancelEdit) cancelEdit.addEventListener('click', closeEditModal);
    if (editModal) editModal.addEventListener('click', function (e) { if (e.target === editModal) closeEditModal(); });

    document.querySelectorAll('[data-remove-bukti]').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = button.dataset.removeBukti;
            const input = document.querySelector('[data-keep-input="' + id + '"]');
            const card = document.querySelector('[data-bukti-card="' + id + '"]');
            if (!input || !card) return;
            if (input.disabled) {
                input.disabled = false;
                card.classList.remove('is-removed');
                button.textContent = 'Hapus';
            } else {
                input.disabled = true;
                card.classList.add('is-removed');
                button.textContent = 'Batalkan';
            }
        });
    });

    const fileInput = document.getElementById('fotoBuktiTambahan');
    const counter = document.getElementById('editBuktiCounter');
    if (fileInput && counter) {
        fileInput.addEventListener('change', function () {
            const count = fileInput.files ? fileInput.files.length : 0;
            counter.textContent = count ? count + ' foto baru dipilih.' : '';
        });
    }
})();
</script>

<?= $this->endSection() ?>
