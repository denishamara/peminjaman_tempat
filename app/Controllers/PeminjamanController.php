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
        'jam_mulai'       => 'required',
        'tanggal_selesai' => 'required',
        'jam_selesai'     => 'required',
        'keterangan'      => 'permit_empty|max_length[255]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Gabungkan tanggal dan jam
    $idRoom         = $this->request->getPost('id_room');
    $tanggalMulai   = $this->request->getPost('tanggal_mulai') . ' ' . $this->request->getPost('jam_mulai') . ':00';
    $tanggalSelesai = $this->request->getPost('tanggal_selesai') . ' ' . $this->request->getPost('jam_selesai') . ':00';

    // Konversi ke format datetime
    $tanggalMulaiFormatted = date('Y-m-d H:i:s', strtotime($tanggalMulai));
    $tanggalSelesaiFormatted = date('Y-m-d H:i:s', strtotime($tanggalSelesai));

    // 🛑 Cegah waktu sebelum sekarang
    if (strtotime($tanggalMulaiFormatted) < time()) {
        return redirect()->back()->withInput()->with('errors', [
            'tanggal_mulai' => 'Tanggal mulai tidak boleh sebelum waktu sekarang.'
        ]);
    }

    // 🛑 Cegah tanggal selesai sebelum tanggal mulai
    if (strtotime($tanggalSelesaiFormatted) <= strtotime($tanggalMulaiFormatted)) {
        return redirect()->back()->withInput()->with('errors', [
            'tanggal_selesai' => 'Tanggal selesai harus lebih besar dari tanggal mulai.'
        ]);
    }

    // ✅ Pastikan user login
    $user = session()->get('user');
    if (!$user) {
        return redirect()->to('/auth/login');
    }

    // 🚫 Cek bentrok dengan booking lain (masih aktif)
    $conflict = $this->bookingModel
        ->where('id_room', $idRoom)
        ->where('status !=', 'Ditolak')
        ->where("NOT (tanggal_selesai <= '$tanggalMulaiFormatted' OR tanggal_mulai >= '$tanggalSelesaiFormatted')")
        ->first();

    if ($conflict) {
        return redirect()->back()->withInput()->with('errors', [
            'id_room' => 'Waktu yang dipilih bentrok dengan peminjaman lain di ruangan tersebut.'
        ]);
    }

    // ⚠️ Cek bentrok dengan jadwal reguler — tapi tetap izinkan lanjut
    $keterangan = $this->request->getPost('keterangan');
    $bentrokJadwal = $this->jadwalModel->getTimeConflicts([
        'id_room'         => $idRoom,
        'tanggal_mulai'   => $tanggalMulaiFormatted,
        'tanggal_selesai' => $tanggalSelesaiFormatted,
    ]);

    if (!empty($bentrokJadwal)) {
        $infoBentrok = [];

        foreach ($bentrokJadwal as $jadwal) {
            // Ambil info jadwal yang bentrok
            $nama = $jadwal['nama_reguler'] ?? 'Jadwal Tidak Diketahui';
            $mulai = date('d M Y H:i', strtotime($jadwal['tanggal_mulai']));
            $selesai = date('d M Y H:i', strtotime($jadwal['tanggal_selesai']));
            $infoBentrok[] = "$nama ($mulai - $selesai)";
        }

        // Gabungkan semua jadwal bentrok
        $detailBentrok = implode(', ', $infoBentrok);

        // Tambahkan keterangan lengkap
        $keterangan = trim(($keterangan ? $keterangan . ' | ' : '') . "Bentrok dengan jadwal reguler: $detailBentrok");
    }

    // 💾 Simpan ke database
    $data = [
        'id_user'         => $user['id_user'],
        'id_room'         => $idRoom,
        'tanggal_mulai'   => $tanggalMulaiFormatted,
        'tanggal_selesai' => $tanggalSelesaiFormatted,
        'status'          => 'Proses',
        'keterangan'      => $keterangan,
    ];

    try {
        $this->bookingModel->insert($data);

        if (!empty($bentrokJadwal)) {
            return redirect()->to('/dashboard')->with(
                'success',
                'Pengajuan berhasil dikirim (⚠ Bentrok dengan jadwal reguler: ' . $detailBentrok . ').'
            );
        }

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

// 🗑️ Hapus riwayat peminjaman
public function delete($id)
{
    $bookingModel = new BookingModel();
    $booking = $bookingModel->find($id);
    
    if (!$booking) {
        return redirect()->to('/booking')->with('error', 'Data booking tidak ditemukan');
    }

    $id_room = $booking['id_room']; // Simpan id_room sebelum dihapus
    
    // Hapus booking dari tabel booking
    $bookingModel->delete($id);
    
    // ⭐ Hapus juga dari jadwal_reguler jika booking sudah diapprove
    // (Booking yang diapprove akan masuk ke jadwal_reguler dengan nama "Booking-{id}")
    $jadwalModel = new \App\Models\JadwalModel();
    $jadwalModel->where('nama_reguler', "Booking-{$id}")->delete();
    
    // ⭐ OPTIONAL: Update status ruang langsung (jika ingin real-time)
    // $ruangModel = new RuangModel();
    // $ruangModel->update($id_room, ['status' => 'Tersedia']);
    
    return redirect()->to('/booking')->with('success', 'Booking berhasil dihapus');
}

}