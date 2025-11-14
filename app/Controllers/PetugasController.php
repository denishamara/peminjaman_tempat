<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\PetugasModel;
use App\Models\JadwalModel;

class PetugasController extends BaseController
{
    protected $peminjamanModel;
    protected $petugasModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->petugasModel    = new PetugasModel();
        $this->jadwalModel     = new JadwalModel();
    }

    /**
     * Menampilkan daftar semua peminjaman
     * dan otomatis memperbarui status yang sudah lewat menjadi 'Selesai'
     */
    public function peminjaman_daftar()
{
    $bookingModel = new \App\Models\BookingModel();
    $bookingModel->updateFinishedBookings();

    $data['peminjaman'] = $bookingModel
        ->select('booking.*, user.username, room.nama_room, petugas.nama_petugas')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('petugas', 'petugas.id_petugas = booking.id_petugas', 'left')
        ->whereNotIn('LOWER(booking.status)', ['selesai', 'ditolak'])
        ->orderBy('booking.tanggal_mulai', 'DESC')
        ->findAll();

    return view('petugas/peminjaman_daftar', $data);
}

    /**
     * Menampilkan detail peminjaman
     */
    public function detail($id)
    {
        $p = $this->peminjamanModel
            ->select('booking.*, user.username, room.nama_room, petugas.nama_petugas')
            ->join('user', 'user.id_user = booking.id_user')
            ->join('room', 'room.id_room = booking.id_room')
            ->join('petugas', 'petugas.id_petugas = booking.id_petugas', 'left')
            ->where('booking.id_booking', $id)
            ->first();

        if (!$p) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data peminjaman tidak ditemukan');
        }

        return view('petugas/peminjaman_detail', ['peminjaman' => $p]);
    }

    /**
     * Menyetujui peminjaman
     */
    public function setuju($id)
{
    $booking = $this->peminjamanModel->find($id);
    if (!$booking) {
        return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
    }

    // 🔹 Cek bentrok lagi sebelum approve
    $start = $booking['tanggal_mulai'];
    $end   = $booking['tanggal_selesai'];
    $room  = $booking['id_room'];

    $conflict = $this->jadwalModel
        ->where('id_room', $room)
        ->groupStart()
            ->where("tanggal_mulai < '$end' AND tanggal_selesai > '$start'")
        ->groupEnd()
        ->first();

    if ($conflict) {
        return redirect()->back()->with('error', 'Booking ini masih bentrok dengan jadwal lain. Silakan periksa jadwal yang bentrok sebelum menyetujui.');
    }

    $user = session()->get('user');
    if (!$user) {
        return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    // 🔹 Pastikan petugas ada
    $petugas = $this->petugasModel->where('id_user', $user['id_user'])->first();
    if (!$petugas) {
        $this->petugasModel->insert([
            'id_user' => $user['id_user'],
            'nama_petugas' => $user['username']
        ]);
        $petugas = $this->petugasModel->where('id_user', $user['id_user'])->first();
    }

    // 🔹 Update status & keterangan
    $newKeterangan = preg_replace('/\|?\s*Bentrok dengan jadwal reguler.*$/i', '', $booking['keterangan']);
    $newKeterangan = trim($newKeterangan, " |");

    $this->peminjamanModel->update($id, [
        'status'     => 'Diterima',
        'id_petugas' => $petugas['id_petugas'],
        'keterangan' => $newKeterangan ?: 'Peminjaman disetujui'
    ]);

    // 🔹 Tambahkan ke jadwal_reguler
    $this->jadwalModel->insert([
        'nama_reguler'    => 'Booking-' . $booking['id_booking'],
        'id_room'         => $booking['id_room'],
        'id_user'         => $booking['id_user'],
        'tanggal_mulai'   => $booking['tanggal_mulai'],
        'tanggal_selesai' => $booking['tanggal_selesai'],
        'keterangan'      => $newKeterangan ?: 'Peminjaman disetujui'
    ]);

    return redirect()->to('/petugas/peminjaman_daftar')
                     ->with('success', 'Peminjaman berhasil disetujui dan jadwal diperbarui.');
}
    /**
     * Menolak peminjaman
     */
    public function tolak($id)
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $petugas = $this->petugasModel->where('id_user', $user['id_user'])->first();
        if (!$petugas) {
            return redirect()->back()->with('error', 'Data petugas tidak ditemukan');
        }

        $this->peminjamanModel->update($id, [
            'status'     => 'Ditolak',
            'id_petugas' => $petugas['id_petugas']
        ]);

        return redirect()->to('/petugas/peminjaman_daftar')
                         ->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Menghapus data peminjaman
     */
    public function hapus($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);
        if (!$peminjaman) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data peminjaman tidak ditemukan');
        }

        $this->peminjamanModel->delete($id);

        return redirect()->to('/petugas/peminjaman_daftar')
                         ->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * 🔁 Fungsi tambahan:
     * Update otomatis status booking yang sudah lewat waktunya menjadi 'Selesai'
     */
    private function updateFinishedBookings()
    {
        $now = date('Y-m-d H:i:s');

        $this->peminjamanModel
            ->set('status', 'Selesai')
            ->where('status !=', 'Selesai')
            ->where('status !=', 'Ditolak')
            ->where('tanggal_selesai <', $now)
            ->update();
    }
}
