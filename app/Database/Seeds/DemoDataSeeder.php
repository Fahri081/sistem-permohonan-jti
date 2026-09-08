<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        /*
         * ==========================================
         * 1. DATA MAHASISWA
         * ==========================================
         *
         * Password:
         * password123
         *
         * Jangan gunakan akun ini untuk production.
         */

        $this->db->table('users')->insert([
            'nama_lengkap' => 'Budi Santoso',
            'email'        => 'budi@student.local',
            'no_hp'        => '081234567891',
            'password'     => password_hash(
                'password123',
                PASSWORD_DEFAULT
            ),
            'role'         => 'mahasiswa',
            'nim'          => '2301001',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        $idUser = $this->db->insertID();


        /*
         * ==========================================
         * 2. DATA PERMOHONAN
         * ==========================================
         *
         * ID tujuan:
         * 1 = KPS TI
         *
         * ID status:
         * 2 = DIPROSES
         */

        $this->db->table('permohonan')->insert([
            'id_user'              => $idUser,
            'id_tujuan'            => 1,
            'id_status'            => 2,
            'keperluan'            => 'Pengajuan dokumen untuk keperluan akademik.',
            'deskripsi'            => 'Permohonan dokumen diperlukan untuk memenuhi administrasi akademik mahasiswa.',
            'keterangan_penolakan' => null,
            'tanggal_pengajuan'    => date('Y-m-d H:i:s'),
            'tanggal_selesai'      => null,
            'tanggal_diambil'      => null,
            'created_at'           => date('Y-m-d H:i:s'),
            'updated_at'           => date('Y-m-d H:i:s'),
        ]);

        $idPermohonan = $this->db->insertID();


        /*
         * ==========================================
         * 3. BERKAS PERTAMA
         * ==========================================
         *
         * Sudah selesai diproses.
         */

        $this->db->table('berkas_permohonan')->insert([
            'id_permohonan'  => $idPermohonan,
            'nama_berkas'    => 'Surat Permohonan',
            'bukti_foto'     => null,
            'selesai'        => 1,
            'tanggal_selesai'=> date('Y-m-d H:i:s'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);


        /*
         * ==========================================
         * 4. BERKAS KEDUA
         * ==========================================
         *
         * Masih diproses.
         */

        $this->db->table('berkas_permohonan')->insert([
            'id_permohonan'  => $idPermohonan,
            'nama_berkas'    => 'KHS',
            'bukti_foto'     => null,
            'selesai'        => 0,
            'tanggal_selesai'=> null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}