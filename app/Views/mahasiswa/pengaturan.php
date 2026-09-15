<?= $this->extend('mahasiswa/layout') ?>

<?= $this->section('content') ?>
<style>
    .settings-page { max-width: 820px; margin: 0 auto; }
    .page-heading { margin-bottom: 22px; }
    .page-heading h2 { font-size: 24px; color:#1e293b; margin-bottom:6px; }
    .page-heading p { color:#64748b; font-size:13.5px; }
    .setting-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; padding:26px; box-shadow:0 2px 8px rgba(15,23,42,.04); margin-bottom:18px; }
    .setting-title { display:flex; align-items:center; gap:11px; margin-bottom:8px; }
    .setting-icon { width:38px; height:38px; border-radius:10px; background:#eff6ff; color:#133863; display:flex; align-items:center; justify-content:center; }
    .setting-title h3 { font-size:16px; color:#1e293b; }
    .setting-desc { font-size:12.5px; color:#64748b; margin-bottom:22px; line-height:1.6; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
    .form-group { display:flex; flex-direction:column; gap:7px; }
    .form-group.full { grid-column:1/-1; }
    .form-group label { font-size:13px; font-weight:600; color:#334155; }
    .form-group input { width:100%; padding:11px 13px; border:1px solid #cbd5e1; border-radius:9px; font:inherit; font-size:13.5px; outline:none; }
    .form-group input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.10); }
    .password-hint { font-size:11.5px; color:#94a3b8; }
    .form-actions { margin-top:22px; display:flex; justify-content:flex-end; }
    .btn-save { border:0; background:#133863; color:#fff; padding:11px 18px; border-radius:9px; font:600 13px inherit; cursor:pointer; }
    .btn-save:hover { background:#0f2e51; }
    .info-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px 16px; color:#64748b; font-size:12.5px; line-height:1.6; }
    @media(max-width:700px){.form-grid{grid-template-columns:1fr}.form-group.full{grid-column:auto}.setting-card{padding:20px}.page-heading h2{font-size:21px}}
</style>

<div class="settings-page">
    <div class="page-heading">
        <h2>Pengaturan</h2>
        <p>Atur keamanan akun dan preferensi yang berkaitan dengan penggunaan sistem.</p>
    </div>

    <div class="setting-card">
        <div class="setting-title">
            <div class="setting-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h3>Ubah Password</h3>
        </div>
        <p class="setting-desc">Gunakan password yang kuat dan jangan membagikannya kepada orang lain.</p>

        <form action="<?= site_url('mahasiswa/pengaturan/password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group full">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" id="password_lama" name="password_lama" required autocomplete="current-password">
                </div>

                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" minlength="6" required autocomplete="new-password">
                    <span class="password-hint">Minimal 6 karakter.</span>
                </div>

                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" minlength="6" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Password</button>
            </div>
        </form>
    </div>

    <div class="setting-card">
        <div class="setting-title">
            <div class="setting-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <h3>Notifikasi</h3>
        </div>
        <p class="setting-desc">Notifikasi penting dari admin akan tetap dikirim melalui sistem, misalnya ketika status permohonan berubah, permohonan ditolak, selesai, atau siap diambil.</p>
        <div class="info-box">Saat ini notifikasi sistem aktif secara otomatis untuk memastikan kamu tidak melewatkan pembaruan permohonan.</div>
    </div>
</div>
<?= $this->endSection() ?>
