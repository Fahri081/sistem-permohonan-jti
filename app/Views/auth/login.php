<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - JTI Signature</title>

    <link rel="stylesheet"
          href="<?= base_url('assets/css/login.css') ?>">
</head>

<body>

<div class="login-page">

    <!-- BAGIAN KIRI -->
    <section class="login-panel">

        <div class="login-content">

            <!-- BRAND -->
            <div class="brand">

                <div class="brand-icon">
                    JTI
                </div>

                <div>
                    <h1>JTI Signature</h1>
                </div>

            </div>


            <!-- HEADER LOGIN -->
            <div class="welcome">

                <h2>Selamat Datang</h2>

                <p>
                    Portal Layanan Akademik Jurusan<br>
                    Teknologi Informasi
                </p>

            </div>


            <!-- ERROR -->
            <?php if (session()->getFlashdata('error')) : ?>

                <div class="alert alert-error">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>


            <!-- SUCCESS -->
            <?php if (session()->getFlashdata('success')) : ?>

                <div class="alert alert-success">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>

            <?php endif; ?>


            <!-- FORM -->
            <form method="post" action="<?= site_url('login') ?>">

                <?= csrf_field() ?>

                <!-- EMAIL -->
                <div class="form-group">

                    <label for="email">
                        NIM / Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            ♙
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Masukkan NIM atau Email"
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
                            🔒
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan Password"
                            required
                        >

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword()"
                        >
                            ◉
                        </button>

                    </div>

                </div>


                <!-- BUTTON -->
                <button
                    type="submit"
                    class="login-button"
                >
                    Masuk
                </button>

            </form>


            <!-- HELP -->
            <div class="help-text">

                Butuh bantuan akses?

                <a href="#">
                    Hubungi Admin JTI
                </a>

            </div>


            <!-- FOOTER -->
            <div class="login-footer">

                © 2024 Jurusan Teknologi Informasi.
                All Rights Reserved.

            </div>

        </div>

    </section>


    <!-- BAGIAN KANAN / FOTO -->
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

    if (passwordInput.type === 'password') {

        passwordInput.type = 'text';

    } else {

        passwordInput.type = 'password';

    }
}

</script>

</body>
</html>