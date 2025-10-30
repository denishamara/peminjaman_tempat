<?php namespace App\Controllers;

class KontakController extends BaseController
{
    public function index()
    {
        // Data petugas bisa kamu ambil dari database nanti.
        // Untuk sekarang, kita buat contoh statis dulu.
        $data = [
            'title' => 'Kontak Petugas (Urgent)',
            'petugas' => [
                [
                    'nama'  => 'Budi Santoso',
                    'jabatan' => 'Petugas Ruangan',
                    'telepon' => '0812-3456-7890',
                    'email' => 'budi@kampus.ac.id',
                    'shift' => 'Senin - Jumat (08:00 - 17:00)',
                ],
                [
                    'nama'  => 'Siti Rahmawati',
                    'jabatan' => 'Admin Fasilitas',
                    'telepon' => '0813-9876-5432',
                    'email' => 'siti@kampus.ac.id',
                    'shift' => 'Sabtu - Minggu (08:00 - 15:00)',
                ],
            ],
        ];

        return view('kontak/index', $data);
    }
}
