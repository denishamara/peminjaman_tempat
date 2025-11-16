<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@example.com',
                'password'   => password_hash('Admin123!', PASSWORD_DEFAULT),
                'role'       => 'administrator',
                'foto'       => 'default.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username'   => 'petugas1',
                'email'      => 'petugas1@example.com',
                'password'   => password_hash('Petugas123!', PASSWORD_DEFAULT),
                'role'       => 'petugas',
                'foto'       => 'default.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username'   => 'peminjam1',
                'email'      => 'peminjam1@example.com',
                'password'   => password_hash('Peminjam123!', PASSWORD_DEFAULT),
                'role'       => 'peminjam',
                'foto'       => 'default.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Sesuaikan nama tabel jika berbeda
        $this->db->table('users')->insertBatch($data);
    }
}
