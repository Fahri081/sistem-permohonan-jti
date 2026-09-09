<?php

namespace App\Controllers;

use App\Libraries\NotificationService;

class Notification extends BaseController
{
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = new NotificationService();
    }

    public function index()
    {
        $session = session();

        $userId = $session->get('id_user') ?? $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $notifications = $this->notificationService->getForUser((int) $userId, 50);
        $unreadCount = $this->notificationService->unreadCount((int) $userId);

        return view('notifications/index', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
        ]);
    }

    public function read(int $id)
    {
        $session = session();

        $userId = $session->get('id_user') ?? $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $notificationModel = new \App\Models\NotificationModel();

        $notification = $notificationModel
            ->where('id_notifikasi', $id)
            ->where('id_user', $userId)
            ->first();

        if (!$notification) {
            return redirect()->to('/notifications');
        }

        $this->notificationService->markAsRead(
            (int) $id,
            (int) $userId
        );

        if (!empty($notification['link'])) {
            return redirect()->to($notification['link']);
        }

        return redirect()->to('/notifications');
    }

    public function readAll()
    {
        $session = session();

        $userId = $session->get('id_user') ?? $session->get('user_id');

        if (!$userId) {
            return redirect()->to('/login');
        }

        $this->notificationService->markAllAsRead((int) $userId);

        return redirect()->to('/notifications');
    }
}