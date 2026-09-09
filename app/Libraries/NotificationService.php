<?php

namespace App\Libraries;

use App\Models\NotificationModel;

class NotificationService
{
    protected NotificationModel $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Membuat notifikasi baru
     */
    public function create(
        int $userId,
        string $judul,
        string $pesan,
        ?string $link = null
    ): bool {
        $result = $this->notificationModel->insert([
            'id_user' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'link'    => $link,
            'dibaca'  => 0,
        ]);

        return $result !== false;
    }

    /**
     * Mengambil notifikasi milik user
     */
    public function getForUser(int $userId, int $limit = 10): array
    {
        return $this->notificationModel
            ->where('id_user', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    /**
     * Menghitung notifikasi yang belum dibaca
     */
    public function unreadCount(int $userId): int
    {
        return $this->notificationModel
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->countAllResults();
    }

    /**
     * Menandai satu notifikasi sebagai dibaca
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        $notification = $this->notificationModel
            ->where('id_notifikasi', $notificationId)
            ->where('id_user', $userId)
            ->first();

        if (!$notification) {
            return false;
        }

        return $this->notificationModel->update($notificationId, [
            'dibaca' => 1,
        ]);
    }

    /**
     * Menandai semua notifikasi user sebagai dibaca
     */
    public function markAllAsRead(int $userId): bool
    {
        return $this->notificationModel
            ->where('id_user', $userId)
            ->set([
                'dibaca' => 1,
            ])
            ->update();
    }
}