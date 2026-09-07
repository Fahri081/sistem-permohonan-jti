<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class JtiSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('status')->insertBatch(array_map(fn($s)=>['nama_status'=>$s,'created_at'=>$now,'updated_at'=>$now], ['DIAJUKAN','DITOLAK','DIPROSES','SELESAI','DIAMBIL']));
        $this->db->table('tujuan')->insertBatch(array_map(fn($s)=>['nama_tujuan'=>$s,'created_at'=>$now,'updated_at'=>$now], ['KPS TI','KPS SIB','Sekjur','Kajur']));
        $this->db->table('users')->insert([
            'nama_lengkap'=>'Administrator JTI','email'=>'admin@jti.local','no_hp'=>'081234567890','password'=>password_hash('admin123', PASSWORD_DEFAULT),'role'=>'admin','nim'=>null,'created_at'=>$now,'updated_at'=>$now
        ]);
    }
}
