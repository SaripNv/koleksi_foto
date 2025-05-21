<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@bulog.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'profile_picture' => 'default.png',
                'status_aktif' => true,
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'user1',
                'email' => 'user1@bulog.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'profile_picture' => 'default.png',
                'status_aktif' => true,
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'inactive_user',
                'email' => 'inactive@bulog.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user',
                'profile_picture' => 'default.png',
                'status_aktif' => false,
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 months')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Menggunakan insertBatch dari model untuk memastikan validasi dan timestamps
        $userModel->insertBatch($data);

        // Alternatif jika ingin menggunakan query builder langsung:
        // $this->db->table('user')->insertBatch($data);
    }
}