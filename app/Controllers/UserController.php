<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ===============================
    // 📋 Halaman daftar user
    // ===============================
    public function index()
    {
        $users = $this->userModel->findAll();
        $currentUser = session()->get('user');

        return view('administrator/users/index', [
            'users' => $users,
            'user'  => $currentUser
        ]);
    }

    // ===============================
    // ➕ Form tambah user
    // ===============================
    public function createForm()
    {
        $currentUser = session()->get('user');
        return view('administrator/users/create', ['user' => $currentUser]);
    }

    // ===============================
    // 💾 Proses tambah user
    // ===============================
    public function create()
    {
        $rules = [
            'username' => 'required|is_unique[user.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[administrator,petugas,peminjam]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ];

        $this->userModel->insert($data);

        return redirect()->to('/administrator/users')->with('success', 'User berhasil ditambahkan');
    }

    // ===============================
    // ✏️ Form edit user
    // ===============================
    public function edit($id)
    {
        $userToEdit = $this->userModel->find($id);
        if (!$userToEdit) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan');
        }

        $currentUser = session()->get('user');

        return view('administrator/users/edit', [
            'user' => $currentUser,
            'userToEdit' => $userToEdit
        ]);
    }

    // ===============================
    // 🔄 Proses update user
    // ===============================
    public function update($id)
    {
        $userToEdit = $this->userModel->find($id);
        if (!$userToEdit) {
            return redirect()->to('/administrator/users')->with('error', 'User tidak ditemukan');
        }

        // Validasi username - hanya cek unique jika username berubah
        $rules = [
            'role' => 'required|in_list[administrator,petugas,peminjam]'
        ];

        $newUsername = $this->request->getPost('username');
        
        // Jika username berubah, cek apakah sudah dipakai user lain
        if ($newUsername !== $userToEdit['username']) {
            $rules['username'] = 'required|is_unique[user.username]';
        } else {
            $rules['username'] = 'required';
        }

        // Jika password diisi, validasi panjangnya
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // Siapkan data untuk update
        $data = [
            'username' => $newUsername,
            'role'     => $this->request->getPost('role')
        ];

        // Jika password diisi, hash dan masukkan ke data
        if (!empty($newPassword)) {
            $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Update data
        $result = $this->userModel->update($id, $data);

        if ($result) {
            return redirect()->to('/administrator/users')->with('success', 'User berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user. Silakan coba lagi.');
        }
    }

    // ===============================
    // ❌ Hapus user
    // ===============================
    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/administrator/users')->with('success', 'User berhasil dihapus');
    }
}
