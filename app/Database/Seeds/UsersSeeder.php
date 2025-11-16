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
                'username' => 'admin',
                'telepon'  => null,
                'password' => password_hash('Admin123!', PASSWORD_DEFAULT),
                'role'     => 'administrator',
                'foto'     => 'default.jpeg',
            ],
            [
                'username' => 'petugas1',
                'telepon'  => null,
                'password' => password_hash('Petugas123!', PASSWORD_DEFAULT),
                'role'     => 'petugas',
                'foto'     => 'default.jpeg',
            ],
            [
                'username' => 'peminjam1',
                'telepon'  => null,
                'password' => password_hash('Peminjam123!', PASSWORD_DEFAULT),
                'role'     => 'peminjam',
                'foto'     => 'default.jpeg',
            ],
        ];

        // Insert ke tabel `user` sesuai struktur database
        $this->db->table('user')->insertBatch($data);
    }
}
