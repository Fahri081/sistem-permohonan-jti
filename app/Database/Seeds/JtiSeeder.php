<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class JtiSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Status table
        $this->db->table('status')->emptyTable();
        $this->db->table('status')->insertBatch([
            ['id_status' => 1, 'nama_status' => 'DIAJUKAN', 'created_at' => $now, 'updated_at' => $now],
            ['id_status' => 2, 'nama_status' => 'DITOLAK', 'created_at' => $now, 'updated_at' => $now],
            ['id_status' => 3, 'nama_status' => 'DIPROSES', 'created_at' => $now, 'updated_at' => $now],
            ['id_status' => 4, 'nama_status' => 'SELESAI', 'created_at' => $now, 'updated_at' => $now],
            ['id_status' => 5, 'nama_status' => 'DIAMBIL', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Tujuan table
        $this->db->table('tujuan')->emptyTable();
        $this->db->table('tujuan')->insertBatch([
            ['id_tujuan' => 1, 'nama_tujuan' => 'Ketua Program Studi', 'created_at' => $now, 'updated_at' => $now],
            ['id_tujuan' => 2, 'nama_tujuan' => 'Sekretaris Jurusan', 'created_at' => $now, 'updated_at' => $now],
            ['id_tujuan' => 3, 'nama_tujuan' => 'Ketua Jurusan Teknologi Informasi', 'created_at' => $now, 'updated_at' => $now],
            ['id_tujuan' => 4, 'nama_tujuan' => 'Kepala Laboratorium', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Users
        $this->db->table('users')->emptyTable();
        $this->db->table('users')->insertBatch([
            [
                'id_user'      => 1,
                'nama_lengkap' => 'Budi Santoso',
                'email'        => 'budi@jti.local',
                'no_hp'        => '081298765432',
                'password'     => password_hash('budi123', PASSWORD_DEFAULT),
                'role'         => 'mahasiswa',
                'nim'          => '2141720001',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'id_user'      => 2,
                'nama_lengkap' => 'Administrator JTI',
                'email'        => 'admin@jti.local',
                'no_hp'        => '081234567890',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'nim'          => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);

        // Permohonan
        $this->db->table('permohonan')->emptyTable();
        $this->db->table('permohonan')->insertBatch([
            [
                'id_permohonan'     => 1,
                'id_user'           => 1,
                'id_tujuan'         => 3, // Ketua Jurusan
                'id_status'         => 3, // DIPROSES
                'keperluan'         => 'Tanda Tangan Surat Pengantar Magang MBKM Genap 2023/2024',
                'deskripsi'         => 'Mohon bantuannya untuk menandatangani surat pengantar magang di PT Teknologi Nusantara. Berkas asli telah diserahkan ke admin jurusan.',
                'bukti_fisik'       => 'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' => '2023-10-12 09:45:00',
                'tanggal_selesai'   => null,
                'tanggal_diambil'   => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id_permohonan'     => 42,
                'id_user'           => 1,
                'id_tujuan'         => 1, // Ketua Program Studi
                'id_status'         => 3, // DIPROSES
                'keperluan'         => 'Persetujuan Judul Skripsi Semester Ganjil 2023/2024',
                'deskripsi'         => 'Pengajuan tanda tangan lembar persetujuan judul proposal skripsi bidang Kecerdasan Buatan.',
                'bukti_fisik'       => 'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' => '2023-10-24 09:30:00',
                'tanggal_selesai'   => null,
                'tanggal_diambil'   => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id_permohonan'     => 39,
                'id_user'           => 1,
                'id_tujuan'         => 2, // Sekretaris Jurusan
                'id_status'         => 4, // SELESAI
                'keperluan'         => 'Tanda Tangan Lembar Pengesahan PKL',
                'deskripsi'         => 'Pengesahan laporan akhir Praktik Kerja Lapangan di PT Solusi Digital.',
                'bukti_fisik'       => 'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' => '2023-10-18 10:15:00',
                'tanggal_selesai'   => '2023-10-19 15:00:00',
                'tanggal_diambil'   => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id_permohonan'     => 44,
                'id_user'           => 1,
                'id_tujuan'         => 1, // Ketua Program Studi
                'id_status'         => 1, // DIAJUKAN
                'keperluan'         => 'Form Bebas Tanggungan Lab Komputer',
                'deskripsi'         => 'Form verifikasi bebas peminjaman dan tanggungan alat laboratorium.',
                'bukti_fisik'       => 'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => null,
                'tanggal_pengajuan' => '2023-10-26 14:00:00',
                'tanggal_selesai'   => null,
                'tanggal_diambil'   => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id_permohonan'     => 31,
                'id_user'           => 1,
                'id_tujuan'         => 4, // Kepala Laboratorium
                'id_status'         => 2, // DITOLAK
                'keperluan'         => 'Peminjaman Alat Inventaris Sensor IoT',
                'deskripsi'         => 'Peminjaman sensor mikrokontroler untuk eksperimen skripsi.',
                'bukti_fisik'       => 'bukti_pengumpulan_magang.jpg',
                'keterangan_penolakan' => 'Surat pernyataan orang tua tidak menggunakan materai yang sah. Harap perbaiki dan unggah ulang.',
                'tanggal_pengajuan' => '2023-10-05 11:20:00',
                'tanggal_selesai'   => null,
                'tanggal_diambil'   => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);

        // Berkas Permohonan
        $this->db->table('berkas_permohonan')->emptyTable();
        $this->db->table('berkas_permohonan')->insertBatch([
            // REQ 1 (Foto 3)
            [
                'id_berkas'       => 1,
                'id_permohonan'   => 1,
                'nama_berkas'     => 'Surat Pengajuan Magang.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 1,
                'tanggal_selesai' => '2023-10-13 10:00:00',
                'created_at'      => '2023-10-12 09:45:00',
                'updated_at'      => $now,
            ],
            [
                'id_berkas'       => 2,
                'id_permohonan'   => 1,
                'nama_berkas'     => 'Transkrip Nilai Sementara.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 0,
                'tanggal_selesai' => null,
                'created_at'      => '2023-10-12 09:45:00',
                'updated_at'      => $now,
            ],
            // REQ 42
            [
                'id_berkas'       => 3,
                'id_permohonan'   => 42,
                'nama_berkas'     => 'Formulir Pengajuan Judul Skripsi.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 0,
                'tanggal_selesai' => null,
                'created_at'      => '2023-10-24 09:30:00',
                'updated_at'      => $now,
            ],
            [
                'id_berkas'       => 4,
                'id_permohonan'   => 42,
                'nama_berkas'     => 'Draft Proposal Bab 1-3.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 0,
                'tanggal_selesai' => null,
                'created_at'      => '2023-10-24 09:30:00',
                'updated_at'      => $now,
            ],
            // REQ 39
            [
                'id_berkas'       => 5,
                'id_permohonan'   => 39,
                'nama_berkas'     => 'Lembar Pengesahan PKL.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 1,
                'tanggal_selesai' => '2023-10-19 15:00:00',
                'created_at'      => '2023-10-18 10:15:00',
                'updated_at'      => $now,
            ],
            // REQ 44
            [
                'id_berkas'       => 6,
                'id_permohonan'   => 44,
                'nama_berkas'     => 'Formulir Bebas Lab Komputer.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 0,
                'tanggal_selesai' => null,
                'created_at'      => '2023-10-26 14:00:00',
                'updated_at'      => $now,
            ],
            // REQ 31
            [
                'id_berkas'       => 7,
                'id_permohonan'   => 31,
                'nama_berkas'     => 'Surat Izin Peminjaman Sensor IoT.pdf',
                'bukti_foto'      => 'bukti_pengumpulan_magang.jpg',
                'selesai'         => 0,
                'tanggal_selesai' => null,
                'created_at'      => '2023-10-05 11:20:00',
                'updated_at'      => $now,
            ],
        ]);
    }
}
