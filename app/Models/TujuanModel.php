<?php
namespace App\Models;
use CodeIgniter\Model;
class TujuanModel extends Model {
    protected $table = 'tujuan'; protected $primaryKey = 'id_tujuan'; protected $allowedFields = ['nama_tujuan'];
    protected $useTimestamps = true; protected $returnType = 'array';
}
