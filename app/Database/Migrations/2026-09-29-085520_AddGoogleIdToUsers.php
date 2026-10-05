<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGoogleIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn(
            'users',
            [
                'google_id' => [
                    'type'       => 'BIGINT',
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'email',
                ],
            ]
        );

        $this->db->query(
            'ALTER TABLE users
             ADD UNIQUE KEY uq_users_google_id (google_id)'
        );
    }

    public function down()
    {
        $this->db->query(
            'ALTER TABLE users
             DROP INDEX uq_users_google_id'
        );

        $this->forge->dropColumn(
            'users',
            'google_id'
        );
    }
}