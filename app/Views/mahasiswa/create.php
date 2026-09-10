<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<style>
    /* PAGE HEADER */
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.3px;
        margin-bottom: 6px;
    }

    .page-header p {
        font-size: 13.5px;
        color: #64748b;
    }

    /* FORM CARD */
    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 28px 32px 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        max-width: 920px;
    }

    .form-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    /* FORM GRID */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .form-label .required-star {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13.5px;
        font-family: inherit;
        color: #1e293b;
        background-color: #ffffff;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1d4e8c;
        box-shadow: 0 0 0 3px rgba(29, 78, 140, 0.12);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        padding-right: 38px;
        cursor: pointer;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* UPLOAD SECTION */
    .upload-section-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 28px 0 14px;
    }

    /* DRAG & DROP ZONE */
    .dropzone-container {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background-color: #f8fafc;
        padding: 32px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s ease;
        position: relative;
    }

    .dropzone-container:hover, .dropzone-container.dragover {
        border-color: #1d4e8c;
        background-color: #f0f7ff;
    }

    .dropzone-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        color: #64748b;
    }

    .dropzone-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .dropzone-subtitle {
        font-size: 12px;
        color: #94a3b8;
    }

    .dropzone-file-input {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* UPLOADED FILE ITEM PREVIEW CARD */
    .uploaded-file-card {
        margin-top: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 16px;
        background: #ffffff;
    }

    .uploaded-thumbnail {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .uploaded-info {
        flex: 1;
        min-width: 0;
    }

    .uploaded-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }

    .uploaded-size {
        font-size: 11.5px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .upload-progress-bar {
        width: 100%;
        height: 4px;
        background-color: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
    }

    .upload-progress-fill {
        height: 100%;
        background-color: #133863;
        border-radius: 999px;
        width: 100%;
        transition: width 0.3s ease;
    }

    .uploaded-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .btn-action-change {
        font-size: 12.5px;
        font-weight: 600;
        color: #2563eb;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-action-change:hover {
        text-decoration: underline;
    }

    .btn-action-delete {
        font-size: 12.5px;
        font-weight: 600;
        color: #dc2626;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-action-delete:hover {
        text-decoration: underline;
    }

    /* FORM ACTIONS */
    .form-actions {
        margin-top: 36px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 16px;
    }

    .btn-cancel {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        padding: 10px 18px;
        border-radius: 8px;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .btn-cancel:hover {
        background-color: #f1f5f9;
        color: #1e293b;
    }

    .btn-submit {
        background-color: #0b2341;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.1s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .btn-submit:hover {
        background-color: #133863;
        transform: translateY(-1px);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
            gap: 14px;
        }
        .form-card {
            padding: 20px 18px;
        }
    }
</style>

<!-- PAGE HEADER -->
<div class="page-header">
    <h1>Ajukan Permohonan Baru</h1>
    <p>Kirimkan permohonan baru untuk persetujuan tanda tangan pimpinan.</p>
</div>

<!-- MAIN FORM CARD -->
<div class="form-card">
    <h2 class="form-card-title">Detail Permohonan</h2>

    <form action="<?= site_url('mahasiswa/permohonan') ?>" method="POST" enctype="multipart/form-data" id="ajukanForm">
        <?= csrf_field() ?>

        <!-- ROW 1: TUJUAN & KEPERLUAN (2 COLUMNS) -->
        <div class="form-grid-2">
            <div class="form-group">
                <label for="id_tujuan" class="form-label">
                    Tujuan Tanda Tangan <span class="required-star">*</span>
                </label>
                <select name="id_tujuan" id="id_tujuan" class="form-control" required>
                    <option value="" disabled selected>Pilih jabatan tujuan</option>
                    <?php foreach ($tujuan as $t): ?>
                        <option value="<?= esc($t['id_tujuan']) ?>">
                            <?= esc($t['nama_tujuan']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="keperluan" class="form-label">
                    Keperluan Permohonan <span class="required-star">*</span>
                </label>
                <input type="text" name="keperluan" id="keperluan" class="form-control" placeholder="misal: Surat Pengajuan Magang" required>
            </div>
        </div>

        <!-- ROW 2: DESKRIPSI -->
        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Berikan konteks tambahan untuk peninjau..." rows="4"></textarea>
        </div>

        <!-- SECTION: FOTO BUKTI PENYERAHAN BERKAS FISIK -->
        <div class="upload-section-title">Foto Bukti Penyerahan Berkas Fisik</div>

        <!-- DROPZONE -->
        <div class="dropzone-container" id="dropzoneBox">
            <div class="dropzone-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
            </div>
            <div class="dropzone-title">Klik untuk unggah atau seret dan lepas</div>
            <div class="dropzone-subtitle">JPG atau PNG (maks. 5MB)</div>
            <input type="file" name="foto_bukti" id="foto_bukti" class="dropzone-file-input" accept="image/png, image/jpeg, image/jpg">
        </div>

        <!-- UPLOADED FILE PREVIEW ITEM -->
        <?php $defaultSampleImg = base_url('assets/images/bukti_dokumen.jpg'); ?>
        <div class="uploaded-file-card" id="filePreviewCard">
            <img src="<?= $defaultSampleImg ?>" alt="Thumbnail Berkas" class="uploaded-thumbnail" id="previewThumb">
            <div class="uploaded-info">
                <div class="uploaded-name" id="previewFileName">bukti_pengumpulan_magang.jpg</div>
                <div class="uploaded-size" id="previewFileSize">1.2 MB</div>
                <div class="upload-progress-bar">
                    <div class="upload-progress-fill"></div>
                </div>
            </div>
            <div class="uploaded-actions">
                <button type="button" class="btn-action-change" id="btnChangeFile">Ganti</button>
                <button type="button" class="btn-action-delete" id="btnDeleteFile">Hapus</button>
            </div>
        </div>

        <!-- OPTIONAL DOKUMEN DIGITAL (PDF) -->
        <div style="margin-top: 20px;">
            <label class="form-label" style="font-size: 12.5px; color:#64748b;">
                Lampirkan File Dokumen Digital Tambahan (Opsional)
            </label>
            <input type="file" name="berkas[]" multiple class="form-control" accept=".pdf,.doc,.docx" style="padding: 8px 12px; font-size: 12.5px;">
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div class="form-actions">
            <a href="<?= site_url('mahasiswa') ?>" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                </svg>
                <span>Kirim Permohonan</span>
            </button>
        </div>
    </form>
</div>

<!-- INTERACTIVE FILE UPLOAD SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('foto_bukti');
        const dropzone = document.getElementById('dropzoneBox');
        const previewCard = document.getElementById('filePreviewCard');
        const previewName = document.getElementById('previewFileName');
        const previewSize = document.getElementById('previewFileSize');
        const previewThumb = document.getElementById('previewThumb');
        const btnChange = document.getElementById('btnChangeFile');
        const btnDelete = document.getElementById('btnDeleteFile');

        // Drag & drop handlers
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                fileInput.files = e.dataTransfer.files;
                handleFileChange(e.dataTransfer.files[0]);
            }
        });

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                handleFileChange(this.files[0]);
            }
        });

        btnChange.addEventListener('click', function() {
            fileInput.click();
        });

        btnDelete.addEventListener('click', function() {
            fileInput.value = '';
            previewCard.style.display = 'none';
        });

        function handleFileChange(file) {
            previewName.textContent = file.name;
            const sizeInMB = (file.size / (1024 * 1024)).toFixed(1);
            previewSize.textContent = `${sizeInMB} MB`;

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewThumb.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
            previewCard.style.display = 'flex';
        }
    });
</script>

<?= $this->endSection() ?>
