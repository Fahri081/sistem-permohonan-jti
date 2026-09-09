<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Notifikasi</h2>
            <p class="text-muted mb-0">
                Informasi terbaru mengenai permohonan.
            </p>
        </div>

        <?php if (($unreadCount ?? 0) > 0): ?>
            <a href="<?= base_url('notifications/read-all') ?>"
               class="btn btn-outline-primary">
                Tandai semua sudah dibaca
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($notifications)): ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fa-regular fa-bell fa-3x text-muted mb-3"></i>

                <h5>Belum ada notifikasi</h5>

                <p class="text-muted mb-0">
                    Notifikasi baru akan muncul di sini.
                </p>
            </div>
        </div>

    <?php else: ?>

        <div class="d-flex flex-column gap-3">

            <?php foreach ($notifications as $notification): ?>

                <a
                    href="<?= base_url('notifications/read/' . $notification['id_notifikasi']) ?>"
                    class="text-decoration-none text-dark"
                >

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">

                            <div class="d-flex gap-3">

                                <div class="text-primary fs-4">
                                    <i class="fa-regular fa-bell"></i>
                                </div>

                                <div>
                                    <h6 class="mb-1">
                                        <?= esc($notification['judul']) ?>

                                        <?php if ($notification['dibaca'] == 0): ?>
                                            <span class="badge bg-primary ms-2">
                                                Baru
                                            </span>
                                        <?php endif; ?>
                                    </h6>

                                    <p class="text-muted mb-2">
                                        <?= esc($notification['pesan']) ?>
                                    </p>

                                    <small class="text-secondary">
                                        <?= esc($notification['created_at']) ?>
                                    </small>
                                </div>

                            </div>

                        </div>
                    </div>

                </a>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>