<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateJtiTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'nama_lengkap' => ['type'=>'VARCHAR','constraint'=>100], 'email'=>['type'=>'VARCHAR','constraint'=>100], 'no_hp'=>['type'=>'VARCHAR','constraint'=>15],
            'password'=>['type'=>'VARCHAR','constraint'=>255], 'role'=>['type'=>'ENUM','constraint'=>['mahasiswa','admin']], 'nim'=>['type'=>'VARCHAR','constraint'=>20,'null'=>true],
            'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]
        ]); $this->forge->addKey('id_user', true); $this->forge->addUniqueKey('email'); $this->forge->createTable('users', true);

        $this->forge->addField(['id_tujuan'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],'nama_tujuan'=>['type'=>'VARCHAR','constraint'=>100],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id_tujuan', true); $this->forge->createTable('tujuan', true);

        $this->forge->addField(['id_status'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],'nama_status'=>['type'=>'VARCHAR','constraint'=>50],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id_status', true); $this->forge->createTable('status', true);

        $this->forge->addField(['id_permohonan'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],'id_user'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],'id_tujuan'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],'id_status'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],'keperluan'=>['type'=>'VARCHAR','constraint'=>100],'deskripsi'=>['type'=>'TEXT'],'keterangan_penolakan'=>['type'=>'TEXT','null'=>true],'tanggal_pengajuan'=>['type'=>'DATETIME','null'=>true],'tanggal_selesai'=>['type'=>'DATETIME','null'=>true],'tanggal_diambil'=>['type'=>'DATETIME','null'=>true],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id_permohonan', true); $this->forge->addForeignKey('id_user','users','id_user','CASCADE','CASCADE'); $this->forge->addForeignKey('id_tujuan','tujuan','id_tujuan','RESTRICT','CASCADE'); $this->forge->addForeignKey('id_status','status','id_status','RESTRICT','CASCADE'); $this->forge->createTable('permohonan', true);

        $this->forge->addField(['id_berkas'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],'id_permohonan'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],'nama_berkas'=>['type'=>'VARCHAR','constraint'=>100],'bukti_foto'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'selesai'=>['type'=>'BOOLEAN','default'=>false],'tanggal_selesai'=>['type'=>'DATETIME','null'=>true],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id_berkas', true); $this->forge->addForeignKey('id_permohonan','permohonan','id_permohonan','CASCADE','CASCADE'); $this->forge->createTable('berkas_permohonan', true);
    }
    public function down(){ foreach(['berkas_permohonan','permohonan','status','tujuan','users'] as $t) $this->forge->dropTable($t, true); }
}
