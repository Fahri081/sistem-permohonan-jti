<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBuktiFisikPermohonan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bukti' => [
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_bukti', true);
        $this->forge->addKey('id_permohonan');

        $this->forge->addForeignKey(
            'id_permohonan',
            'permohonan',
            'id_permohonan',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('bukti_fisik_permohonan', true);

        // Pindahkan data foto lama ke tabel baru.
        $this->db->query("
            INSERT INTO bukti_fisik_permohonan
                (id_permohonan, nama_file, created_at, updated_at)
            SELECT
                id_permohonan,
                bukti_fisik,
                NOW(),
                NOW()
            FROM permohonan
            WHERE bukti_fisik IS NOT NULL
              AND TRIM(bukti_fisik) <> ''
        ");
    }

    public function down()
    {
        $this->forge->dropTable('bukti_fisik_permohonan', true);
    }
}