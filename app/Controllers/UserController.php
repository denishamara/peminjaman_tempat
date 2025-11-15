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
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan');
        }

        $rules = [
            'username' => "required|is_unique[user.username,id_user,{$id}]",
            'role'     => 'required|in_list[administrator,petugas,peminjam]'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/administrator/users')->with('success', 'User berhasil diperbarui');
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
