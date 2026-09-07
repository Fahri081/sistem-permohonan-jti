<?php
namespace App\Models;
use CodeIgniter\Model;
class BerkasPermohonanModel extends Model {
    protected $table = 'berkas_permohonan'; protected $primaryKey = 'id_berkas'; protected $allowedFields = ['id_permohonan','nama_berkas','bukti_foto','selesai','tanggal_selesai'];
    protected $useTimestamps = true; protected $returnType = 'array';
}
