<?php
namespace App\Models;
use CodeIgniter\Model;
class PermohonanModel extends Model {
    protected $table = 'permohonan'; protected $primaryKey = 'id_permohonan'; protected $allowedFields = ['id_user','id_tujuan','id_status','keperluan','deskripsi','keterangan_penolakan','tanggal_pengajuan','tanggal_selesai','tanggal_diambil'];
    protected $useTimestamps = true; protected $returnType = 'array';
}
