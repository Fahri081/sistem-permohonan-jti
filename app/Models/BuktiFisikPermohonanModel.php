<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiFisikPermohonanModel extends Model
{
    protected $table            = 'bukti_fisik_permohonan';
    protected $primaryKey       = 'id_bukti';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_permohonan',
        'nama_file',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
