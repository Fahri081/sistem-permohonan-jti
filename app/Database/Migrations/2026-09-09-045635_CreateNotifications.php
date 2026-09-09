<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotifications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifikasi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            /*
             * Harus dibuat sama dengan users.id_user.
             * Tabel users kamu menggunakan INT biasa,
             * jadi jangan gunakan UNSIGNED di sini.
             */
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],

            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'pesan' => [
                'type' => 'TEXT',
            ],

            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'dibaca' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
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

        $this->forge->addKey(
            'id_notifikasi',
            true
        );

        $this->forge->addKey(
            'id_user'
        );

        $this->forge->addForeignKey(
            'id_user',
            'users',
            'id_user',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable(
            'notifications'
        );
    }

    public function down()
    {
        $this->forge->dropTable(
            'notifications',
            true
        );
    }
}