<?php namespace App\Controllers;

use App\Models\RuangModel;

class RuangController extends BaseController
{
    protected $ruangModel;

    public function __construct()
    {
        $this->ruangModel = new RuangModel();
    }

    // ✅ Helper untuk ambil data user dari session

    // 📋 Tampilkan daftar ruang
    public function index()
    {
        $data = [
            'ruangs' => $this->ruangModel->findAll(),
        ];
        return view('ruang/index', $data);
    }

    // ➕ Form tambah ruang
    public function create()
    {
        $ruangModel = new \App\Models\RuangModel();
        $userModel  = new \App\Models\UserModel();

        $data = [
            'rooms' => $ruangModel->findAll(),
            'users' => $userModel->findAll(),
        ];

        return view('ruang/create', $data);
    }

    // 💾 Simpan data ruang baru
    public function store()
    {
        $data = [
            'nama_room' => $this->request->getPost('nama_room'),
            'lokasi'    => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kapasitas' => $this->request->getPost('kapasitas'),
        ];

        $this->ruangModel->insert($data);
        return redirect()->to('/ruang/index')->with('success', 'Data ruang berhasil ditambahkan');
    }

    // ✏️ Form edit ruang
    public function edit($id)
    {
        $ruang = $this->ruangModel->find($id);
        if (!$ruang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data ruang tidak ditemukan");
        }

        $data = [
            'ruang' => $ruang,
        ];

        return view('ruang/edit', $data);
    }

    // 🔄 Update data ruang
    public function update($id)
    {
        $data = [
            'nama_room' => $this->request->getPost('nama_room'),
            'lokasi'    => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'kapasitas' => $this->request->getPost('kapasitas'),
        ];

        $this->ruangModel->update($id, $data);
        return redirect()->to('/ruang/index')->with('success', 'Data ruang berhasil diupdate');
    }

    // 🗑️ Hapus ruang
    public function delete($id)
    {
        $this->ruangModel->delete($id);
        return redirect()->to('/ruang/index')->with('success', 'Data ruang berhasil dihapus');
    }
}
