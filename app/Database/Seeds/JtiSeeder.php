<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JtiSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        /*
        |--------------------------------------------------------------------------
        | MAPPING STATUS
        |--------------------------------------------------------------------------
        |
        | 1 = DIAJUKAN
        | 2 = DIPROSES
        | 3 = DITOLAK
        | 4 = SELESAI
        | 5 = DIAMBIL
        |
        */

        $this->db->table('status')->emptyTable();

        $this->db->table('status')->insertBatch([
            [
                'id_status' => 1,
                'nama_status' => 'DIAJUKAN',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_status' => 2,
                'nama_status' => 'DIPROSES',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_status' => 3,
                'nama_status' => 'DITOLAK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_status' => 4,
                'nama_status' => 'SELESAI',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_status' => 5,
                'nama_status' => 'DIAMBIL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | TUJUAN
        |--------------------------------------------------------------------------
        */

        $this->db->table('tujuan')->emptyTable();

        $this->db->table('tujuan')->insertBatch([
            [
                'id_tujuan' => 1,
                'nama_tujuan' => 'Ketua Program Studi (KPS TI)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tujuan' => 2,
                'nama_tujuan' => 'Ketua Program Studi (KPS SIB)',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tujuan' => 3,
                'nama_tujuan' => 'Sekretaris Jurusan Teknologi Informasi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_tujuan' => 4,
                'nama_tujuan' => 'Ketua Jurusan Teknologi Informasi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        |
        | 1 = Admin
        | 2 = Mahasiswa
        |
        */

        $this->db->table('users')->emptyTable();

        $this->db->table('users')->insertBatch([
            [
                'id_user' => 1,
                'nama_lengkap' => 'Administrator JTI',
                'email' => 'admin@jti.local',
                'no_hp' => '081234567890',
                'password' => password_hash(
                    'admin123',
                    PASSWORD_DEFAULT
                ),
                'role' => 'admin',
                'nim' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_user' => 2,
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi@student.local',
                'no_hp' => '081298765432',
                'password' => password_hash(
                    'budi123',
                    PASSWORD_DEFAULT
                ),
                'role' => 'mahasiswa',
                'nim' => '2141720001',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | PERMOHONAN
        |--------------------------------------------------------------------------
        */

        $this->db->table('permohonan')->emptyTable();

        $this->db->table('permohonan')->insertBatch([
            [
                'id_permohonan' => 1,
                'id_user' => 2,
                'id_tujuan' => 4,
                'id_status' => 2,
                'keperluan' =>
                    'Tanda Tangan Surat Pengantar Magang MBKM',
                'deskripsi' =>
                    'Mohon bantuan untuk menandatangani surat pengantar magang.',
                'bukti_fisik' =>
                    'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' =>
                    '2026-09-08 09:00:00',
                'tanggal_selesai' => null,
                'tanggal_diambil' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_permohonan' => 2,
                'id_user' => 2,
                'id_tujuan' => 1,
                'id_status' => 1,
                'keperluan' =>
                    'Persetujuan Judul Skripsi',
                'deskripsi' =>
                    'Pengajuan persetujuan judul proposal skripsi.',
                'bukti_fisik' =>
                    'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' =>
                    '2026-09-09 10:00:00',
                'tanggal_selesai' => null,
                'tanggal_diambil' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_permohonan' => 3,
                'id_user' => 2,
                'id_tujuan' => 3,
                'id_status' => 4,
                'keperluan' =>
                    'Tanda Tangan Lembar Pengesahan PKL',
                'deskripsi' =>
                    'Pengesahan laporan akhir Praktik Kerja Lapangan.',
                'bukti_fisik' =>
                    'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' =>
                    '2026-09-07 10:00:00',
                'tanggal_selesai' =>
                    '2026-09-08 15:00:00',
                'tanggal_diambil' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_permohonan' => 4,
                'id_user' => 2,
                'id_tujuan' => 2,
                'id_status' => 3,
                'keperluan' =>
                    'Peminjaman Alat Laboratorium',
                'deskripsi' =>
                    'Peminjaman alat untuk kebutuhan praktikum.',
                'bukti_fisik' =>
                    'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' =>
                    'Dokumen pendukung belum lengkap. Silakan unggah kembali.',
                'tanggal_pengajuan' =>
                    '2026-09-06 11:00:00',
                'tanggal_selesai' => null,
                'tanggal_diambil' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | BERKAS PERMOHONAN
        |--------------------------------------------------------------------------
        */

        $this->db->table('berkas_permohonan')->emptyTable();

        $this->db->table('berkas_permohonan')->insertBatch([
            [
                'id_berkas' => 1,
                'id_permohonan' => 1,
                'nama_berkas' =>
                    'Surat Pengantar Magang.pdf',
                'bukti_foto' =>
                    'bukti_pengumpulan_magang.jpg',
                'selesai' => 0,
                'tanggal_selesai' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_berkas' => 2,
                'id_permohonan' => 1,
                'nama_berkas' =>
                    'Transkrip Nilai Sementara.pdf',
                'bukti_foto' =>
                    'bukti_pengumpulan_magang.jpg',
                'selesai' => 0,
                'tanggal_selesai' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_berkas' => 3,
                'id_permohonan' => 2,
                'nama_berkas' =>
                    'Formulir Pengajuan Judul Skripsi.pdf',
                'bukti_foto' =>
                    'bukti_pengumpulan_magang.jpg',
                'selesai' => 0,
                'tanggal_selesai' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_berkas' => 4,
                'id_permohonan' => 3,
                'nama_berkas' =>
                    'Lembar Pengesahan PKL.pdf',
                'bukti_foto' =>
                    'bukti_pengumpulan_magang.jpg',
                'selesai' => 1,
                'tanggal_selesai' =>
                    '2026-09-08 15:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            [
                'id_berkas' => 5,
                'id_permohonan' => 4,
                'nama_berkas' =>
                    'Surat Peminjaman Alat.pdf',
                'bukti_foto' =>
                    'bukti_pengumpulan_magang.jpg',
                'selesai' => 0,
                'tanggal_selesai' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}