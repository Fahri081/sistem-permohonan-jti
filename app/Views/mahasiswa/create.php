<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .apply-page { max-width: 1180px; margin: 0 auto; }
    .apply-hero {
        position: relative; overflow: hidden; border-radius: 20px; padding: 28px 30px;
        background: linear-gradient(135deg, #142E52 0%, #1f4f91 58%, #4F46E5 100%);
        color: #fff; margin-bottom: 22px; box-shadow: 0 16px 36px rgba(20,46,82,.18);
    }
    .apply-hero::after { content:""; position:absolute; width:220px; height:220px; border-radius:50%; right:-70px; top:-100px; background:rgba(255,255,255,.09); }
    .apply-hero h1 { margin:0 0 8px; font-size:27px; line-height:1.2; font-weight:800; letter-spacing:-.5px; }
    .apply-hero p { margin:0; max-width:760px; color:rgba(255,255,255,.82); font-size:14px; line-height:1.6; }
    .apply-layout { display:grid; grid-template-columns:minmax(0,1fr) 330px; gap:22px; align-items:start; }
    .card { background:#fff; border:1px solid #E2E8F0; border-radius:16px; box-shadow:0 6px 18px rgba(15,23,42,.045); }
    .form-card { padding:26px; }
    .card-title { margin:0; color:#172033; font-size:17px; font-weight:800; }
    .card-subtitle { margin:6px 0 22px; color:#667085; font-size:12.5px; line-height:1.55; }
    .section-label { margin:24px 0 13px; padding-top:20px; border-top:1px solid #EEF2F7; display:flex; align-items:center; gap:9px; color:#172033; font-size:13.5px; font-weight:800; }
    .section-label:first-of-type { margin-top:0; padding-top:0; border-top:0; }
    .section-icon { width:30px; height:30px; border-radius:9px; display:grid; place-items:center; background:#EAF1FF; color:#2563EB; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .form-group { margin-bottom:17px; }
    .form-label { display:block; margin-bottom:7px; color:#334155; font-size:12.5px; font-weight:700; }
    .required { color:#DC2626; }
    .control { width:100%; box-sizing:border-box; border:1px solid #D7DEE8; border-radius:10px; padding:12px 13px; background:#fff; color:#172033; font:inherit; font-size:13px; transition:.18s; }
    .control::placeholder { color:#98A2B3; }
    .control:focus { outline:0; border-color:#2563EB; box-shadow:0 0 0 4px rgba(37,99,235,.10); }
    select.control { appearance:none; background-image:linear-gradient(45deg,transparent 50%,#667085 50%),linear-gradient(135deg,#667085 50%,transparent 50%); background-position:calc(100% - 17px) 17px,calc(100% - 12px) 17px; background-size:5px 5px,5px 5px; background-repeat:no-repeat; padding-right:36px; }
    textarea.control { min-height:116px; resize:vertical; }
    .helper { margin-top:6px; color:#98A2B3; font-size:11.5px; line-height:1.45; }
    .dropzone { position:relative; border:1.5px dashed #B8C5D7; border-radius:14px; padding:27px 18px; text-align:center; background:linear-gradient(180deg,#FBFDFF,#F7FAFF); transition:.18s; }
    .dropzone:hover,.dropzone.dragover { border-color:#2563EB; background:#F3F7FF; }
    .drop-icon { width:48px; height:48px; border-radius:14px; margin:0 auto 11px; display:grid; place-items:center; background:#EAF1FF; color:#2563EB; }
    .drop-title { color:#172033; font-size:13.5px; font-weight:800; margin-bottom:5px; }
    .drop-text { color:#667085; font-size:11.5px; }
    .file-input { position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; }
    .photo-counter { margin-top:10px; color:#667085; font-size:11.5px; }
    .preview-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:12px; margin-top:14px; }
    .preview-card { border:1px solid #E2E8F0; border-radius:12px; padding:7px; background:#fff; overflow:hidden; }
    .preview-image { width:100%; height:118px; object-fit:cover; border-radius:8px; display:block; background:#F3F6FA; }
    .preview-meta { padding:8px 2px 2px; display:flex; align-items:center; gap:7px; }
    .preview-info { min-width:0; flex:1; }
    .preview-name { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-size:11.5px; font-weight:700; color:#334155; }
    .preview-size { margin-top:3px; color:#98A2B3; font-size:10.5px; }
    .remove-photo { width:28px; height:28px; border:0; border-radius:8px; background:#FEF2F2; color:#DC2626; cursor:pointer; font-size:12px; }
    .notice { display:flex; gap:11px; padding:13px 14px; border-radius:11px; background:#F0F5FF; border:1px solid #D9E4FF; color:#33507D; font-size:11.5px; line-height:1.55; }
    .notice strong { color:#173B70; }
    .actions { margin-top:26px; padding-top:18px; border-top:1px solid #EEF2F7; display:flex; justify-content:flex-end; gap:10px; }
    .btn { border:0; border-radius:10px; padding:11px 17px; font:inherit; font-size:12.5px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:8px; }
    .btn-secondary { background:#F2F4F7; color:#475467; }
    .btn-secondary:hover { background:#EAECEF; }
    .btn-primary { color:#fff; background:linear-gradient(135deg,#2563EB,#4F46E5); box-shadow:0 8px 16px rgba(37,99,235,.18); }
    .btn-primary:hover { transform:translateY(-1px); }
    .side-card { padding:20px; }
    .side-head { display:flex; gap:10px; align-items:flex-start; margin-bottom:17px; }
    .side-icon { width:36px; height:36px; border-radius:10px; background:#EAF1FF; color:#2563EB; display:grid; place-items:center; flex:0 0 auto; }
    .side-card h3 { margin:0; font-size:14px; font-weight:800; color:#172033; }
    .side-card p { margin:4px 0 0; font-size:11.5px; line-height:1.5; color:#667085; }
    .steps { display:flex; flex-direction:column; gap:14px; }
    .step { display:grid; grid-template-columns:28px 1fr; gap:10px; }
    .step-num { width:28px; height:28px; border-radius:9px; display:grid; place-items:center; font-size:11px; font-weight:800; color:#2563EB; background:#EAF1FF; }
    .step strong { display:block; color:#344054; font-size:12px; margin-bottom:3px; }
    .step span { color:#667085; font-size:11px; line-height:1.45; }
    .limits { margin-top:17px; padding-top:15px; border-top:1px solid #EEF2F7; display:grid; gap:9px; }
    .limit-row { display:flex; justify-content:space-between; gap:12px; font-size:11.5px; color:#667085; }
    .limit-row strong { color:#344054; }
    @media (max-width: 980px){ .apply-layout{grid-template-columns:1fr;} .side-card{order:2;} }
    @media (max-width: 700px){ .apply-hero{padding:23px 20px;} .apply-hero h1{font-size:23px;} .form-card{padding:20px 17px;} .form-grid{grid-template-columns:1fr;gap:0;} .actions{flex-direction:column-reverse;} .btn{justify-content:center;width:100%;} }
</style>

<?php
    $tujuan = is_array($tujuan ?? null) ? $tujuan : [];
    $oldTujuan = old('id_tujuan');
    $oldKeperluan = old('keperluan');
    $oldDeskripsi = old('deskripsi');
?>

<div class="apply-page">
    <div class="apply-hero">
        <h1>Ajukan Permohonan Baru</h1>
        <p>Isi informasi permohonan dengan lengkap, lalu unggah foto sebagai bukti bahwa berkas fisik telah diserahkan kepada pihak jurusan.</p>
    </div>

    <div class="apply-layout">
        <div class="card form-card">
            <h2 class="card-title">Formulir Permohonan</h2>
            <p class="card-subtitle">Kolom bertanda <span class="required">*</span> wajib diisi. Pastikan tujuan dan keperluan sudah sesuai sebelum mengirim.</p>

            <form action="<?= site_url('mahasiswa/permohonan') ?>" method="POST" enctype="multipart/form-data" id="ajukanForm">
                <?= csrf_field() ?>

                <div class="section-label">
                    <span class="section-icon">01</span>
                    Informasi Permohonan
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="id_tujuan" class="form-label">Tujuan Permohonan <span class="required">*</span></label>
                        <select name="id_tujuan" id="id_tujuan" class="control" required>
                            <option value="" disabled <?= $oldTujuan === null || $oldTujuan === '' ? 'selected' : '' ?>>Pilih tujuan</option>
                            <?php foreach ($tujuan as $t): ?>
                                <option value="<?= esc($t['id_tujuan']) ?>" <?= (string)$oldTujuan === (string)$t['id_tujuan'] ? 'selected' : '' ?>>
                                    <?= esc($t['nama_tujuan']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="helper">Pilih jabatan/pihak yang menjadi tujuan permohonan.</div>
                    </div>

                    <div class="form-group">
                        <label for="keperluan" class="form-label">Keperluan <span class="required">*</span></label>
                        <input type="text" name="keperluan" id="keperluan" class="control" value="<?= esc($oldKeperluan ?? '') ?>" placeholder="Contoh: Surat Pengajuan Magang" maxlength="255" required>
                        <div class="helper">Tulis kebutuhan dokumen secara singkat dan jelas.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi Tambahan <span style="font-weight:500;color:#98A2B3;">(opsional)</span></label>
                    <textarea name="deskripsi" id="deskripsi" class="control" maxlength="2000" placeholder="Tambahkan konteks, catatan, atau informasi yang perlu diketahui admin..."><?= esc($oldDeskripsi ?? '') ?></textarea>
                    <div class="helper">Kamu tidak perlu mengisi bagian ini jika tidak ada informasi tambahan.</div>
                </div>

                <div class="section-label">
                    <span class="section-icon">02</span>
                    Bukti Pengumpulan Berkas Fisik
                </div>

                <div class="notice">
                    <div>ⓘ</div>
                    <div><strong>Wajib diisi.</strong> Unggah foto yang menunjukkan bukti pengumpulan berkas fisik. Kamu dapat mengirim beberapa foto sekaligus agar bukti lebih jelas.</div>
                </div>

                <div style="height:12px"></div>

                <div class="dropzone" id="dropzoneBox">
                    <div class="drop-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                    </div>
                    <div class="drop-title">Klik untuk memilih foto atau seret ke area ini</div>
                    <div class="drop-text">JPG, JPEG, PNG, atau WEBP • maksimal 5 MB per foto • maksimal 10 foto</div>
                    <input type="file" name="foto_bukti[]" id="foto_bukti" class="file-input" accept="image/png,image/jpeg,image/jpg,image/webp" multiple>
                </div>

                <div class="photo-counter" id="photoCounter">Belum ada foto dipilih.</div>
                <div class="preview-grid" id="photoPreviewGrid"></div>

                <div class="actions">
                    <a href="<?= site_url('mahasiswa/permohonan') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <span>Kirim Permohonan</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13"></path><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <aside>
            <div class="card side-card">
                <div class="side-head">
                    <div class="side-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    </div>
                    <div>
                        <h3>Alur Pengajuan</h3>
                        <p>Pastikan setiap tahap dilakukan sesuai urutan.</p>
                    </div>
                </div>

                <div class="steps">
                    <div class="step"><div class="step-num">1</div><div><strong>Isi formulir</strong><span>Pilih tujuan dan tulis keperluan permohonan.</span></div></div>
                    <div class="step"><div class="step-num">2</div><div><strong>Serahkan berkas fisik</strong><span>Kumpulkan berkas secara langsung sesuai prosedur jurusan.</span></div></div>
                    <div class="step"><div class="step-num">3</div><div><strong>Ambil foto bukti</strong><span>Foto tempat atau kondisi pengumpulan sebagai bukti fisik.</span></div></div>
                    <div class="step"><div class="step-num">4</div><div><strong>Kirim permohonan</strong><span>Admin akan menerima dan memeriksa pengajuanmu.</span></div></div>
                </div>

                <div class="limits">
                    <div class="limit-row"><span>Jumlah foto</span><strong>1–10 foto</strong></div>
                    <div class="limit-row"><span>Ukuran per foto</span><strong>Maks. 5 MB</strong></div>
                    <div class="limit-row"><span>Format</span><strong>JPG / PNG / WEBP</strong></div>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('ajukanForm');
    const input = document.getElementById('foto_bukti');
    const dropzone = document.getElementById('dropzoneBox');
    const grid = document.getElementById('photoPreviewGrid');
    const counter = document.getElementById('photoCounter');
    const submitBtn = document.getElementById('submitBtn');
    const maxPhotos = 10;
    const maxSize = 5 * 1024 * 1024;
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    let selectedFiles = [];

    function syncInputFiles() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;
    }

    function formatSize(bytes) {
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function renderPreviews() {
        grid.innerHTML = '';
        counter.textContent = selectedFiles.length === 0
            ? 'Belum ada foto dipilih.'
            : selectedFiles.length + ' foto dipilih. Maksimal ' + maxPhotos + ' foto.';

        selectedFiles.forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'preview-card';

            const img = document.createElement('img');
            img.className = 'preview-image';
            img.alt = 'Preview ' + file.name;
            const reader = new FileReader();
            reader.onload = e => img.src = e.target.result;
            reader.readAsDataURL(file);

            const meta = document.createElement('div');
            meta.className = 'preview-meta';
            const info = document.createElement('div');
            info.className = 'preview-info';

            const name = document.createElement('div');
            name.className = 'preview-name';
            name.textContent = file.name;
            name.title = file.name;

            const size = document.createElement('div');
            size.className = 'preview-size';
            size.textContent = formatSize(file.size);

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'remove-photo';
            remove.innerHTML = '×';
            remove.title = 'Hapus foto';
            remove.addEventListener('click', function () {
                selectedFiles.splice(index, 1);
                syncInputFiles();
                renderPreviews();
            });

            info.appendChild(name);
            info.appendChild(size);
            meta.appendChild(info);
            meta.appendChild(remove);
            card.appendChild(img);
            card.appendChild(meta);
            grid.appendChild(card);
        });
    }

    function addFiles(fileList) {
        for (const file of Array.from(fileList || [])) {
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({ icon:'error', title:'Format tidak didukung', text:file.name + ' harus berupa JPG, JPEG, PNG, atau WEBP.' });
                continue;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon:'error', title:'Ukuran terlalu besar', text:file.name + ' melebihi batas 5 MB.' });
                continue;
            }
            const duplicate = selectedFiles.some(existing => existing.name === file.name && existing.size === file.size && existing.lastModified === file.lastModified);
            if (!duplicate && selectedFiles.length < maxPhotos) selectedFiles.push(file);
        }
        if (selectedFiles.length >= maxPhotos && fileList && fileList.length > 0) {
            Swal.fire({ icon:'info', title:'Batas foto tercapai', text:'Maksimal 10 foto dapat dikirim.' });
        }
        syncInputFiles();
        renderPreviews();
    }

    input.addEventListener('change', function () { addFiles(this.files); });
    ['dragenter','dragover'].forEach(type => dropzone.addEventListener(type, e => { e.preventDefault(); dropzone.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(type => dropzone.addEventListener(type, e => { e.preventDefault(); dropzone.classList.remove('dragover'); }));
    dropzone.addEventListener('drop', e => addFiles(e.dataTransfer.files));

    form.addEventListener('submit', function (e) {
        syncInputFiles();
        if (selectedFiles.length < 1) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Bukti fisik belum ada', text:'Tambahkan minimal satu foto bukti pengumpulan berkas fisik.' });
            return;
        }
        if (selectedFiles.length > maxPhotos) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Terlalu banyak foto', text:'Maksimal 10 foto dapat dikirim.' });
            return;
        }
        submitBtn.disabled = true;
        submitBtn.style.opacity = '.72';
        submitBtn.querySelector('span').textContent = 'Mengirim...';
    });

    renderPreviews();
});
</script>

<?= $this->endSection() ?>
