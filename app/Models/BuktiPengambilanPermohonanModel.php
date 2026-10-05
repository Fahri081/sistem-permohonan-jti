<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiPengambilanPermohonanModel extends Model
{
    protected $table = 'bukti_pengambilan_permohonan';
    protected $primaryKey = 'id_bukti_pengambilan';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_permohonan',
        'nama_file',
        'status_verifikasi',
        'keterangan',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
