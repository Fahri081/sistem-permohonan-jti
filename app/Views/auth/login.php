<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JTI Signature</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
            border: 1px solid #e2e8f0;
            width: 100%;
            max-width: 420px;
            padding: 36px 32px;
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: #153a6b;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .brand-text h1 {
            font-size: 17px;
            font-weight: 700;
            color: #153a6b;
            line-height: 1.2;
        }

        .brand-text p {
            font-size: 12px;
            color: #64748b;
        }

        .login-title {
            font-size: 19px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13.5px;
            font-family: inherit;
            color: #1e293b;
            transition: all 0.15s;
        }

        .form-input:focus {
            outline: none;
            border-color: #153a6b;
            box-shadow: 0 0 0 3px rgba(21, 58, 107, 0.12);
        }

        .btn-submit {
            width: 100%;
            background-color: #153a6b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background-color: #1d4e8c;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fee2e2;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .demo-box {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #64748b;
        }

        .demo-box strong {
            color: #1e293b;
        }

        .quick-fill-btn {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11.5px;
            font-weight: 600;
            cursor: pointer;
            color: #334155;
            margin-top: 8px;
            margin-right: 6px;
            display: inline-block;
        }

        .quick-fill-btn:hover {
            background: #e2e8f0;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-brand">
            <div class="brand-logo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="brand-text">
                <h1>JTI Signature</h1>
                <p>Layanan Akademik</p>
            </div>
        </div>

        <h2 class="login-title">Masuk ke Akun</h2>
        <p class="login-subtitle">Silakan masukkan email dan kata sandi Anda</p>

        <?php if(session('error')): ?>
            <div class="alert-error">
                <?= esc(session('error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email" class="form-label">Email Kampus</label>
                <input type="email" name="email" id="email" class="form-input" placeholder="contoh: budi@jti.local" required value="budi@jti.local">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Masukkan password" required value="budi123">
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="demo-box">
            <div><strong>Akun Demo:</strong></div>
            <button type="button" class="quick-fill-btn" onclick="fillForm('budi@jti.local', 'budi123')">Mahasiswa: Budi Santoso</button>
            <button type="button" class="quick-fill-btn" onclick="fillForm('admin@jti.local', 'admin123')">Admin: Administrator</button>
        </div>
    </div>

    <script>
        function fillForm(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
