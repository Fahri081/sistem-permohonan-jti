<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
Detail Permohonan - JTI Signature
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$status = strtoupper((string) ($permohonan['nama_status'] ?? ''));
$statusKey = strtolower($status);

$idPermohonan = (int) ($permohonan['id_permohonan'] ?? 0);
$namaMahasiswa = (string) ($permohonan['nama_lengkap'] ?? '-');
$initial = strtoupper(substr(trim($namaMahasiswa), 0, 1));

$tanggalPengajuan = !empty($permohonan['tanggal_pengajuan'])
    ? date('d M Y, H:i', strtotime($permohonan['tanggal_pengajuan'])) . ' WIB'
    : '-';

$alasanPenolakan = (string) ($permohonan['keterangan_penolakan'] ?? '');

$adminBuktiFisik = is_array($buktiFisik ?? null) ? $buktiFisik : [];
if (empty($adminBuktiFisik) && !empty($permohonan['bukti_fisik'])) {
    $adminBuktiFisik[] = ['nama_file' => $permohonan['bukti_fisik']];
}
?>

<style>
.admin-detail-final {
    width: 100%;
    max-width: 1160px;
    margin: 0 auto;
    padding: 6px 20px 30px;
    color: #172033;
}
.admin-detail-final * { box-sizing: border-box; }

.adm-header {
    border-bottom: 1px solid #e1e7ef;
    padding-bottom: 13px;
    margin-bottom: 15px;
}

.adm-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #60728b;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 9px;
}
.adm-back:hover { color: #173f70; }

.adm-title-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 16px;
}
.adm-title {
    min-width: 0;
}
.adm-kicker {
    color: #71839c;
    font-size: 9.5px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
    margin-bottom: 3px;
}
.adm-title h1 {
    margin: 0;
    color: #10233f;
    font-size: 23px;
    line-height: 1.15;
}
.adm-date {
    margin-top: 4px;
    color: #647893;
    font-size: 11.5px;
}

.adm-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 12px;
    border: 1px solid #c8ddf8;
    border-radius: 999px;
    background: #eff7ff;
    color: #1574b8;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}
.adm-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #178bd2;
}
.adm-status-pill.diproses { background:#fff8e8; border-color:#f1dda7; color:#946100; }
.adm-status-pill.diproses .adm-status-dot { background:#d28e00; }
.adm-status-pill.ditolak { background:#fff1f1; border-color:#f0c6c6; color:#a52b2b; }
.adm-status-pill.ditolak .adm-status-dot { background:#dc3636; }
.adm-status-pill.selesai,
.adm-status-pill.diambil { background:#effbf5; border-color:#bce8d3; color:#08754a; }
.adm-status-pill.selesai .adm-status-dot,
.adm-status-pill.diambil .adm-status-dot { background:#0a9c63; }

.adm-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.42fr) minmax(330px, .86fr);
    gap: 16px;
    align-items: start;
}
.adm-left, .adm-right { min-width: 0; }

.adm-card {
    background: #fff;
    border: 1px solid #dfe6ee;
    border-radius: 13px;
    padding: 18px 19px;
    margin-bottom: 15px;
    box-shadow: 0 1px 2px rgba(15,23,42,.025);
}
.adm-card:last-child { margin-bottom: 0; }

.adm-card-head {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    margin-bottom: 14px;
}
.adm-icon {
    width: 31px;
    height: 31px;
    flex: 0 0 31px;
    display: grid;
    place-items: center;
    border-radius: 8px;
    background: #eef5ff;
    color: #2567c8;
}
.adm-icon.navy { background:#eff3f8; color:#173f70; }
.adm-icon.purple { background:#f4f0ff; color:#7352bc; }

.adm-card-head h2 {
    margin: 0;
    color: #14253e;
    font-size: 14.5px;
    line-height: 1.3;
}
.adm-card-head p {
    margin: 3px 0 0;
    color: #91a0b4;
    font-size: 10.5px;
    line-height: 1.4;
}

/* Student */
.adm-student {
    display: grid;
    grid-template-columns: auto minmax(0,1fr);
    gap: 12px;
    align-items: center;
}
.adm-avatar {
    width: 46px;
    height: 46px;
    display: grid;
    place-items: center;
    border-radius: 11px;
    background: #eaf2fb;
    color: #173e6c;
    font-size: 16px;
    font-weight: 800;
}
.adm-student h3 { margin:0; color:#12243d; font-size:16px; }
.adm-student span { display:block; margin-top:3px; color:#71839b; font-size:10.5px; }

.adm-student-meta {
    display: grid;
    grid-template-columns: repeat(3,minmax(0,1fr));
    gap: 12px;
    margin-top: 15px;
    padding-top: 14px;
    border-top: 1px solid #edf1f5;
}

/* Request */
.adm-request-grid {
    display: grid;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: 15px 18px;
}
.adm-full { grid-column:1 / -1; }
.adm-highlight { color:#173f70; font-weight:700; }

.adm-label {
    display:block;
    margin-bottom:5px;
    color:#91a0b4;
    font-size:9.5px;
    font-weight:800;
    letter-spacing:.06em;
    text-transform:uppercase;
}
.adm-value {
    display:block;
    color:#344760;
    font-size:11.5px;
    line-height:1.45;
    overflow-wrap:anywhere;
}
.adm-description {
    min-height: 48px;
    padding: 10px 11px;
    border: 1px solid #e9eef3;
    border-radius: 8px;
    background: #f8fafc;
    color: #465b74;
    font-size: 11.5px;
    line-height: 1.5;
}

/* Evidence */
.adm-photo-head {
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
    margin-bottom:13px;
}
.adm-photo-count {
    flex:0 0 auto;
    padding:5px 8px;
    border:1px solid #dfe6ee;
    border-radius:7px;
    background:#f8fafc;
    color:#53667d;
    font-size:10px;
    font-weight:700;
}
.adm-photo-grid {
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:9px;
}
.adm-photo {
    position:relative;
    display:block;
    overflow:hidden;
    aspect-ratio:4/3;
    border:1px solid #dfe6ee;
    border-radius:9px;
    background:#f7f9fb;
}
.adm-photo img {
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}
.adm-photo-tag {
    position:absolute;
    top:6px;
    left:6px;
    padding:3px 6px;
    border-radius:999px;
    background:rgba(16,31,51,.76);
    color:#fff;
    font-size:8.5px;
    font-weight:700;
}
.adm-empty {
    padding:24px 12px;
    border:1px dashed #cbd5e1;
    border-radius:9px;
    background:#f8fafc;
    text-align:center;
}
.adm-empty i { display:block; margin-bottom:7px; color:#94a3b8; font-size:22px; }
.adm-empty strong { display:block; color:#334155; font-size:11.5px; }
.adm-empty span { display:block; margin-top:3px; color:#94a3b8; font-size:10.5px; }

/* Decision */
.adm-control { margin-bottom:13px; }
.adm-control label {
    display:block;
    margin-bottom:5px;
    color:#53667d;
    font-size:9.5px;
    font-weight:800;
    letter-spacing:.06em;
    text-transform:uppercase;
}
.adm-control select,
.adm-control textarea {
    width:100%;
    border:1px solid #cbd5e1;
    border-radius:8px;
    background:#fff;
    color:#344760;
    font:inherit;
    font-size:11.5px;
}
.adm-control select { height:39px; padding:0 10px; }
.adm-control textarea {
    min-height:88px;
    padding:9px 10px;
    resize:vertical;
    line-height:1.45;
}
.adm-control select:focus,
.adm-control textarea:focus {
    outline:none;
    border-color:#2d68a8;
    box-shadow:0 0 0 3px rgba(45,104,168,.08);
}
.adm-reject-note {
    margin-bottom:11px;
    padding:8px 9px;
    border:1px solid #fee2e2;
    border-radius:7px;
    background:#fff4f4;
    color:#9c2d2d;
    font-size:10.5px;
    line-height:1.45;
}
.adm-save {
    width:100%;
    height:40px;
    border:0;
    border-radius:8px;
    background:#163f70;
    color:#fff;
    font-size:11.5px;
    font-weight:700;
    cursor:pointer;
}
.adm-save:hover { background:#103158; }

@media (max-width:900px) {
    .adm-grid { grid-template-columns:1fr; }
}
@media (max-width:620px) {
    .adm-title-row { align-items:flex-start; flex-direction:column; }
    .adm-student-meta,
    .adm-request-grid,
    .adm-photo-grid { grid-template-columns:1fr; }
    .adm-full { grid-column:auto; }
    .admin-detail-final { padding-left:12px; padding-right:12px; }
}
</style>

<div class="admin-detail-final">

    <header class="adm-header">
        <a href="<?= site_url('admin/permohonan') ?>" class="adm-back">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        <div class="adm-title-row">
            <div class="adm-title">
                <div class="adm-kicker">Detail Permohonan</div>
                <h1>REQ-<?= esc($idPermohonan) ?></h1>
                <div class="adm-date">
                    Diajukan <?= esc($tanggalPengajuan) ?>
                </div>
            </div>

            <div class="adm-status-pill <?= esc($statusKey) ?>">
                <span class="adm-status-dot"></span>
                <?= esc($status !== '' ? ucfirst(strtolower($status)) : 'Tidak diketahui') ?>
            </div>
        </div>
    </header>

    <div class="adm-grid">

        <main class="adm-left">

            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h2>Informasi Mahasiswa</h2>
                        <p>Data pemohon yang mengajukan permohonan.</p>
                    </div>
                </div>

                <div class="adm-student">
                    <div class="adm-avatar"><?= esc($initial ?: 'M') ?></div>
                    <div>
                        <h3><?= esc($namaMahasiswa) ?></h3>
                        <span>Mahasiswa / Pemohon</span>
                    </div>
                </div>

                <div class="adm-student-meta">

                    <div>
                        <span class="adm-label">NIM</span>
                        <span class="adm-value"><?= esc($permohonan['nim'] ?? '-') ?></span>
                    </div>

                    <div>
                        <span class="adm-label">Email</span>
                        <span class="adm-value"><?= esc($permohonan['email'] ?? '-') ?></span>
                    </div>

                    <div>
                        <span class="adm-label">No. Handphone</span>
                        <span class="adm-value"><?= esc($permohonan['no_hp'] ?? '-') ?></span>
                    </div>

                </div>

            </section>


            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-icon navy">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div>
                        <h2>Informasi Permohonan</h2>
                        <p>Detail permintaan tanda tangan mahasiswa.</p>
                    </div>
                </div>

                <div class="adm-request-grid">

                    <div>
                        <span class="adm-label">Tujuan Tanda Tangan</span>
                        <span class="adm-value adm-highlight">
                            <?= esc($permohonan['nama_tujuan'] ?? '-') ?>
                        </span>
                    </div>

                    <div>
                        <span class="adm-label">Tanggal Pengajuan</span>
                        <span class="adm-value"><?= esc($tanggalPengajuan) ?></span>
                    </div>

                    <div class="adm-full">
                        <span class="adm-label">Keperluan</span>
                        <span class="adm-value">
                            <?= esc($permohonan['keperluan'] ?? '-') ?>
                        </span>
                    </div>

                    <div class="adm-full">
                        <span class="adm-label">Deskripsi</span>

                        <div class="adm-description">
                            <?php if (!empty($permohonan['deskripsi'])): ?>
                                <?= nl2br(esc($permohonan['deskripsi'])) ?>
                            <?php else: ?>
                                <span style="color:#94a3b8;">
                                    Tidak ada deskripsi tambahan.
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </section>

        </main>


        <aside class="adm-right">

            <section class="adm-card">

                <div class="adm-photo-head">

                    <div class="adm-card-head">
                        <div class="adm-icon">
                            <i class="fa-regular fa-images"></i>
                        </div>

                        <div>
                            <h2>Bukti Pengumpulan Berkas Fisik</h2>
                            <p>
                                Foto sebagai bukti mahasiswa telah
                                menempatkan berkas fisik di ruang pengumpulan.
                            </p>
                        </div>
                    </div>

                    <span class="adm-photo-count">
                        <?= count($adminBuktiFisik) ?> foto
                    </span>

                </div>

                <?php if (!empty($adminBuktiFisik)): ?>

                    <div class="adm-photo-grid">

                        <?php foreach ($adminBuktiFisik as $index => $foto): ?>

                            <?php
                            $namaFoto = (string) ($foto['nama_file'] ?? '');
                            $fotoUrl = $namaFoto !== ''
                                ? base_url('uploads/bukti_fisik/' . $namaFoto)
                                : '';
                            ?>

                            <?php if ($fotoUrl !== ''): ?>

                                <a
                                    href="<?= esc($fotoUrl) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="adm-photo"
                                >
                                    <img
                                        src="<?= esc($fotoUrl) ?>"
                                        alt="Bukti Pengumpulan Foto <?= $index + 1 ?>"
                                    >

                                    <span class="adm-photo-tag">
                                        Foto <?= $index + 1 ?>
                                    </span>
                                </a>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <div class="adm-empty">
                        <i class="fa-regular fa-image"></i>
                        <strong>Belum ada foto bukti</strong>
                        <span>
                            Mahasiswa belum mengunggah foto bukti pengumpulan.
                        </span>
                    </div>

                <?php endif; ?>

            </section>


            <section class="adm-card">

                <div class="adm-card-head">
                    <div class="adm-icon purple">
                        <i class="fa-solid fa-gavel"></i>
                    </div>

                    <div>
                        <h2>Keputusan Admin</h2>
                        <p>
                            Tentukan keputusan setelah memeriksa permohonan
                            dan bukti.
                        </p>
                    </div>
                </div>

                <form
                    action="<?= site_url('admin/permohonan/' . $idPermohonan . '/status') ?>"
                    method="post"
                    id="admStatusForm"
                >

                    <?= csrf_field() ?>

                    <div class="adm-control">
                        <label for="admStatus">
                            Status Permohonan
                        </label>

                        <select name="status" id="admStatus" required>

                            <option value="DIAJUKAN" <?= $status === 'DIAJUKAN' ? 'selected' : '' ?>>
                                Diajukan
                            </option>

                            <option value="DIPROSES" <?= $status === 'DIPROSES' ? 'selected' : '' ?>>
                                Diproses
                            </option>

                            <option value="DITOLAK" <?= $status === 'DITOLAK' ? 'selected' : '' ?>>
                                Ditolak
                            </option>

                            <option value="SELESAI" <?= $status === 'SELESAI' ? 'selected' : '' ?>>
                                Selesai
                            </option>

                            <option value="DIAMBIL" <?= $status === 'DIAMBIL' ? 'selected' : '' ?>>
                                Diambil
                            </option>

                        </select>
                    </div>

                    <div
                        class="adm-control"
                        id="admReasonWrap"
                        style="<?= $status === 'DITOLAK' ? '' : 'display:none;' ?>"
                    >
                        <label for="admReason">
                            Alasan Penolakan
                        </label>

                        <textarea
                            name="keterangan_penolakan"
                            id="admReason"
                            placeholder="Jelaskan bagian yang perlu diperbaiki mahasiswa..."
                        ><?= esc($alasanPenolakan) ?></textarea>
                    </div>

                    <?php if ($status === 'DITOLAK' && $alasanPenolakan !== ''): ?>
                        <div class="adm-reject-note">
                            <strong>Alasan saat ini:</strong><br>
                            <?= nl2br(esc($alasanPenolakan)) ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="adm-save">
                        Simpan Perubahan
                    </button>

                </form>

            </section>

        </aside>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('admStatusForm');
    const status = document.getElementById('admStatus');
    const reasonWrap = document.getElementById('admReasonWrap');
    const reason = document.getElementById('admReason');

    if (!form || !status || !reasonWrap || !reason) {
        return;
    }

    function toggleReason() {
        const rejected = status.value === 'DITOLAK';
        reasonWrap.style.display = rejected ? '' : 'none';

        if (!rejected) {
            reason.value = '';
        }
    }

    status.addEventListener('change', toggleReason);
    toggleReason();

    form.addEventListener('submit', function (event) {
        const selected = status.value;
        const message = reason.value.trim();

        if (selected === 'DITOLAK' && message === '') {
            event.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Alasan belum diisi',
                text: 'Masukkan alasan penolakan terlebih dahulu.'
            });

            reason.focus();
            return;
        }

        if (selected === 'DITOLAK') {
            event.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Tolak permohonan?',
                text: 'Mahasiswa akan menerima alasan penolakan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
});
</script>

<?= $this->endSection() ?>