<?php
    $role = session('role');

    $layout = in_array(
        $role,
        ['admin', 'super_admin'],
        true
    )
        ? 'admin/layout'
        : 'mahasiswa/layout';
?>

<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<style>
    /* =========================================================
       HALAMAN NOTIFIKASI
    ========================================================= */

    .notifications-page {
        width: 100%;
        max-width: 920px;
        margin: 0 auto;
    }

    .notifications-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
    }

    .notifications-header-left h1 {
        margin: 0 0 5px;
        color: #1e293b;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.3px;
    }

    .notifications-header-left p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .notifications-mark-all {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 9px 14px;

        border: 1px solid #dbe5f0;
        border-radius: 9px;

        background: #ffffff;
        color: #1d4e8c;

        font-size: 12px;
        font-weight: 700;

        text-decoration: none;
        white-space: nowrap;

        transition:
            background-color .15s ease,
            border-color .15s ease;
    }

    .notifications-mark-all:hover {
        background: #f0f7ff;
        border-color: #bfd3ec;
    }


    /* =========================================================
       LIST
    ========================================================= */

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .notification-card {
        position: relative;

        display: flex;
        align-items: flex-start;
        gap: 14px;

        padding: 18px 20px;

        border: 1px solid #e2e8f0;
        border-radius: 14px;

        background: #ffffff;

        text-decoration: none;

        box-shadow: 0 1px 3px rgba(15, 23, 42, .03);

        transition:
            border-color .15s ease,
            background-color .15s ease,
            transform .15s ease,
            box-shadow .15s ease;
    }

    .notification-card:hover {
        border-color: #cbd9ea;
        background: #fbfdff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, .06);
    }

    .notification-card.unread {
        border-color: #cfe0f5;
        background: #f8fbff;
    }


    /* ICON */

    .notification-card-icon {
        width: 42px;
        height: 42px;

        flex: 0 0 42px;

        border-radius: 12px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #eef4ff;
        color: #1d4e8c;

        margin-top: 1px;
    }

    .notification-card-icon svg {
        width: 19px;
        height: 19px;
    }


    /* BODY */

    .notification-card-body {
        min-width: 0;
        flex: 1;
    }

    .notification-card-title {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;

        margin-bottom: 5px;

        color: #1e293b;
        font-size: 13.5px;
        font-weight: 800;
        line-height: 1.4;
    }

    .notification-card-message {
        margin: 0 0 7px;

        color: #64748b;
        font-size: 12.5px;
        line-height: 1.55;
    }

    .notification-card-time {
        display: block;

        color: #94a3b8;
        font-size: 11px;
        line-height: 1.4;
    }


    /* BADGE */

    .notification-new-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 3px 8px;

        border-radius: 999px;

        background: #e0f2fe;
        color: #0284c7;

        font-size: 9.5px;
        font-weight: 800;
    }


    /* DOT */

    .notification-unread-dot {
        width: 8px;
        height: 8px;

        flex: 0 0 8px;

        margin-top: 8px;

        border-radius: 50%;

        background: #2563eb;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .notifications-empty {
        padding: 56px 24px;

        text-align: center;

        border: 1px solid #e2e8f0;
        border-radius: 14px;

        background: #ffffff;
    }

    .notifications-empty-icon {
        width: 58px;
        height: 58px;

        margin: 0 auto 14px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 16px;

        background: #eef4ff;
        color: #1d4e8c;
    }

    .notifications-empty-icon svg {
        width: 25px;
        height: 25px;
    }

    .notifications-empty h3 {
        margin: 0 0 5px;

        color: #1e293b;
        font-size: 15px;
        font-weight: 800;
    }

    .notifications-empty p {
        margin: 0;

        color: #94a3b8;
        font-size: 12px;
        line-height: 1.5;
    }


    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 640px) {

        .notifications-page {
            max-width: none;
        }

        .notifications-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 14px;
        }

        .notifications-header-left h1 {
            font-size: 21px;
        }

        .notifications-header-left p {
            font-size: 12px;
        }

        .notifications-mark-all {
            width: 100%;
        }

        .notification-card {
            padding: 15px;
            gap: 11px;
            border-radius: 12px;
        }

        .notification-card-icon {
            width: 38px;
            height: 38px;
            flex-basis: 38px;
            border-radius: 10px;
        }

        .notification-card-icon svg {
            width: 17px;
            height: 17px;
        }

        .notification-card-title {
            font-size: 12.5px;
        }

        .notification-card-message {
            font-size: 11.5px;
        }

        .notification-card-time {
            font-size: 10.5px;
        }

        .notification-unread-dot {
            width: 7px;
            height: 7px;
            flex-basis: 7px;
        }

        .notifications-empty {
            padding: 45px 18px;
        }
    }
</style>


<div class="notifications-page">

    <!-- HEADER -->
    <div class="notifications-header">

        <div class="notifications-header-left">

            <h1>
                Notifikasi
            </h1>

            <p>
                Informasi terbaru mengenai permohonan Anda.
            </p>

        </div>


        <?php if (($unreadCount ?? 0) > 0): ?>

            <a
                href="<?= site_url('notifications/read-all') ?>"
                class="notifications-mark-all"
            >
                Tandai semua sudah dibaca
            </a>

        <?php endif; ?>

    </div>


    <!-- LIST -->
    <?php if (empty($notifications)): ?>

        <div class="notifications-empty">

            <div class="notifications-empty-icon">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>

            </div>

            <h3>
                Belum ada notifikasi
            </h3>

            <p>
                Notifikasi baru akan muncul di sini.
            </p>

        </div>

    <?php else: ?>

        <div class="notifications-list">

            <?php foreach ($notifications as $notification): ?>

                <?php
                    $isUnread = (int) ($notification['dibaca'] ?? 0) === 0;

                    $judul = strtolower(
                        (string) ($notification['judul'] ?? '')
                    );

                    $iconColor = '#1d4e8c';
                    $iconBg = '#eef4ff';

                    if (str_contains($judul, 'ditolak')) {
                        $iconColor = '#dc2626';
                        $iconBg = '#fff1f2';
                    } elseif (str_contains($judul, 'selesai')) {
                        $iconColor = '#059669';
                        $iconBg = '#ecfdf5';
                    } elseif (str_contains($judul, 'diproses')) {
                        $iconColor = '#d97706';
                        $iconBg = '#fffbeb';
                    }
                ?>


                <a
                    href="<?= site_url('notifications/read/' . $notification['id_notifikasi']) ?>"
                    class="notification-card <?= $isUnread ? 'unread' : '' ?>"
                >

                    <div
                        class="notification-card-icon"
                        style="
                            color: <?= esc($iconColor) ?>;
                            background: <?= esc($iconBg) ?>;
                        "
                    >

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>

                    </div>


                    <div class="notification-card-body">

                        <div class="notification-card-title">

                            <?= esc(
                                $notification['judul'] ?? 'Notifikasi'
                            ) ?>


                            <?php if ($isUnread): ?>

                                <span class="notification-new-badge">
                                    Baru
                                </span>

                            <?php endif; ?>

                        </div>


                        <p class="notification-card-message">

                            <?= esc(
                                $notification['pesan'] ?? ''
                            ) ?>

                        </p>


                        <span class="notification-card-time">

                            <?= esc(
                                $notification['created_at'] ?? ''
                            ) ?>

                        </span>

                    </div>


                    <?php if ($isUnread): ?>

                        <span
                            class="notification-unread-dot"
                            aria-label="Belum dibaca"
                        ></span>

                    <?php endif; ?>

                </a>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>


<?= $this->endSection() ?>