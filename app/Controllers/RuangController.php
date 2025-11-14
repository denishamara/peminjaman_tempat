<?php

namespace App\Controllers;

use App\Models\RuangModel;
use App\Models\JadwalModel;
use App\Models\BookingModel;

class RuangController extends BaseController
{
    protected $ruangModel;

    public function __construct()
    {
        $this->ruangModel = new RuangModel();
    }

    // 📋 Daftar ruang + status & keterangan
    public function index()
    {
        $ruangs = $this->ruangModel->getRuangWithStatus();
        
        $ruangModel   = new RuangModel();
        $jadwalModel  = new JadwalModel(); // jadwal reguler
        $bookingModel = new BookingModel(); // peminjaman / booking

        $ruangs = $ruangModel->findAll();
        $today  = date('Y-m-d H:i:s');

        foreach ($ruangs as &$r) {
            $id_room = $r['id_room'];

            // 🔹 Cek apakah ruangan ini sedang dibooking
            $bookingAktif = $bookingModel
                ->where('id_room', $id_room)
                ->where('status !=', 'Selesai')
                ->where('tanggal_selesai >=', $today)
                ->first();

            // 🔹 Cek apakah ruangan ini punya jadwal reguler aktif
            $jadwalAktif = $jadwalModel
                ->where('id_room', $id_room)
                ->where('tanggal_selesai >=', $today)
                ->first();

            if ($bookingAktif) {
                $r['status'] = 'Tidak Tersedia';
            } elseif ($jadwalAktif) {
                $r['status'] = 'Terpakai (Reguler)';
            } else {
                $r['status'] = 'Tersedia';
            }
        }

        return view('ruang/index', [
            'ruangs' => $ruangs
        ]);
    }

    // ➕ Tambah ruang
    public function create()
    {
        return view('ruang/create');
    }

    // 💾 Simpan ruang
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

    // ✏️ Edit ruang
    public function edit($id)
    {
        $ruang = $this->ruangModel->find($id);
        if (!$ruang) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data ruang tidak ditemukan");
        }

        return view('ruang/edit', ['ruang' => $ruang]);
    }

    // 🔄 Update ruang
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
