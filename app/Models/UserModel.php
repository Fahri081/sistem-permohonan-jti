<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';

protected $allowedFields = [
    'nama_lengkap',
    'email',
    'no_hp',
    'password',
    'role',
    'nim',
    'foto_profil',
    'id_status_akun',
    'google_id'
];
    protected $useTimestamps = true;

    protected $returnType = 'array';
}