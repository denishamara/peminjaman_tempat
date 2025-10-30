<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // ------------------------
    // ⛔ TAMPILKAN FORM LOGIN
    // ------------------------
    public function login()
    {
        return view('auth/login');
    }

    // ----------------------------
    // ✅ PROSES LOGIN (POST)
    // ----------------------------
    public function loginPost()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username
        $user = (new UserModel())->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // ✅ Jika login berhasil, set session user
        session()->set('user', [
            'id_user'  => $user['id_user'],
            'username' => $user['username'],
            'role'     => $user['role'], // string seperti: 'admin', 'petugas', 'peminjam'
            'foto' => $user['foto'] ?? 'default.jpeg'
        ]);

        // Redirect ke dashboard
        return redirect()->to('/dashboard');
    }

    // ------------------------
    // 📝 TAMPILKAN FORM REGISTER
    // ------------------------
    public function register()
    {
        return view('auth/register');
    }

    // ------------------------
    // ✅ PROSES REGISTER (POST)
    // ------------------------
    public function registerPost()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|is_unique[user.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[peminjam]', // ⬅️ Tambahkan validasi role
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // ------------------------
    // 🚪 LOGOUT
    // ------------------------
    public function logout()
{
    session()->destroy();
    return redirect()->to(base_url('landing'));
}
}
