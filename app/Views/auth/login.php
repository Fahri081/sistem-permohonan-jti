<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - JTI Signature</title>

    <!-- CSS Login -->
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
</head>

<body>

<div class="login-page">

    <!-- =========================
         PANEL KIRI
    ========================== -->
    <section class="login-panel">

        <div class="login-content">

            <!-- BRAND -->
            <div class="brand">

                <div class="brand-icon">
                    <span>JTI</span>
                </div>

                <div class="brand-name">
                    JTI Signature
                </div>

            </div>


            <!-- WELCOME -->
            <div class="welcome">

                <h2>Selamat Datang</h2>

                <p>
                    Portal Layanan Akademik Jurusan
                    <br>
                    Teknologi Informasi
                </p>

            </div>


            <!-- PESAN ERROR -->
            <?php if (session()->getFlashdata('error')) : ?>

                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>

                    <span>
                        <?= esc(session()->getFlashdata('error')) ?>
                    </span>
                </div>

            <?php endif; ?>


            <!-- PESAN SUCCESS -->
            <?php if (session()->getFlashdata('success')) : ?>

                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>

                    <span>
                        <?= esc(session()->getFlashdata('success')) ?>
                    </span>
                </div>

            <?php endif; ?>


            <!-- FORM LOGIN -->
            <form method="post" action="<?= site_url('login') ?>">

                <?= csrf_field() ?>


                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">
                        NIM / Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan NIM atau Email"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <div class="password-label">

                        <label for="password">
                            Password
                        </label>

                        <a href="#">
                            Lupa Password?
                        </a>

                    </div>


                    <div class="input-wrapper">

                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan Password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword()"
                            aria-label="Tampilkan password"
                        >
                            <i class="fa-solid fa-eye"></i>
                        </button>

                    </div>

                </div>


                <!-- BUTTON LOGIN -->
                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk
                </button>

            </form>


            <!-- BANTUAN -->
            <div class="help-text">

                <span>Butuh bantuan akses?</span>

                <a href="#">
                    Hubungi Admin JTI
                </a>

            </div>


            <!-- FOOTER -->
            <div class="login-footer">

                © 2024 Jurusan Teknologi Informasi.
                <br>
                All Rights Reserved.

            </div>

        </div>

    </section>


    <!-- =========================
         PANEL KANAN / FOTO
    ========================== -->
    <section class="login-image">

        <div class="image-overlay">

            <div class="image-text">

                <h2>
                    Inovasi Digital Akademik
                </h2>

                <p>
                    Mendukung ekosistem pendidikan yang modern,
                    efisien, dan terintegrasi untuk seluruh civitas
                    akademika.
                </p>

            </div>

        </div>

    </section>

</div>


<script>

function togglePassword()
{
    const passwordInput = document.getElementById('password');
    const icon = document.querySelector('.show-password i');

    if (passwordInput.type === 'password') {

        passwordInput.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

        document
            .querySelector('.show-password')
            .setAttribute('aria-label', 'Sembunyikan password');

    } else {

        passwordInput.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

        document
            .querySelector('.show-password')
            .setAttribute('aria-label', 'Tampilkan password');
    }
}

</script>

</body>
</html>