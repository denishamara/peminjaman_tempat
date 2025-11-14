<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class KontakController extends Controller
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    // 🔹 Semua user bisa lihat daftar kontak
    public function index()
    {
        $data = [
            'title' => 'Kontak Petugas',
            'petugas' => $this->userModel
                ->whereIn('role', ['administrator', 'petugas'])
                ->findAll()
        ];

        return view('kontak/index', $data);
    }

    // 🔹 Halaman edit (khusus admin)
    public function edit($id_user)
    {
    $user = session()->get('user');
    if (!$user || $user['role'] !== 'administrator') {
        return redirect()->to(base_url('kontak'))->with('error', 'Akses ditolak!');
    }

    $model = new UserModel();
    $petugas = $model->find($id_user);

    if (!$petugas) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Petugas tidak ditemukan");
    }

    $data = [
        'title' => 'Edit Kontak Petugas',
        'petugas' => $petugas
    ];

    return view('kontak/edit', $data);
    }

public function update($id_user)
{
    $user = session()->get('user');
    if (!$user || $user['role'] !== 'administrator') {
        return redirect()->to(base_url('kontak'))->with('error', 'Akses ditolak!');
    }

    $telepon = $this->request->getPost('telepon');

    $model = new UserModel();
    $model->update($id_user, ['telepon' => $telepon]);

    return redirect()->to(base_url('administrator/kontak'))->with('success', 'Nomor telepon berhasil diperbarui.');
}
}
