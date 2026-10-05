<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBuktiPengambilanPermohonan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bukti_pengambilan' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => false,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'status_verifikasi' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'diterima', 'ditolak'],
                'default'    => 'menunggu',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary key
        $this->forge->addKey('id_bukti_pengambilan', true);

        // Index
        $this->forge->addKey('id_permohonan');

        // Foreign key
        $this->forge->addForeignKey(
            'id_permohonan',
            'permohonan',
            'id_permohonan',
            'CASCADE',
            'CASCADE'
        );

        // Buat tabel
        $this->forge->createTable(
            'bukti_pengambilan_permohonan',
            true
        );

        // Tambahkan status pending jika belum ada
        if ($this->db->tableExists('status')) {
            $exists = $this->db
                ->table('status')
                ->where(
                    'nama_status',
                    'MENUNGGU VERIFIKASI PENGAMBILAN'
                )
                ->get()
                ->getRowArray();

            if (! $exists) {
                $now = date('Y-m-d H:i:s');

                $this->db->table('status')->insert([
                    'nama_status' => 'MENUNGGU VERIFIKASI PENGAMBILAN',
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }
        }
    }

    public function down()
    {
        // Hapus status pending
        if ($this->db->tableExists('status')) {
            $pending = $this->db
                ->table('status')
                ->where(
                    'nama_status',
                    'MENUNGGU VERIFIKASI PENGAMBILAN'
                )
                ->get()
                ->getRowArray();

            if ($pending) {
                $this->db->table('status')
                    ->where(
                        'id_status',
                        $pending['id_status']
                    )
                    ->delete();
            }
        }

        // Hapus tabel bukti pengambilan
        $this->forge->dropTable(
            'bukti_pengambilan_permohonan',
            true
        );
    }
}