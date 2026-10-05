<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JTI Signature - Lengkapi Akun</title>

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
            --blue: #2563EB;
            --indigo: #4F46E5;
            --soft-blue: #EAF1FF;
            --bg: #F4F7FC;
            --text: #172033;
            --muted: #667085;
            --border: #E2E8F0;
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

        .card {
            width: min(560px, 100%);

            padding: 38px;

            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 24px;

            background: rgba(255, 255, 255, .97);

            box-shadow:
                0 24px 60px rgba(20, 46, 82, .12);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 28px;
        }

        .brand-mark {
            width: 44px;
            height: 44px;

            display: grid;
            place-items: center;

            border-radius: 12px;

            color: #fff;
            background:
                linear-gradient(
                    135deg,
                    var(--navy),
                    var(--blue)
                );

            font-size: 12px;
            font-weight: 800;
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
            color: var(--muted);
            font-size: 9px;
        }

        .kicker {
            margin-bottom: 8px;

            color: var(--blue);

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: .08em;
        }

        h1 {
            margin: 0 0 9px;

            font-size: 30px;
            line-height: 1.15;
            letter-spacing: -.03em;
        }

        .description {
            margin: 0 0 24px;

            color: var(--muted);

            font-size: 11px;
            line-height: 1.7;
        }

        .alert {
            display: flex;
            gap: 10px;

            margin-bottom: 18px;
            padding: 12px 14px;

            border: 1px solid #FECACA;
            border-radius: 12px;

            color: #991B1B;
            background: #FEF2F2;

            font-size: 10px;
            line-height: 1.5;
        }

        .error-list {
            margin: 5px 0 0;
            padding-left: 18px;
        }

        .field {
            margin-bottom: 16px;
        }

        .label {
            display: block;

            margin-bottom: 7px;

            color: #475467;

            font-size: 10px;
            font-weight: 800;
        }

        .box {
            position: relative;
        }

        .icon {
            position: absolute;
            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #98A2B3;
            font-size: 12px;
        }

        input {
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

        input:focus {
            background: #fff;
            border-color: #8BAAF4;

            box-shadow:
                0 0 0 4px rgba(37, 99, 235, .08);
        }

        input[readonly] {
            background: #F6F8FC;
            color: #667085;
            cursor: not-allowed;
        }

        .submit-button {
            width: 100%;
            height: 50px;

            margin-top: 5px;

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
        }

        .submit-button:hover {
            transform: translateY(-1px);
        }

        .back {
            display: block;

            margin-top: 16px;

            text-align: center;

            color: var(--blue);

            font-size: 10px;
            font-weight: 800;

            text-decoration: none;
        }

        .note {
            margin-top: 18px;
            padding: 12px 14px;

            border-radius: 12px;

            background: var(--soft-blue);

            color: #475467;

            font-size: 10px;
            line-height: 1.6;
        }

        @media (max-width: 520px) {
            .page {
                padding: 16px;
            }

            .card {
                padding: 26px 20px;
            }

            h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <main class="card">

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


        <div class="kicker">
            Pendaftaran Akun Polinema
        </div>

        <h1>
            Lengkapi data akun
        </h1>

        <p class="description">
            Akun Google berhasil diverifikasi.
            Lengkapi data mahasiswa berikut agar akun
            dapat dibuat di JTI Signature.
        </p>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="alert">

                <i class="fa-solid fa-circle-exclamation"></i>

                <div>
                    <?= esc(
                        session()->getFlashdata('error')
                    ) ?>
                </div>

            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('errors')): ?>

            <div class="alert">

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
            action="<?= site_url('register/google') ?>"
            method="post"
        >

            <?= csrf_field() ?>


            <div class="field">

                <label class="label">
                    Nama Lengkap
                </label>

                <div class="box">

                    <i
                        class="fa-regular fa-user icon"
                    ></i>

                    <input
                        type="text"
                        value="<?= esc(
                            $googleRegistration['nama'] ?? ''
                        ) ?>"
                        readonly
                    >

                </div>

            </div>


            <div class="field">

                <label class="label">
                    Email
                </label>

                <div class="box">

                    <i
                        class="fa-regular fa-envelope icon"
                    ></i>

                    <input
                        type="email"
                        value="<?= esc(
                            $googleRegistration['email'] ?? ''
                        ) ?>"
                        readonly
                    >

                </div>

            </div>


            <div class="field">

                <label
                    class="label"
                    for="nim"
                >
                    NIM
                </label>

                <div class="box">

                    <i
                        class="fa-solid fa-id-card icon"
                    ></i>

                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        value="<?= old('nim') ?>"
                        placeholder="Masukkan NIM"
                        maxlength="20"
                        required
                    >

                </div>

            </div>


            <div class="field">

                <label
                    class="label"
                    for="no_hp"
                >
                    Nomor HP
                </label>

                <div class="box">

                    <i
                        class="fa-solid fa-phone icon"
                    ></i>

                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="<?= old('no_hp') ?>"
                        placeholder="Contoh: 081234567890"
                        maxlength="15"
                    >

                </div>

            </div>


            <button
                type="submit"
                class="submit-button"
            >

                <i class="fa-solid fa-user-plus"></i>

                &nbsp;

                Buat Akun & Masuk

            </button>

        </form>


        <a
            class="back"
            href="<?= site_url('login') ?>"
        >
            ← Kembali ke halaman login
        </a>


        <div class="note">

            <i class="fa-solid fa-circle-info"></i>

            &nbsp;

            Nama dan email diambil dari akun Google yang
            digunakan. Setelah akun dibuat, email dan
            Google ID akan tersimpan di database sistem.

        </div>

    </main>

</div>

</body>
</html>
