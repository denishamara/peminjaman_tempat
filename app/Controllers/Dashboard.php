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
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/auth/login');
        }

        $this->bookingModel->updateFinishedBookings();

        $data = ['user' => $user];
        $role = $user['role'] ?? null;

        switch ($role) {
            case 'administrator':
                // Statistik dasar
                $data['totalUsers']      = $this->userModel->countAllResults(false);
                $data['totalRuang']      = $this->ruangModel->countAllResults(false);
                $data['totalPeminjaman'] = $this->bookingModel->countAllResults(false);

                // Peminjaman terbaru
                $data['recentPeminjaman'] = $this->bookingModel
                    ->select('booking.*, user.username, room.nama_room')
                    ->join('user', 'user.id_user = booking.id_user')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->orderBy('booking.tanggal_mulai', 'DESC')
                    ->findAll(5);

                // 📊 Statistik per bulan (6 bulan terakhir)
                $bulanData = [];
                $jumlahData = [];
                $result = $this->bookingModel
                    ->select("DATE_FORMAT(tanggal_mulai, '%b %Y') AS bulan, COUNT(*) AS jumlah, MIN(tanggal_mulai) AS min_tanggal")
                    ->where('tanggal_mulai >=', date('Y-m-01', strtotime('-5 months')))
                    ->groupBy("DATE_FORMAT(tanggal_mulai, '%Y-%m')")
                    ->orderBy("min_tanggal", 'ASC')
                    ->findAll();
                foreach ($result as $r) {
                    $bulanData[] = $r['bulan'];
                    $jumlahData[] = $r['jumlah'];
                }

                // 📊 Statistik status peminjaman
                $statusLabels = [];
                $statusCounts = [];
                $statusData = $this->bookingModel
                    ->select("status, COUNT(*) AS total")
                    ->groupBy('status')
                    ->findAll();
                foreach ($statusData as $s) {
                    $statusLabels[] = ucfirst($s['status']);
                    $statusCounts[] = $s['total'];
                }

                $data['bulanData']     = json_encode($bulanData);
                $data['jumlahData']    = json_encode($jumlahData);
                $data['statusLabels']  = json_encode($statusLabels);
                $data['statusCounts']  = json_encode($statusCounts);
                break;

            case 'petugas':
                $data['totalPeminjamanPending'] = $this->bookingModel
                    ->where('status', 'proses')
                    ->countAllResults(false);

                $data['jadwalRuang'] = $this->bookingModel
                    ->select('booking.*, user.username, room.nama_room')
                    ->join('user', 'user.id_user = booking.id_user')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->orderBy('booking.tanggal_mulai', 'ASC')
                    ->findAll();
                break;

            case 'peminjam':
                $data['myPeminjaman'] = $this->bookingModel
                    ->select('booking.*, room.nama_room')
                    ->join('room', 'room.id_room = booking.id_room')
                    ->where('booking.id_user', $user['id_user'])
                    ->orderBy('booking.tanggal_mulai', 'DESC')
                    ->findAll();

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
