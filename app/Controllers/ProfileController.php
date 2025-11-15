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

    // 🔥 Ambil total booking dari MySQL function
    $totalBooking = $this->userModel->getTotalBooking($user['id_user']);

    return view('profile/index', [
        'user' => $user,
        'totalBooking' => $totalBooking
    ]);
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

        $file = $this->request->getFile('foto');
        $fotoName = $user['foto'] ?? 'default.jpeg';

        // ✅ Kalau upload baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama kalau bukan default
            if ($fotoName !== 'default.jpeg' && file_exists(FCPATH . 'images/profile/' . $fotoName)) {
                unlink(FCPATH . 'images/profile/' . $fotoName);
            }

            // Upload foto baru
            $fotoName = $file->getRandomName();
            $file->move('images/profile', $fotoName);
        }

        // ✅ Simpan ke database
        $this->userModel->update($user['id_user'], [
            'username' => $this->request->getPost('username'),
            'foto'     => $fotoName,
        ]);

        // ✅ Update session
        $user['username'] = $this->request->getPost('username');
        $user['foto']     = $fotoName;
        session()->set('user', $user);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function deletePhoto()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        // Hapus file lama jika bukan default
        if (!empty($user['foto']) && $user['foto'] !== 'default.jpeg') {
            $path = FCPATH . 'images/profile/' . $user['foto'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Update database & session
        $this->userModel->update($user['id_user'], ['foto' => 'default.jpeg']);
        $user['foto'] = 'default.jpeg';
        session()->set('user', $user);

        return redirect()->to('/profile/edit')->with('success', 'Foto profil berhasil dihapus dan dikembalikan ke default.');
    }
}
