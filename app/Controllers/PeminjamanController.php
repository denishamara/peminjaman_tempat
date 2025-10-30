<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\RuangModel;
use App\Models\JadwalModel;
use App\Models\PeminjamanModel;


class PeminjamanController extends BaseController
{
    protected $bookingModel;
    protected $ruangModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->ruangModel   = new RuangModel();
        $this->jadwalModel  = new JadwalModel();
    }

    // 📝 Form pengajuan peminjaman
    public function ajukan()
    {
        // 🔹 Update otomatis data yang sudah lewat jadi "Selesai"
        $this->bookingModel->updateFinishedBookings();

        $rooms = $this->ruangModel->findAll();

        return view('peminjaman/ajukan', [
            'rooms' => $rooms
        ]);
    }

    // 🚀 Proses pengajuan
    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'id_room'         => 'required|numeric',
            'tanggal_mulai'   => 'required',
            'tanggal_selesai' => 'required',
            'keterangan'      => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idRoom         = $this->request->getPost('id_room');
        $tanggalMulai   = date('Y-m-d H:i:s', strtotime($this->request->getPost('tanggal_mulai')));
        $tanggalSelesai = date('Y-m-d H:i:s', strtotime($this->request->getPost('tanggal_selesai')));

        // 🛑 Cegah waktu sebelum sekarang
        if (strtotime($tanggalMulai) < time()) {
            return redirect()->back()->withInput()->with('errors', [
                'Tanggal mulai tidak boleh sebelum waktu sekarang.'
            ]);
        }

        // 🛑 Cegah tanggal selesai sebelum tanggal mulai
        if (strtotime($tanggalSelesai) <= strtotime($tanggalMulai)) {
            return redirect()->back()->withInput()->with('errors', [
                'Tanggal selesai harus lebih besar dari tanggal mulai.'
            ]);
        }

        // ✅ Pastikan user login
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/auth/login');
        }

        // 🚫 Cek bentrok dengan booking lain
        $conflict = $this->bookingModel
            ->where('id_room', $idRoom)
            ->where('status !=', 'Ditolak')
            ->where("NOT (tanggal_selesai <= '$tanggalMulai' OR tanggal_mulai >= '$tanggalSelesai')")
            ->first();

        if ($conflict) {
            return redirect()->back()->withInput()->with('errors', [
                'Waktu yang dipilih bentrok dengan peminjaman lain di ruangan tersebut.'
            ]);
        }

        // 🚫 Cek bentrok dengan jadwal reguler
        if ($this->jadwalModel->isTimeConflict([
            'id_room'         => $idRoom,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
        ])) {
            return redirect()->back()->withInput()->with('errors', [
                'Ruangan sudah digunakan pada waktu tersebut (jadwal reguler).'
            ]);
        }

        // 💾 Simpan ke database
        $data = [
            'id_user'         => $user['id_user'],
            'id_room'         => $idRoom,
            'tanggal_mulai'   => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'status'          => 'Proses',
            'keterangan'      => $this->request->getPost('keterangan'),
        ];

        try {
            $this->bookingModel->insert($data);
            return redirect()->to('/dashboard')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('errors', [
                'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    // 🧾 Daftar peminjaman aktif (otomatis sembunyikan yang sudah selesai)
    // 🧾 Daftar peminjaman aktif (otomatis sembunyikan yang sudah selesai)
public function daftar()
{
    // 🔹 Update otomatis data yang waktunya sudah lewat jadi 'Selesai'
    $this->bookingModel->updateFinishedBookings();

    // 🔹 Ambil hanya data yang BELUM selesai dan BELUM ditolak
    $peminjamanAktif = $this->bookingModel
        ->select('booking.*, user.username, room.nama_room, petugas.nama_petugas')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('petugas', 'petugas.id_petugas = booking.id_petugas', 'left')
        ->whereNotIn('LOWER(status)', ['selesai', 'ditolak'])
        ->orderBy('tanggal_mulai', 'ASC')
        ->findAll();

    return view('peminjaman/daftar', [
        'peminjaman' => $peminjamanAktif
    ]);
}

    // 📜 History (menampilkan yang sudah selesai)
    public function history()
{
    $this->bookingModel->updateFinishedBookings(); // Update otomatis yang sudah selesai

    $peminjamanModel = new \App\Models\PeminjamanModel();

    // Ambil semua data yang sudah selesai
    $riwayat = $peminjamanModel
        ->select('booking.*, user.username, room.nama_room')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->where('booking.status', 'Selesai')
        ->orderBy('booking.tanggal_selesai', 'DESC')
        ->findAll();

    return view('peminjaman/history', [
        'title' => 'Riwayat Peminjaman',
        'riwayat' => $riwayat
    ]);
}

}
