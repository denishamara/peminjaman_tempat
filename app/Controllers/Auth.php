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

        $user = (new UserModel())->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        session()->set('user', [
            'id_user'  => $user['id_user'],
            'username' => $user['username'],
            'role'     => $user['role'],
            'foto'     => $user['foto'] ?? 'default.jpeg'
        ]);

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
        helper(['form']);
        $validation = \Config\Services::validation();

        $rules = [
            'username' => [
                'rules'  => 'required|min_length[4]|is_unique[user.username]',
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 4 karakter.',
                    'is_unique'  => 'Username sudah digunakan, silakan pilih yang lain.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'role' => [
                'rules'  => 'required|in_list[peminjam]',
                'errors' => [
                    'required' => 'Role wajib diisi.',
                    'in_list'  => 'Role tidak valid.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login.');
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
