<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JTI Signature - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --navy: #142E52;
            --blue: #2563EB;
            --indigo: #4F46E5;
            --soft-blue: #EAF1FF;
            --bg: #F4F7FC;
            --text: #172033;
            --muted: #667085;
            --border: #E2E8F0;
            --danger: #DC2626;
            --success: #059669;
        }

        * { box-sizing: border-box; }

        html, body {
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 10% 15%, rgba(37,99,235,.10), transparent 28%),
                radial-gradient(circle at 90% 85%, rgba(79,70,229,.10), transparent 30%),
                var(--bg);
        }

        .page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .shell {
            width: min(1160px, 100%);
            min-height: min(700px, calc(100vh - 56px));
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            overflow: hidden;
            border: 1px solid rgba(226,232,240,.95);
            border-radius: 28px;
            background: rgba(255,255,255,.96);
            box-shadow: 0 28px 70px rgba(20,46,82,.14);
        }

        .brand-side {
            position: relative;
            padding: 46px;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(20,46,82,.97), rgba(37,99,235,.94) 58%, rgba(79,70,229,.92));
        }

        .brand-side::before,
        .brand-side::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }

        .brand-side::before {
            width: 430px;
            height: 430px;
            top: -250px;
            right: -160px;
        }

        .brand-side::after {
            width: 310px;
            height: 310px;
            bottom: -180px;
            left: -120px;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            width: fit-content;
        }

        .brand-mark {
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.18);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: .04em;
            backdrop-filter: blur(8px);
        }

        .brand-name {
            line-height: 1.12;
        }

        .brand-name strong {
            display: block;
            font-size: 16px;
            font-weight: 800;
        }

        .brand-name span {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            color: rgba(255,255,255,.72);
        }

        .brand-copy {
            margin-top: auto;
            margin-bottom: auto;
            max-width: 470px;
            padding: 58px 0 46px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 8px 12px;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 999px;
            background: rgba(255,255,255,.09);
            color: rgba(255,255,255,.85);
            font-size: 11px;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .brand-copy h1 {
            margin: 0;
            font-size: clamp(33px, 4.2vw, 52px);
            line-height: 1.02;
            letter-spacing: -.045em;
        }

        .brand-copy p {
            margin: 18px 0 0;
            max-width: 440px;
            color: rgba(255,255,255,.78);
            font-size: 14px;
            line-height: 1.75;
        }

        .feature-list {
            display: grid;
            gap: 12px;
            margin-top: 30px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255,255,255,.88);
            font-size: 12px;
        }

        .feature i {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background: rgba(255,255,255,.12);
            font-size: 11px;
        }

        .brand-footer {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,.56);
            font-size: 10px;
            line-height: 1.6;
        }

        .form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 46px 58px;
            background: #fff;
        }

        .form-wrap {
            width: min(400px, 100%);
        }

        .form-top {
            margin-bottom: 28px;
        }

        .form-kicker {
            margin-bottom: 9px;
            color: var(--blue);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .form-top h2 {
            margin: 0;
            font-size: 30px;
            line-height: 1.15;
            letter-spacing: -.035em;
        }

        .form-top p {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .alert {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 16px;
            padding: 12px 13px;
            border-radius: 12px;
            font-size: 11px;
            line-height: 1.55;
        }

        .alert-error {
            color: #991B1B;
            background: #FEF2F2;
            border: 1px solid #FECACA;
        }

        .alert-success {
            color: #047857;
            background: #ECFDF5;
            border: 1px solid #A7F3D0;
        }

        .field {
            margin-bottom: 17px;
        }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            color: var(--text);
            font-size: 12px;
            font-weight: 800;
        }

        .field-box {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #98A2B3;
            font-size: 13px;
            pointer-events: none;
        }

        .field input {
            width: 100%;
            height: 50px;
            padding: 0 45px;
            border: 1px solid #D8E0EB;
            border-radius: 13px;
            outline: none;
            background: #FBFCFE;
            color: var(--text);
            font: inherit;
            font-size: 12px;
            transition: .2s ease;
        }

        .field input::placeholder {
            color: #98A2B3;
        }

        .field input:focus {
            background: #fff;
            border-color: #8BAAF4;
            box-shadow: 0 0 0 4px rgba(37,99,235,.08);
        }

        .password-button {
            position: absolute;
            right: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #98A2B3;
            cursor: pointer;
        }

        .password-button:hover {
            color: var(--blue);
            background: var(--soft-blue);
        }

        .login-button {
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), var(--indigo));
            font: inherit;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(37,99,235,.18);
            transition: .2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(37,99,235,.23);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 23px 0 16px;
            color: #98A2B3;
            font-size: 10px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .demo-box {
            padding: 14px;
            border: 1px solid #E5EBF3;
            border-radius: 14px;
            background: #F8FAFD;
        }

        .demo-title {
            margin-bottom: 9px;
            color: #475467;
            font-size: 10px;
            font-weight: 800;
        }

        .demo-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .demo-button {
            flex: 1 1 145px;
            min-height: 34px;
            border: 1px solid #D8E0EB;
            border-radius: 10px;
            background: #fff;
            color: #475467;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .demo-button:hover {
            color: var(--blue);
            border-color: #AFC4F7;
            background: #F6F9FF;
        }

        .help {
            margin-top: 17px;
            text-align: center;
            color: #98A2B3;
            font-size: 10px;
            line-height: 1.6;
        }

        .help strong {
            color: #667085;
        }

        @media (max-width: 900px) {
            .page { padding: 15px; }
            .shell {
                min-height: calc(100vh - 30px);
                grid-template-columns: 1fr;
            }
            .brand-side { min-height: 330px; padding: 30px; }
            .brand-copy { padding: 40px 0 25px; }
            .brand-copy h1 { font-size: 38px; }
            .form-side { padding: 38px 28px; }
        }

        @media (max-width: 520px) {
            .brand-side { min-height: 290px; padding: 24px; }
            .brand-copy { padding: 28px 0 18px; }
            .brand-copy p, .feature-list { display: none; }
            .brand-footer { display: none; }
            .form-side { padding: 30px 20px; }
            .form-top h2 { font-size: 27px; }
        }
    </style>
</head>

<body>
<div class="page">
    <main class="shell">

        <section class="brand-side">
            <div class="brand-content">
                <div class="brand">
                    <div class="brand-mark">JTI</div>
                    <div class="brand-name">
                        <strong>JTI Signature</strong>
                        <span>Academic Services Portal</span>
                    </div>
                </div>

                <div class="brand-copy">
                    <div class="eyebrow">
                        <i class="fa-solid fa-shield-halved"></i>
                        Portal Akademik Terintegrasi
                    </div>

                    <h1>Layanan akademik, lebih sederhana.</h1>

                    <p>
                        Akses layanan permohonan tanda tangan dan administrasi
                        Jurusan Teknologi Informasi dalam satu sistem yang rapi,
                        cepat, dan mudah dipantau.
                    </p>

                    <div class="feature-list">
                        <div class="feature">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Ajukan permohonan secara online</span>
                        </div>
                        <div class="feature">
                            <i class="fa-solid fa-timeline"></i>
                            <span>Pantau perkembangan permohonan</span>
                        </div>
                        <div class="feature">
                            <i class="fa-regular fa-image"></i>
                            <span>Simpan bukti pengumpulan berkas fisik</span>
                        </div>
                    </div>
                </div>

                <div class="brand-footer">
                    Sistem Tanda Tangan & Permohonan Akademik<br>
                    Jurusan Teknologi Informasi
                </div>
            </div>
        </section>

        <section class="form-side">
            <div class="form-wrap">

                <div class="form-top">
                    <div class="form-kicker">Selamat Datang</div>
                    <h2>Masuk ke akun Anda</h2>
                    <p>
                        Gunakan NIM atau email dan password untuk melanjutkan
                        ke JTI Signature.
                    </p>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div><?= esc(session()->getFlashdata('error')) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <div><?= esc(session()->getFlashdata('success')) ?></div>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="field">
                        <label class="field-label" for="email">NIM / Email</label>
                        <div class="field-box">
                            <i class="fa-regular fa-user field-icon"></i>
                            <input
                                type="text"
                                id="email"
                                name="email"
                                placeholder="Masukkan NIM atau email"
                                autocomplete="username"
                                required
                            >
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <div class="field-box">
                            <i class="fa-solid fa-lock field-icon"></i>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                            >
                            <button
                                type="button"
                                class="password-button"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password"
                            >
                                <i id="passwordIcon" class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-button">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        &nbsp; Masuk ke Sistem
                    </button>
                </form>

                <div class="divider">AKUN DEMO</div>

                <div class="demo-box">
                    <div class="demo-title">Untuk pengujian lokal</div>
                    <div class="demo-buttons">
                        <button
                            type="button"
                            class="demo-button"
                            onclick="fillLogin('budi@student.local','budi123')"
                        >
                            <i class="fa-solid fa-user-graduate"></i>
                            &nbsp; Mahasiswa
                        </button>

                        <button
                            type="button"
                            class="demo-button"
                            onclick="fillLogin('admin@jti.local','admin123')"
                        >
                            <i class="fa-solid fa-user-shield"></i>
                            &nbsp; Admin
                        </button>
                    </div>
                </div>

                <div class="help">
                    <strong>Butuh bantuan akses?</strong><br>
                    Hubungi administrator Jurusan Teknologi Informasi.
                </div>

            </div>
        </section>

    </main>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('passwordIcon');

    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function fillLogin(email, password) {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    if (emailInput) emailInput.value = email;
    if (passwordInput) passwordInput.value = password;
}
</script>
</body>
</html>
