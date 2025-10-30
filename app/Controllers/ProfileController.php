<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        return view('profile/index', ['user' => $user]);
    }

    public function edit()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        return view('profile/edit', ['user' => $user]);
    }

    public function update()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        // ✅ Ambil file foto baru (kalau ada)
        $file = $this->request->getFile('foto');
        $fotoName = $user['foto'] ?? 'default.jpeg'; // ✅ aman walau belum ada key "foto"

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fotoName = $file->getRandomName();
            $file->move('images/profile', $fotoName); // ✅ simpan di folder yang sama dengan view
        }

        // ✅ Update ke database
        $this->userModel->update($user['id_user'], [
            'username' => $this->request->getPost('username'),
            'foto'     => $fotoName,
        ]);

        // ✅ Perbarui session user biar langsung kelihatan
        $user['username'] = $this->request->getPost('username');
        $user['foto'] = $fotoName;
        session()->set('user', $user);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
