<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<style>
    .users-page {
        width: 100%;
    }

    /* =====================================================
       HEADER
    ===================================================== */

    .users-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .users-header-copy {
        max-width: 720px;
    }

    .users-kicker {
        margin-bottom: 7px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .users-header h1 {
        margin: 0;
        color: #142e52;
        font-size: 29px;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .users-header p {
        margin: 7px 0 0;
        color: #667085;
        font-size: 13px;
        line-height: 1.6;
    }

    .btn-add-user {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 0 16px;
        border: 0;
        border-radius: 11px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(37, 99, 235, .18);
        transition: .18s ease;
        cursor: pointer;
    }

    .btn-add-user:hover {
        background: #1d4ed8;
        color: #fff;
        transform: translateY(-1px);
    }


    /* =====================================================
       SUMMARY
    ===================================================== */

    .user-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 22px;
    }

    .user-stat-card {
        position: relative;
        overflow: hidden;
        padding: 18px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 8px 24px rgba(20, 46, 82, .055);
    }

    .user-stat-card::after {
        content: "";
        position: absolute;
        width: 95px;
        height: 95px;
        right: -42px;
        top: -42px;
        border-radius: 50%;
        background: rgba(37, 99, 235, .055);
    }

    .user-stat-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 17px;
    }

    .user-stat-label {
        color: #667085;
        font-size: 12px;
        font-weight: 700;
    }

    .user-stat-icon {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 15px;
    }

    .user-stat-number {
        color: #142e52;
        font-size: 27px;
        font-weight: 800;
        line-height: 1;
    }

    .user-stat-caption {
        margin-top: 8px;
        color: #98a2b3;
        font-size: 11px;
    }


    /* =====================================================
       MAIN CARD
    ===================================================== */

    .users-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(20, 46, 82, .07);
    }

    .users-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 18px 20px;
        border-bottom: 1px solid #eef2f7;
        flex-wrap: wrap;
    }

    .users-card-heading h2 {
        margin: 0;
        color: #172033;
        font-size: 16px;
        font-weight: 800;
    }

    .users-card-heading p {
        margin: 5px 0 0;
        color: #98a2b3;
        font-size: 11px;
    }

    .users-tools {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
    }

    .users-search {
        position: relative;
    }

    .users-search i {
        position: absolute;
        top: 50%;
        left: 12px;
        color: #98a2b3;
        font-size: 12px;
        transform: translateY(-50%);
    }

    .users-search input {
        width: 245px;
        height: 39px;
        padding: 0 12px 0 34px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        outline: none;
        background: #fbfcfe;
        color: #344054;
        font-family: inherit;
        font-size: 12px;
    }

    .users-search input:focus {
        border-color: #b9c9f5;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
    }

    .users-filter {
        min-width: 140px;
        height: 39px;
        padding: 0 11px;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        outline: none;
        background: #fbfcfe;
        color: #344054;
        font-family: inherit;
        font-size: 12px;
        cursor: pointer;
    }


    /* =====================================================
       TABLE
    ===================================================== */

    .users-table-scroll {
        width: 100%;
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        min-width: 1040px;
        border-collapse: collapse;
    }

    .users-table th {
        padding: 12px 17px;
        border-bottom: 1px solid #e2e8f0;
        background: #fbfcfe;
        color: #667085;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .06em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .users-table td {
        padding: 14px 17px;
        border-bottom: 1px solid #eef2f7;
        color: #344054;
        font-size: 12px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .users-table tbody tr {
        transition: background .15s ease;
    }

    .users-table tbody tr:hover {
        background: #f9fbff;
    }

    .users-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .number-cell {
        width: 50px;
        color: #98a2b3 !important;
        font-weight: 700;
    }


    /* =====================================================
       USER
    ===================================================== */

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 185px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eaf1ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 800;
    }

    .user-info {
        min-width: 0;
    }

    .user-name {
        color: #172033;
        font-size: 12px;
        font-weight: 700;
    }

    .user-id {
        margin-top: 3px;
        color: #98a2b3;
        font-size: 10px;
    }


    /* =====================================================
       ROLE
    ===================================================== */

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
    }

    .role-mahasiswa {
        background: #f2f4f7;
        color: #667085;
    }

    .role-admin {
        background: #eaf1ff;
        color: #2563eb;
    }

    .role-super-admin {
        background: #efedff;
        color: #5b4bc4;
    }


    /* =====================================================
       ACTION
    ===================================================== */

    .user-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .user-action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        color: #667085;
        text-decoration: none;
        transition: .15s ease;
    }

    .user-action-btn:hover {
        border-color: #c8d6f2;
        background: #f6f9ff;
        color: #2563eb;
    }

    .user-action-btn.delete:hover {
        border-color: #fecaca;
        background: #fff7f7;
        color: #dc2626;
    }


    /* =====================================================
       EMPTY
    ===================================================== */

    .users-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .users-empty-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #f2f4f7;
        color: #98a2b3;
        font-size: 19px;
    }

    .users-empty h3 {
        margin: 0;
        color: #344054;
        font-size: 14px;
        font-weight: 800;
    }

    .users-empty p {
        margin: 6px 0 0;
        color: #98a2b3;
        font-size: 11px;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1100px) {
        .user-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 760px) {
        .users-header {
            flex-direction: column;
        }

        .btn-add-user {
            width: 100%;
        }

        .user-stats {
            grid-template-columns: 1fr;
        }

        .users-tools {
            width: 100%;
        }

        .users-search,
        .users-search input,
        .users-filter {
            width: 100%;
        }
    }
</style>


<div class="users-page">

    <!-- =================================================
         HEADER
    ================================================== -->

    <section class="users-header">

        <div class="users-header-copy">

            <div class="users-kicker">
                JTI Signature · Administrasi
            </div>

            <h1>Manage User</h1>

            <p>
                Kelola akun mahasiswa dan administrator yang terdaftar
                pada sistem JTI Signature.
            </p>

        </div>

    </section>


    <!-- =================================================
         SUMMARY
    ================================================== -->

    <section class="user-stats">

        <div class="user-stat-card">

            <div class="user-stat-head">
                <span class="user-stat-label">
                    Total User
                </span>

                <div class="user-stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="user-stat-number">
                <?= $totalUsers ?>
            </div>

            <div class="user-stat-caption">
                Seluruh akun sistem
            </div>

        </div>


        <div class="user-stat-card">

            <div class="user-stat-head">
                <span class="user-stat-label">
                    Mahasiswa
                </span>

                <div class="user-stat-icon">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
            </div>

            <div class="user-stat-number">
                <?= $totalMahasiswa ?>
            </div>

            <div class="user-stat-caption">
                Akun mahasiswa
            </div>

        </div>


        <div class="user-stat-card">

            <div class="user-stat-head">
                <span class="user-stat-label">
                    Admin Jurusan
                </span>

                <div class="user-stat-icon">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>

            <div class="user-stat-number">
                <?= $totalAdmin ?>
            </div>

            <div class="user-stat-caption">
                Administrator jurusan
            </div>

        </div>


        <div class="user-stat-card">

            <div class="user-stat-head">
                <span class="user-stat-label">
                    Super Admin
                </span>

                <div class="user-stat-icon">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
            </div>

            <div class="user-stat-number">
                <?= $totalSuperAdmin ?>
            </div>

            <div class="user-stat-caption">
                Administrator utama
            </div>

        </div>

    </section>


    <!-- =================================================
         USER TABLE
    ================================================== -->

    <section class="users-card">

        <div class="users-card-header">

            <div class="users-card-heading">

                <h2>
                    Daftar Pengguna
                </h2>

                <p>
                    Kelola akun berdasarkan nama, identitas, dan hak akses.
                </p>

            </div>


            <div class="users-tools">

                <div class="users-search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="text"
                        id="userSearch"
                        placeholder="Cari nama, NIM, email..."
                    >

                </div>


                <select
                    id="roleFilter"
                    class="users-filter"
                >
                    <option value="">
                        Semua Role
                    </option>

                    <option value="mahasiswa">
                        Mahasiswa
                    </option>

                    <option value="admin">
                        Admin Jurusan
                    </option>

                    <option value="super_admin">
                        Super Admin
                    </option>
                </select>

            </div>

        </div>


        <div class="users-table-scroll">

            <table class="users-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pengguna</th>
                        <th>NIM</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>


                <tbody>

                    <?php if (empty($users)): ?>

                        <tr>
                            <td colspan="8">

                                <div class="users-empty">

                                    <div class="users-empty-icon">
                                        <i class="fa-solid fa-users-slash"></i>
                                    </div>

                                    <h3>
                                        Belum ada pengguna
                                    </h3>

                                    <p>
                                        Data pengguna belum tersedia.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($users as $index => $user): ?>

                            <?php

                            $role = $user['role'] ?? '';

                            $roleLabel = 'Mahasiswa';
                            $roleClass = 'role-mahasiswa';
                            $roleIcon = 'fa-user-graduate';

                            if ($role === 'admin') {
                                $roleLabel = 'Admin Jurusan';
                                $roleClass = 'role-admin';
                                $roleIcon = 'fa-user-shield';
                            }

                            if ($role === 'super_admin') {
                                $roleLabel = 'Super Admin';
                                $roleClass = 'role-super-admin';
                                $roleIcon = 'fa-user-gear';
                            }

                            $nama = trim(
                                (string) ($user['nama_lengkap'] ?? '')
                            );

                            $initial = $nama !== ''
                                ? strtoupper(
                                    substr($nama, 0, 1)
                                )
                                : 'U';

                            ?>

                            <tr
                                class="user-row"
                                data-role="<?= esc($role) ?>"
                            >

                                <td class="number-cell">
                                    <?= $index + 1 ?>
                                </td>


                                <td>

                                    <div class="user-profile">

                                        <div class="user-avatar">
                                            <?= esc($initial) ?>
                                        </div>

                                        <div class="user-info">

                                            <div class="user-name">
                                                <?= esc(
                                                    $nama ?: '-'
                                                ) ?>
                                            </div>

                                            <div class="user-id">
                                                ID User #<?= esc(
                                                    $user['id_user']
                                                ) ?>
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td>
                                    <?= esc(
                                        $user['nim'] ?? '-'
                                    ) ?>
                                </td>


                                <td>
                                    <?= esc(
                                        $user['email'] ?? '-'
                                    ) ?>
                                </td>


                                <td>
                                    <?= esc(
                                        $user['no_hp'] ?? '-'
                                    ) ?>
                                </td>


                                <td>

                                    <span
                                        class="role-badge <?= esc($roleClass) ?>"
                                    >
                                        <i
                                            class="fa-solid <?= esc($roleIcon) ?>"
                                        ></i>

                                        <?= esc($roleLabel) ?>
                                    </span>

                                </td>


                                <td>

                                    <?php if (! empty($user['created_at'])): ?>

                                        <?= date(
                                            'd M Y',
                                            strtotime(
                                                $user['created_at']
                                            )
                                        ) ?>

                                    <?php else: ?>

                                        -

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="user-actions">

                                        <a
                                            href="<?= site_url('admin/users/' . $user['id_user']) ?>"
                                            class="user-action-btn"
                                            title="Detail"
                                        >
                                            <i class="fa-regular fa-eye"></i>
                                        </a>

<a
                                            href="<?= site_url('admin/users/' . $user['id_user'] . '/edit') ?>"
                                            class="user-action-btn"
                                            title="Edit"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form
                                            method="post"
                                            action="<?= site_url('admin/users/' . $user['id_user'] . '/delete') ?>"
                                            onsubmit="return confirmDelete(this);"
                                            style="display:inline;"
                                        >
                                            <?= csrf_field() ?>

                                            <button
                                                type="submit"
                                                class="user-action-btn delete"
                                                title="Hapus"
                                            >
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const searchInput =
                document.getElementById('userSearch');

            const roleFilter =
                document.getElementById('roleFilter');

            const rows =
                document.querySelectorAll('.user-row');


            function filterUsers() {

                const keyword =
                    searchInput.value
                        .toLowerCase()
                        .trim();

                const role =
                    roleFilter.value;


                rows.forEach(function (row) {

                    const text =
                        row.innerText.toLowerCase();

                    const rowRole =
                        row.dataset.role || '';


                    const matchKeyword =
                        keyword === ''
                        || text.includes(keyword);


                    const matchRole =
                        role === ''
                        || rowRole === role;


                    row.style.display =
                        matchKeyword && matchRole
                            ? ''
                            : 'none';

                });

            }


            searchInput.addEventListener(
                'input',
                filterUsers
            );

            roleFilter.addEventListener(
                'change',
                filterUsers
            );

        }
    );
</script>
<script>
    function confirmDelete(form) {

        Swal.fire({
            title: 'Hapus User?',
            text: 'Data akun yang sudah dihapus tidak dapat dikembalikan.',
            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',

            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',

            reverseButtons: true

        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

        return false;
    }
</script>

<?= $this->endSection() ?>  