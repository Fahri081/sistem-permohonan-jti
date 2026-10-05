<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStatusAkunAndAddToUsers extends Migration
{
    public function up()
    {
        /*
         * =====================================================
         * 1. BUAT TABEL STATUS AKUN
         * =====================================================
         */

        $this->forge->addField([
            'id_status_akun' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nama_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);

        $this->forge->addKey(
            'id_status_akun',
            true
        );

        $this->forge->createTable(
            'status_akun',
            true
        );


        /*
         * =====================================================
         * 2. ISI DATA STATUS AKUN
         * =====================================================
         */

        $this->db
            ->table('status_akun')
            ->insertBatch([
                [
                    'id_status_akun' => 1,
                    'nama_status'     => 'Aktif',
                ],
                [
                    'id_status_akun' => 2,
                    'nama_status'     => 'Tidak Aktif',
                ],
            ]);


        /*
         * =====================================================
         * 3. TAMBAHKAN STATUS AKUN KE USERS
         * =====================================================
         */

        $this->forge->addColumn(
            'users',
            [
                'id_status_akun' => [
                    'type'       => 'INT',
                    'constraint' => 10,
                    'unsigned'   => true,
                    'default'    => 1,
                    'after'      => 'role',
                ],
            ]
        );


        /*
         * =====================================================
         * 4. FOREIGN KEY
         * =====================================================
         */

        $this->db->query(
            'ALTER TABLE users
             ADD CONSTRAINT fk_users_status_akun
             FOREIGN KEY (id_status_akun)
             REFERENCES status_akun(id_status_akun)
             ON UPDATE CASCADE
             ON DELETE RESTRICT'
        );
    }


    public function down()
    {
        /*
         * Hapus foreign key dahulu
         */

        $this->db->query(
            'ALTER TABLE users
             DROP FOREIGN KEY fk_users_status_akun'
        );


        /*
         * Hapus kolom dari users
         */

        $this->forge->dropColumn(
            'users',
            'id_status_akun'
        );


        /*
         * Hapus tabel status akun
         */

        $this->forge->dropTable(
            'status_akun',
            true
        );
    }
}