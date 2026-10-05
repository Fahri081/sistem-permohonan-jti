<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php
$role = $user['role'] ?? 'mahasiswa';

$roleLabel = match ($role) {
    'super_admin' => 'Super Admin',
    'admin'       => 'Admin Jurusan',
    default       => 'Mahasiswa',
};
?>

<style>
    .edit-user-page {
        width: 100%;
    }

    .edit-header {
        margin-bottom: 22px;
    }

    .edit-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        color: #667085;
        font-size: 11px;
        text-decoration: none;
    }

    .edit-breadcrumb:hover {
        color: #2563eb;
    }

    .edit-header h1 {
        margin: 0;
        color: #142e52;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .edit-header p {
        margin: 6px 0 0;
        color: #667085;
        font-size: 13px;
    }

    .edit-card {
        max-width: 850px;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(20, 46, 82, .07);
        overflow: hidden;
    }

    .edit-card-header {
        padding: 19px 22px;
        border-bottom: 1px solid #eef2f7;
    }

    .edit-card-header h2 {
        margin: 0;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
    }

    .edit-card-header p {
        margin: 5px 0 0;
        color: #98a2b3;
        font-size: 11px;
    }

    .edit-form {
        padding: 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        color: #344054;
        font-size: 11px;
        font-weight: 800;
    }

    .form-label span {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        min-height: 42px;
        padding: 0 12px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        outline: none;
        background: #fbfcfe;
        color: #344054;
        font-family: inherit;
        font-size: 12px;
        transition: .18s ease;
    }

    .form-control:focus {
        border-color: #b6c8f5;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    select.form-control {
        cursor: pointer;
    }

    .form-help {
        color: #98a2b3;
        font-size: 10px;
        line-height: 1.5;
    }

    .account-info {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 12px 13px;
        margin-bottom: 22px;
        border: 1px solid #dbe7ff;
        border-radius: 11px;
        background: #f6f9ff;
    }

    .account-info-icon {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 13px;
    }

    .account-info-text strong {
        display: block;
        color: #344054;
        font-size: 11px;
        font-weight: 800;
    }

    .account-info-text span {
        display: block;
        margin-top: 3px;
        color: #667085;
        font-size: 10px;
    }

    .edit-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #eef2f7;
    }

    .btn-secondary,
    .btn-primary {
        min-height: 40px;
        padding: 0 15px;
        border-radius: 9px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: .18s ease;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #475467;
    }

    .btn-secondary:hover {
        border-color: #c8d6f2;
        background: #f8faff;
        color: #2563eb;
    }

    .btn-primary {
        border: 0;
        background: #2563eb;
        color: #fff;
        box-shadow: 0 7px 18px rgba(37, 99, 235, .17);
    }

    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .edit-form {
            padding: 18px;
        }

        .edit-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-secondary,
        .btn-primary {
            width: 100%;
        }
    }
</style>


<div class="edit-user-page">

    <!-- HEADER -->

    <div class="edit-header">

        <a
            href="<?= site_url('admin/users/' . $user['id_user']) ?>"
            class="edit-breadcrumb"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Detail User
        </a>

        <h1>Edit User</h1>

        <p>
            Perbarui informasi akun pengguna JTI Signature.
        </p>

    </div>


    <section class="edit-card">

        <div class="edit-card-header">

            <h2>
                Informasi Akun
            </h2>

            <p>
                ID User #<?= esc($user['id_user']) ?>
            </p>

        </div>


        <form
            method="post"
            action="<?= site_url('admin/users/' . $user['id_user'] . '/update') ?>"
            class="edit-form"
        >

            <?= csrf_field() ?>


            <div class="account-info">

                <div class="account-info-icon">
                    <i class="fa-solid fa-user-pen"></i>
                </div>

                <div class="account-info-text">

                    <strong>
                        Sedang mengedit akun
                    </strong>

                    <span>
                        Perubahan akan diterapkan pada data pengguna
                        setelah disimpan.
                    </span>

                </div>

            </div>


            <div class="form-grid">

                <!-- NAMA -->

                <div class="form-group full">

                    <label
                        for="nama_lengkap"
                        class="form-label"
                    >
                        Nama Lengkap <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        class="form-control"
                        value="<?= esc($user['nama_lengkap'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- EMAIL -->

                <div class="form-group">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email <span>*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?= esc($user['email'] ?? '') ?>"
                        required
                    >

                </div>


                <!-- NO HP -->

                <div class="form-group">

                    <label
                        for="no_hp"
                        class="form-label"
                    >
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        class="form-control"
                        value="<?= esc($user['no_hp'] ?? '') ?>"
                    >

                </div>


                <!-- NIM -->

                <div class="form-group">

                    <label
                        for="nim"
                        class="form-label"
                    >
                        NIM
                    </label>

                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        class="form-control"
                        value="<?= esc($user['nim'] ?? '') ?>"
                    >

                    <div class="form-help">
                        Isi NIM untuk akun mahasiswa.
                    </div>

                </div>


                <!-- ROLE -->

                <div class="form-group">

                    <label
                        for="role"
                        class="form-label"
                    >
                        Role <span>*</span>
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="form-control"
                        required
                    >

                        <option
                            value="mahasiswa"
                            <?= $role === 'mahasiswa' ? 'selected' : '' ?>
                        >
                            Mahasiswa
                        </option>

                        <option
                            value="admin"
                            <?= $role === 'admin' ? 'selected' : '' ?>
                        >
                            Admin Jurusan
                        </option>

                        <option
                            value="super_admin"
                            <?= $role === 'super_admin' ? 'selected' : '' ?>
                        >
                            Super Admin
                        </option>

                    </select>

                    <div class="form-help">
                        Hak akses akun ditentukan berdasarkan role.
                    </div>

                </div>

            </div>


            <div class="edit-actions">

                <a
                    href="<?= site_url('admin/users/' . $user['id_user']) ?>"
                    class="btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-primary"
                >
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </section>

</div>

<?= $this->endSection() ?>