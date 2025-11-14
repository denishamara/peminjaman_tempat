<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PetugasModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $petugasModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->petugasModel = new PetugasModel();
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
            'user'  => $currentUser // untuk sidebar
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
            'role'     => 'required|in_list[administrator,petugas,peminjam]',
            'nama_petugas' => 'permit_empty|string|max_length[100]'
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
        $idUser = $this->userModel->getInsertID();

        if ($data['role'] === 'petugas') {
            $this->petugasModel->insert([
                'id_user' => $idUser,
                'nama_petugas' => $this->request->getPost('nama_petugas') ?? $data['username']
            ]);
        }

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

        $namaPetugas = null;
        if ($userToEdit['role'] === 'petugas') {
            $petugas = $this->petugasModel->where('id_user', $id)->first();
            $namaPetugas = $petugas['nama_petugas'] ?? null;
        }

        $currentUser = session()->get('user'); // user login

        return view('administrator/users/edit', [
            'user' => $currentUser,        // untuk sidebar
            'userToEdit' => $userToEdit,   // untuk form edit
            'nama_petugas' => $namaPetugas
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
            'role'     => 'required|in_list[administrator,petugas,peminjam]',
            'nama_petugas' => 'permit_empty|string|max_length[100]'
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

        // Update tabel petugas
        if ($data['role'] === 'petugas') {
            $existing = $this->petugasModel->where('id_user', $id)->first();
            if ($existing) {
                $this->petugasModel->update($existing['id_petugas'], [
                    'nama_petugas' => $this->request->getPost('nama_petugas') ?? $data['username']
                ]);
            } else {
                $this->petugasModel->insert([
                    'id_user' => $id,
                    'nama_petugas' => $this->request->getPost('nama_petugas') ?? $data['username']
                ]);
            }
        } else {
            // Hapus dari petugas jika bukan role petugas
            $this->petugasModel->where('id_user', $id)->delete();
        }

        return redirect()->to('/administrator/users')->with('success', 'User berhasil diperbarui');
    }

    // ===============================
    // ❌ Hapus user
    // ===============================
    public function delete($id)
    {
        $this->petugasModel->where('id_user', $id)->delete();
        $this->userModel->delete($id);

        return redirect()->to('/administrator/users')->with('success', 'User berhasil dihapus');
    }
}
