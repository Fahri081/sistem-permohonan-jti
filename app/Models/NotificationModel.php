<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';

    protected $primaryKey = 'id_notifikasi';

    protected $allowedFields = [
        'id_user',
        'judul',
        'pesan',
        'link',
        'dibaca',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}