<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBuktiFisikToPermohonan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('permohonan', [
            'bukti_fisik' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn(
            'permohonan',
            'bukti_fisik'
        );
    }
}