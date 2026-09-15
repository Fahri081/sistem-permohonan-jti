<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>
<style>
    .profile-page { max-width: 980px; margin: 0 auto; }
    .page-heading { margin-bottom: 22px; }
    .page-heading h2 { font-size: 24px; color: #1e293b; margin-bottom: 6px; }
    .page-heading p { color: #64748b; font-size: 13.5px; }
    .profile-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 8px rgba(15,23,42,.04); }
    .profile-top { padding: 28px; background: linear-gradient(135deg,#f8fbff,#fff); border-bottom: 1px solid #e2e8f0; display:flex; align-items:center; gap:18px; }
    .profile-avatar { width:76px; height:76px; border-radius:50%; object-fit:cover; border:3px solid #fff; box-shadow:0 3px 10px rgba(15,23,42,.12); }
    .profile-avatar-fallback { width:76px; height:76px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#133863; color:#fff; font-size:25px; font-weight:800; }
    .profile-top h3 { font-size:19px; margin-bottom:5px; color:#1e293b; }
    .profile-top span { font-size:13px; color:#64748b; }
    .profile-body { padding:28px; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    .form-group { display:flex; flex-direction:column; gap:7px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:13px; font-weight:600; color:#334155; }
    .form-group input { width:100%; padding:11px 13px; border:1px solid #cbd5e1; border-radius:9px; font:inherit; font-size:13.5px; outline:none; transition:.15s; }
    .form-group input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.10); }
    .form-group input[readonly] { background:#f8fafc; color:#64748b; }
    .hint { font-size:11.5px; color:#94a3b8; }
    .form-actions { margin-top:24px; display:flex; justify-content:flex-end; }
    .btn-save { border:0; background:#133863; color:#fff; padding:11px 18px; border-radius:9px; font:600 13px inherit; cursor:pointer; }
    .btn-save:hover { background:#0f2e51; }
    @media(max-width:700px){ .form-grid{grid-template-columns:1fr}.form-group.full{grid-column:auto}.profile-body,.profile-top{padding:20px}.profile-avatar,.profile-avatar-fallback{width:64px;height:64px}.profile-top h3{font-size:17px} }
</style>

<div class="profile-page">
    <div class="page-heading">
        <h2>Profil Mahasiswa</h2>
        <p>Kelola informasi pribadi yang digunakan dalam Sistem Tanda Tangan JTI.</p>
    </div>

    <div class="profile-card">
        <div class="profile-top">
            <img
                src="<?= base_url('assets/images/avatar_budi.jpg') ?>"
                alt="<?= esc($user['nama_lengkap']) ?>"
                class="profile-avatar"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="profile-avatar-fallback" style="display:none;">
                <?= esc(strtoupper(substr($user['nama_lengkap'], 0, 1))) ?>
            </div>
            <div>
                <h3><?= esc($user['nama_lengkap']) ?></h3>
                <span>Mahasiswa · NIM <?= esc($user['nim'] ?? '-') ?></span>
            </div>
        </div>

        <div class="profile-body">
            <form action="<?= site_url('mahasiswa/profil') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <div class="form-group full">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= esc($user['nama_lengkap'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" id="nim" value="<?= esc($user['nim'] ?? '-') ?>" readonly>
                        <span class="hint">NIM merupakan identitas mahasiswa dan tidak dapat diubah.</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="text" id="no_hp" name="no_hp" value="<?= esc($user['no_hp'] ?? '') ?>" placeholder="Contoh: 081234567890">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
