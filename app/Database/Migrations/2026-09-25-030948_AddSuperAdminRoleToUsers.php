<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSuperAdminRoleToUsers extends Migration
{
    public function up()
    {
        $this->db->query("
            ALTER TABLE users
            MODIFY COLUMN role
            ENUM('mahasiswa', 'admin', 'super_admin')
            NOT NULL
        ");
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE users
            MODIFY COLUMN role
            ENUM('mahasiswa', 'admin')
            NOT NULL
        ");
    }
}