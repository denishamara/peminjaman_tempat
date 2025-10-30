<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookingModel;
use App\Models\JadwalModel;
use App\Models\RuangModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $bookingModel;
    protected $jadwalModel;
    protected $ruangModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->bookingModel = new BookingModel();
        $this->jadwalModel  = new JadwalModel();
        $this->ruangModel   = new RuangModel();
    }

    public function index()
    {
        // 🔒 Cek session user
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/auth/login');
        }

        // 🔁 Update otomatis semua status booking yang sudah lewat
        $this->bookingModel->updateFinishedBookings();

        $data = ['user' => $user];
        $role = $user['role'] ?? null;

        switch ($role) {
            case 'administrator':
                // === Statistik dasar ===
                $data['totalUsers']      = $this->userModel->countAllResults(false);
                $data['totalRuang']      = $this->ruangModel->countAllResults(false);
                $data['totalPeminjaman'] = $this->bookingModel->countAllResults(false);

                // === Peminjaman terbaru ===
                $data['recentPeminjaman'] = $this->bookingModel
                    ->select('booking.*, user.username, room.nama_room')
                    ->join('user', 'user.id_user = booking.id_user')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->orderBy('booking.tanggal_mulai', 'DESC')
                    ->findAll(5);
                break;

            case 'petugas':
                // === Hitung peminjaman berstatus "proses" ===
                $data['totalPeminjamanPending'] = $this->bookingModel
                    ->where('status', 'proses')
                    ->countAllResults(false);

                // === Ambil jadwal lengkap ===
                $data['jadwalRuang'] = $this->bookingModel
                    ->select('booking.*, user.username, room.nama_room')
                    ->join('user', 'user.id_user = booking.id_user')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->orderBy('booking.tanggal_mulai', 'ASC')
                    ->findAll();
                break;

            case 'peminjam':
                // === Ambil semua peminjaman milik user ini ===
                $data['myPeminjaman'] = $this->bookingModel
                    ->select('booking.*, room.nama_room')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->where('booking.id_user', $user['id_user'])
                    ->orderBy('booking.tanggal_mulai', 'DESC')
                    ->findAll();

                // === Jadwal umum (semua booking) ===
                $data['jadwalRuang'] = $this->bookingModel
                    ->select('booking.*, room.nama_room')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->orderBy('booking.tanggal_mulai', 'ASC')
                    ->findAll();
                break;

            default:
                session()->destroy();
                return redirect()
                    ->to('/auth/login')
                    ->with('error', 'Role tidak valid. Silakan login kembali.');
        }

        return view('dashboard/dashboard', $data);
    }
}
