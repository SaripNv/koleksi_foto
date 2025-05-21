<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserStatus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'status_aktif' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'after' => 'profile_picture'
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status_aktif'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user', 'status_aktif');
        $this->forge->dropColumn('user', 'last_login');
    }
}