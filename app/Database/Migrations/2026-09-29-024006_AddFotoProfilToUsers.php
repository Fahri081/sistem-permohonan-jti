<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoProfilToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'foto_profil' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'nim',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'foto_profil');
    }
}