<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('12345678', PASSWORD_DEFAULT);

        $data = [
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password_hash' => $password,
            'active' => 1, // pastikan aktif
        ];

        // insert ke tabel users
        $this->db->table('users')->insert($data);
    }
}
