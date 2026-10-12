<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JTI Signature - Register</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <style>
        :root {
            --navy: #142E52;
            --navy-dark: #0D2038;
            --blue: #2563EB;
            --blue-dark: #1D4ED8;
            --indigo: #4F46E5;
            --soft-blue: #EAF1FF;
            --bg: #F4F7FC;
            --text: #172033;
            --muted: #667085;
            --border: #E2E8F0;
            --danger: #DC2626;
            --success: #059669;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            color: var(--text);

            background:
                radial-gradient(
                    circle at 10% 15%,
                    rgba(37, 99, 235, .10),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 85%,
                    rgba(79, 70, 229, .10),
                    transparent 30%
                ),
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

            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 28px;

            background: rgba(255, 255, 255, .96);

            box-shadow:
                0 28px 70px rgba(20, 46, 82, .14);
        }

        .brand-side {
            position: relative;
            padding: 46px;
            overflow: hidden;

            color: #fff;

            background:
                linear-gradient(
                    145deg,
                    #142E52 0%,
                    #2563EB 58%,
                    #4F46E5 100%
                );
        }

        .brand-side::before,
        .brand-side::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
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
            left: -100px;
        }

        .brand-content {
            position: relative;
            z-index: 1;

            height: 100%;

            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;

            display: grid;
            place-items: center;

            border-radius: 12px;

            background: rgba(255, 255, 255, .16);

            font-size: 12px;
            font-weight: 800;

            backdrop-filter: blur(8px);
        }

        .brand-name {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .brand-name strong {
            font-size: 14px;
        }

        .brand-name span {
            font-size: 9px;
            opacity: .75;
        }

        .brand-copy {
            padding: 90px 0 40px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 10px;

            border-radius: 999px;

            background: rgba(255, 255, 255, .10);

            font-size: 9px;
            font-weight: 700;
        }

        .brand-copy h1 {
            max-width: 460px;

            margin: 18px 0 14px;

            font-size: 48px;
            line-height: 1.05;
            letter-spacing: -.04em;
        }

        .brand-copy p {
            max-width: 470px;

            margin: 0;

            color: rgba(255, 255, 255, .78);

            font-size: 12px;
            line-height: 1.8;
        }

        .feature-list {
            margin-top: 28px;

            display: grid;
            gap: 12px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 10px;

            color: rgba(255, 255, 255, .88);

            font-size: 10px;
        }

        .feature i {
            width: 27px;
            height: 27px;

            display: grid;
            place-items: center;

            border-radius: 8px;

            background: rgba(255, 255, 255, .12);
        }

        .brand-footer {
            margin-top: auto;

            color: rgba(255, 255, 255, .55);

            font-size: 9px;
            line-height: 1.7;
        }

        .form-side {
            display: flex;
            align-items: center;

            padding: 44px;
        }

        .form-wrap {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }

        .form-top {
            margin-bottom: 24px;
        }

        .form-kicker {
            margin-bottom: 8px;

            color: var(--blue);

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .form-top h2 {
            margin: 0 0 8px;

            font-size: 31px;
            line-height: 1.15;
            letter-spacing: -.03em;
        }

        .form-top p {
            margin: 0;

            color: var(--muted);

            font-size: 11px;
            line-height: 1.7;
        }

        .alert {
            display: flex;
            gap: 10px;

            margin-bottom: 18px;
            padding: 12px 14px;

            border-radius: 12px;

            font-size: 10px;
            line-height: 1.5;
        }

        .alert-error {
            color: #991B1B;
            border: 1px solid #FECACA;
            background: #FEF2F2;
        }

        .error-list {
            margin: 5px 0 0;
            padding-left: 18px;
        }

        .field {
            margin-bottom: 14px;
        }

        .field-label {
            display: block;

            margin-bottom: 7px;

            color: #475467;

            font-size: 10px;
            font-weight: 800;
        }

        .field-box {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #98A2B3;

            font-size: 12px;
            pointer-events: none;
        }

        .field input {
            width: 100%;
            height: 48px;

            padding: 0 44px;

            border: 1px solid #D8E0EB;
            border-radius: 13px;

            outline: none;

            background: #FBFCFE;
            color: var(--text);

            font: inherit;
            font-size: 11px;

            transition: .2s ease;
        }

        .field input::placeholder {
            color: #98A2B3;
        }

        .field input:focus {
            background: #fff;
            border-color: #8BAAF4;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .08);
        }

        .password-button {
            position: absolute;

            right: 10px;
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

        .register-button {
            width: 100%;
            height: 50px;

            margin-top: 4px;

            border: 0;
            border-radius: 13px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    var(--blue),
                    var(--indigo)
                );

            font: inherit;
            font-size: 12px;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 10px 20px rgba(37, 99, 235, .18);

            transition: .2s ease;
        }

        .register-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 14px 24px rgba(37, 99, 235, .23);
        }

        .oauth-divider {
            display: flex;
            align-items: center;
            gap: 11px;

            margin: 18px 0 13px;

            color: #98A2B3;

            font-size: 9px;
            font-weight: 700;
            text-transform: lowercase;
        }

        .oauth-divider::before,
        .oauth-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .google-register-button {
            width: 100%;
            min-height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            padding: 0 16px;

            border: 1px solid #D8E0EB;
            border-radius: 13px;

            background: #fff;
            color: #344054;

            font: inherit;
            font-size: 11px;
            font-weight: 800;

            text-decoration: none;

            transition: .2s ease;
        }

        .google-register-button:hover {
            border-color: #B8C7E5;
            background: #F8FAFD;
            transform: translateY(-1px);

            box-shadow:
                0 8px 18px rgba(20, 46, 82, .08);
        }

        .google-icon {
            width: 22px;
            height: 22px;

            display: grid;
            place-items: center;

            flex: 0 0 22px;
        }

        .google-icon svg {
            display: block;
        }

        .login-link {
            margin-top: 18px;

            text-align: center;

            color: #98A2B3;

            font-size: 10px;
        }

        .login-link a {
            color: var(--blue);
            font-weight: 800;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 900px) {
            .page {
                padding: 15px;
            }

            .shell {
                min-height: calc(100vh - 30px);
                grid-template-columns: 1fr;
            }

            .brand-side {
                min-height: 300px;
                padding: 30px;
            }

            .brand-copy {
                padding: 55px 0 20px;
            }

            .brand-copy h1 {
                font-size: 38px;
            }

            .form-side {
                padding: 38px 28px;
            }
        }

        @media (max-width: 520px) {
            .brand-side {
                min-height: 250px;
                padding: 24px;
            }

            .brand-copy {
                padding: 30px 0 10px;
            }

            .brand-copy p,
            .feature-list,
            .brand-footer {
                display: none;
            }

            .form-side {
                padding: 30px 20px;
            }

            .form-top h2 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <main class="shell">

        <!-- BRAND SIDE -->
        <section class="brand-side">

            <div class="brand-content">

                <div class="brand">

                    <div class="brand-mark">
                        JTI
                    </div>

                    <div class="brand-name">

                        <strong>
                            JTI Signature
                        </strong>

                        <span>
                            Academic Services Portal
                        </span>

                    </div>

                </div>


                <div class="brand-copy">

                    <div class="eyebrow">

                        <i class="fa-solid fa-user-plus"></i>

                        Pendaftaran Akun

                    </div>

                    <h1>
                        Bergabung dengan JTI Signature.
                    </h1>

                    <p>
                        Buat akun mahasiswa untuk mengakses
                        layanan permohonan tanda tangan dan
                        administrasi akademik Jurusan Teknologi
                        Informasi.
                    </p>


                    <div class="feature-list">

                        <div class="feature">

                            <i class="fa-solid fa-user-graduate"></i>

                            <span>
                                Akun khusus mahasiswa
                            </span>

                        </div>


                        <div class="feature">

                            <i class="fa-solid fa-id-card"></i>

                            <span>
                                Data mahasiswa tersimpan di sistem
                            </span>

                        </div>


                        <div class="feature">

                            <i class="fa-solid fa-shield-halved"></i>

                            <span>
                                Akses akun terlindungi
                            </span>

                        </div>

                    </div>

                </div>


                <div class="brand-footer">

                    Sistem Tanda Tangan & Permohonan Akademik<br>

                    Jurusan Teknologi Informasi

                </div>

            </div>

        </section>


        <!-- FORM SIDE -->
        <section class="form-side">

            <div class="form-wrap">

                <div class="form-top">

                    <div class="form-kicker">
                        Buat Akun
                    </div>

                    <h2>
                        Daftar sebagai mahasiswa
                    </h2>

                    <p>
                        Lengkapi data berikut untuk membuat
                        akun JTI Signature.
                    </p>

                </div>


                <?php if (session()->getFlashdata('error')): ?>

                    <div class="alert alert-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <div>

                            <?= esc(
                                session()->getFlashdata('error')
                            ) ?>

                        </div>

                    </div>

                <?php endif; ?>


                <?php if (session()->getFlashdata('errors')): ?>

                    <div class="alert alert-error">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <div>

                            <strong>
                                Periksa kembali data:
                            </strong>

                            <ul class="error-list">

                                <?php foreach (
                                    session()->getFlashdata('errors')
                                    as $error
                                ): ?>

                                    <li>
                                        <?= esc($error) ?>
                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        </div>

                    </div>

                <?php endif; ?>


                <form
                    action="<?= site_url('register') ?>"
                    method="post"
                >

                    <?= csrf_field() ?>


                    <!-- NAMA -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="nama_lengkap"
                        >
                            Nama Lengkap
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-regular fa-user field-icon"
                            ></i>

                            <input
                                type="text"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                value="<?= esc(old('nama_lengkap')) ?>"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                required
                            >

                        </div>

                    </div>


                    <!-- NIM -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="nim"
                        >
                            NIM
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-solid fa-id-card field-icon"
                            ></i>

                            <input
                                type="text"
                                id="nim"
                                name="nim"
                                value="<?= esc(old('nim')) ?>"
                                placeholder="Masukkan NIM"
                                autocomplete="off"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                required
                            >

                        </div>

                    </div>


                    <!-- EMAIL -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="email"
                        >
                            Email
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-regular fa-envelope field-icon"
                            ></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="<?= esc(old('email')) ?>"
                                placeholder="Masukkan email aktif"
                                autocomplete="email"
                                required
                            >

                        </div>

                    </div>


                    <!-- NO HP -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="no_hp"
                        >
                            Nomor HP
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-solid fa-phone field-icon"
                            ></i>

                            <input
                                type="tel"
                                id="no_hp"
                                name="no_hp"
                                value="<?= esc(old('no_hp')) ?>"
                                placeholder="Contoh: 081234567890"
                                autocomplete="tel"
                                maxlength="15"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            >

                        </div>

                    </div>


                    <!-- PASSWORD -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="password"
                        >
                            Password
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-solid fa-lock field-icon"
                            ></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Minimal 6 karakter"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-button"
                                onclick="togglePassword(
                                    'password',
                                    'passwordIcon'
                                )"
                                aria-label="Tampilkan password"
                            >

                                <i
                                    id="passwordIcon"
                                    class="fa-regular fa-eye"
                                ></i>

                            </button>

                        </div>

                    </div>


                    <!-- KONFIRMASI PASSWORD -->
                    <div class="field">

                        <label
                            class="field-label"
                            for="konfirmasi_password"
                        >
                            Konfirmasi Password
                        </label>

                        <div class="field-box">

                            <i
                                class="fa-solid fa-lock field-icon"
                            ></i>

                            <input
                                type="password"
                                id="konfirmasi_password"
                                name="konfirmasi_password"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-button"
                                onclick="togglePassword(
                                    'konfirmasi_password',
                                    'confirmIcon'
                                )"
                                aria-label="Tampilkan password"
                            >

                                <i
                                    id="confirmIcon"
                                    class="fa-regular fa-eye"
                                ></i>

                            </button>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="register-button"
                    >

                        <i class="fa-solid fa-user-plus"></i>

                        &nbsp;

                        Buat Akun

                    </button>

                </form>


                <div class="oauth-divider">

                    <span>atau daftar dengan</span>

                </div>


                <a
                    href="<?= site_url('login/google?mode=register') ?>"
                    class="google-register-button"
                >

                    <span class="google-icon" aria-hidden="true">
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                fill="#4285F4"
                                d="M21.805 12.23c0-.79-.07-1.55-.22-2.27H12v4.3h5.49a4.69 4.69 0 0 1-2.04 3.08v2.56h3.3c1.93-1.78 3.05-4.39 3.05-7.67z"
                            />
                            <path
                                fill="#34A853"
                                d="M12 22c2.76 0 5.08-.91 6.77-2.47l-3.3-2.56c-.91.61-2.07.97-3.47.97-2.67 0-4.94-1.8-5.75-4.22H2.84v2.64A10.22 10.22 0 0 0 12 22z"
                            />
                            <path
                                fill="#FBBC05"
                                d="M6.25 13.72A6.15 6.15 0 0 1 5.92 12c0-.6.11-1.19.33-1.72V7.64H2.84A10 10 0 0 0 2 12c0 1.61.38 3.13 1.04 4.36l3.21-2.64z"
                            />
                            <path
                                fill="#EA4335"
                                d="M12 6.06c1.5 0 2.85.52 3.92 1.55l2.94-2.94C17.08 3.03 14.76 2 12 2A10.22 10.22 0 0 0 2.84 7.64l3.41 2.64C7.06 7.86 9.33 6.06 12 6.06z"
                            />
                        </svg>
                    </span>

                    <span>
                        Daftar dengan akun Google Polinema
                    </span>

                </a>


                <div class="login-link">

                    Sudah punya akun?

                    <a href="<?= site_url('login') ?>">
                        Masuk sekarang
                    </a>

                </div>

            </div>

        </section>

    </main>

</div>


<script>
function togglePassword(inputId, iconId)
{
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!input || !icon) {
        return;
    }

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
</script>

</body>
</html>
