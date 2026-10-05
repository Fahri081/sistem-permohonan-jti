<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php

$role = $user['role'] ?? '';

if ($role === 'super_admin') {
    $roleLabel = 'Super Admin';
    $roleClass = 'detail-role-super';
    $roleIcon = 'fa-user-gear';
} elseif ($role === 'admin') {
    $roleLabel = 'Admin Jurusan';
    $roleClass = 'detail-role-admin';
    $roleIcon = 'fa-user-shield';
} else {
    $roleLabel = 'Mahasiswa';
    $roleClass = 'detail-role-mahasiswa';
    $roleIcon = 'fa-user-graduate';
}

$nama = trim(
    (string) ($user['nama_lengkap'] ?? '')
);

$initial = $nama !== ''
    ? strtoupper(substr($nama, 0, 1))
    : 'U';

?>

<style>
    .user-detail-page {
        width: 100%;
    }

    .detail-header {
        margin-bottom: 22px;
    }

    .detail-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        color: #667085;
        font-size: 11px;
        text-decoration: none;
    }

    .detail-breadcrumb:hover {
        color: #2563eb;
    }

    .detail-header h1 {
        margin: 0;
        color: #142e52;
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .detail-header p {
        margin: 6px 0 0;
        color: #667085;
        font-size: 13px;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 320px minmax(0, 1fr);
        gap: 18px;
        align-items: start;
    }

    .profile-card,
    .info-card {
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(20, 46, 82, .07);
    }

    /* PROFILE */

    .profile-card {
        padding: 26px 22px;
        text-align: center;
    }

    .profile-avatar {
        width: 78px;
        height: 78px;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 22px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 27px;
        font-weight: 800;
    }

    .profile-name {
        margin: 0;
        color: #142e52;
        font-size: 19px;
        font-weight: 800;
    }

    .profile-id {
        margin-top: 6px;
        color: #98a2b3;
        font-size: 11px;
    }

    .profile-role {
        margin-top: 14px;
    }

    .detail-role {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
    }

    .detail-role-mahasiswa {
        background: #f2f4f7;
        color: #667085;
    }

    .detail-role-admin {
        background: #eaf1ff;
        color: #2563eb;
    }

    .detail-role-super {
        background: #efedff;
        color: #5b4bc4;
    }

    .profile-divider {
        height: 1px;
        margin: 22px 0;
        background: #eef2f7;
    }

    .profile-note {
        text-align: left;
    }

    .profile-note-label {
        color: #98a2b3;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .profile-note-text {
        margin-top: 6px;
        color: #475467;
        font-size: 11px;
        line-height: 1.6;
    }

    /* INFO */

    .info-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
    }

    .info-card-header h2 {
        margin: 0;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
    }

    .info-card-header p {
        margin: 5px 0 0;
        color: #98a2b3;
        font-size: 11px;
    }

    .info-body {
        padding: 6px 20px 20px;
    }

    .info-row {
        display: grid;
        grid-template-columns: 180px minmax(0, 1fr);
        gap: 20px;
        padding: 16px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .info-row:last-child {
        border-bottom: 0;
    }

    .info-label {
        color: #667085;
        font-size: 11px;
        font-weight: 700;
    }

    .info-value {
        color: #344054;
        font-size: 12px;
        font-weight: 600;
        word-break: break-word;
    }

    .info-value.muted {
        color: #98a2b3;
        font-weight: 500;
    }

    .detail-footer {
        margin-top: 18px;
        display: flex;
        justify-content: flex-start;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 39px;
        padding: 0 14px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #fff;
        color: #475467;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .18s ease;
    }

    .btn-back:hover {
        border-color: #c8d6f2;
        background: #f6f9ff;
        color: #2563eb;
    }

    @media (max-width: 850px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 560px) {
        .info-row {
            grid-template-columns: 1fr;
            gap: 5px;
        }
    }
</style>


<div class="user-detail-page">

    <!-- HEADER -->

    <div class="detail-header">

        <a
            href="<?= site_url('admin/users') ?>"
            class="detail-breadcrumb"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Manage User
        </a>

        <h1>Detail User</h1>

        <p>
            Informasi lengkap akun pengguna JTI Signature.
        </p>

    </div>


    <div class="detail-layout">

        <!-- PROFILE -->

        <section class="profile-card">

            <div class="profile-avatar">
                <?= esc($initial) ?>
            </div>

            <h2 class="profile-name">
                <?= esc($nama ?: '-') ?>
            </h2>

            <div class="profile-id">
                ID User #<?= esc($user['id_user']) ?>
            </div>

            <div class="profile-role">

                <span class="detail-role <?= esc($roleClass) ?>">

                    <i class="fa-solid <?= esc($roleIcon) ?>"></i>

                    <?= esc($roleLabel) ?>

                </span>

            </div>


            <div class="profile-divider"></div>


            <div class="profile-note">

                <div class="profile-note-label">
                    Hak Akses
                </div>

                <div class="profile-note-text">

                    <?php if ($role === 'super_admin'): ?>

                        Pengguna memiliki hak akses Super Admin
                        termasuk pengelolaan akun pengguna.

                    <?php elseif ($role === 'admin'): ?>

                        Pengguna memiliki akses Administrator
                        untuk mengelola permohonan jurusan.

                    <?php else: ?>

                        Pengguna memiliki akses sebagai mahasiswa
                        untuk mengajukan dan memantau permohonan.

                    <?php endif; ?>

                </div>

            </div>

        </section>


        <!-- INFORMASI -->

        <section class="info-card">

            <div class="info-card-header">

                <h2>Informasi Akun</h2>

                <p>
                    Data yang tersimpan pada sistem.
                </p>

            </div>


            <div class="info-body">

                <div class="info-row">

                    <div class="info-label">
                        Nama Lengkap
                    </div>

                    <div class="info-value">
                        <?= esc($user['nama_lengkap'] ?? '-') ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Email
                    </div>

                    <div class="info-value">
                        <?= esc($user['email'] ?? '-') ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Nomor HP
                    </div>

                    <div class="info-value">
                        <?= esc($user['no_hp'] ?? '-') ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        NIM
                    </div>

                    <div
                        class="info-value <?= empty($user['nim']) ? 'muted' : '' ?>"
                    >
                        <?= esc($user['nim'] ?? '-') ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Role
                    </div>

                    <div class="info-value">

                        <span class="detail-role <?= esc($roleClass) ?>">

                            <i class="fa-solid <?= esc($roleIcon) ?>"></i>

                            <?= esc($roleLabel) ?>

                        </span>

                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        User ID
                    </div>

                    <div class="info-value">
                        #<?= esc($user['id_user']) ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Terdaftar
                    </div>

                    <div
                        class="info-value <?= empty($user['created_at']) ? 'muted' : '' ?>"
                    >
                        <?= ! empty($user['created_at'])
                            ? date(
                                'd M Y, H:i',
                                strtotime($user['created_at'])
                            )
                            : '-'
                        ?>
                    </div>

                </div>


                <div class="info-row">

                    <div class="info-label">
                        Terakhir Diperbarui
                    </div>

                    <div
                        class="info-value <?= empty($user['updated_at']) ? 'muted' : '' ?>"
                    >
                        <?= ! empty($user['updated_at'])
                            ? date(
                                'd M Y, H:i',
                                strtotime($user['updated_at'])
                            )
                            : '-'
                        ?>
                    </div>

                </div>

            </div>

        </section>

    </div>


    <div class="detail-footer">

        <a
            href="<?= site_url('admin/users') ?>"
            class="btn-back"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar User
        </a>

    </div>

</div>

<?= $this->endSection() ?>