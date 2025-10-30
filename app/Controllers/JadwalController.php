<?php namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\RuangModel;
use App\Models\UserModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $ruangModel;
    protected $userModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->ruangModel  = new RuangModel();
        $this->userModel   = new UserModel();
    }

    /**
     * Batasi akses hanya untuk selain peminjam
     */
    private function onlyNonPeminjam()
    {
        $user = session()->get('user');
        if (!$user || $user['role'] === 'peminjam') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }
        return null;
    }

    /**
     * Tampilkan daftar jadwal
     */
    public function index()
    {
        $data['jadwals'] = $this->jadwalModel
            ->select('jadwal_reguler.*, user.username, room.nama_room')
            ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
            ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
            ->orderBy('jadwal_reguler.tanggal_mulai', 'DESC')
            ->findAll();

        return view('jadwal/index', $data);
    }

    /**
     * Form tambah jadwal
     */
    public function create()
    {
        $res = $this->onlyNonPeminjam();
        if ($res) return $res;

        $data['ruangs'] = $this->ruangModel->findAll();
        $data['users']  = $this->userModel->findAll();

        return view('jadwal/create', $data);
    }

    /**
     * Simpan jadwal baru
     */
    public function store()
    {
        $res = $this->onlyNonPeminjam();
        if ($res) return $res;

        $data = [
            'nama_reguler'    => $this->request->getPost('nama_reguler'),
            'id_room'         => $this->request->getPost('id_room'),
            'id_user'         => $this->request->getPost('id_user'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ];

        // Validasi sederhana
        if (empty($data['id_room']) || empty($data['id_user']) || empty($data['tanggal_mulai']) || empty($data['tanggal_selesai'])) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        // Cek bentrok
        if ($this->jadwalModel->isTimeConflict($data)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain.');
        }

        $this->jadwalModel->insert($data);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Form edit jadwal
     */
    public function edit($id)
    {
        $res = $this->onlyNonPeminjam();
        if ($res) return $res;

        $data['jadwal'] = $this->jadwalModel->find($id);
        if (!$data['jadwal']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data tidak ditemukan");
        }

        $data['ruangs'] = $this->ruangModel->findAll();
        $data['users']  = $this->userModel->findAll();

        return view('jadwal/edit', $data);
    }

    /**
     * Update jadwal
     */
    public function update($id)
    {
        $res = $this->onlyNonPeminjam();
        if ($res) return $res;

        $data = [
            'nama_reguler'    => $this->request->getPost('nama_reguler'),
            'id_room'         => $this->request->getPost('id_room'),
            'id_user'         => $this->request->getPost('id_user'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ];

        if ($this->jadwalModel->isTimeConflict($data, $id)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain.');
        }

        $this->jadwalModel->update($id, $data);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal
     */
    public function delete($id)
    {
        $res = $this->onlyNonPeminjam();
        if ($res) return $res;

        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Halaman Kalender
     */
    public function kalender($id_room = null)
    {
        $ruangs = $this->ruangModel->findAll();

        if ($id_room === null) {
            $jadwals = $this->jadwalModel
                ->select('jadwal_reguler.*, room.nama_room')
                ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
                ->findAll();
        } else {
            $jadwals = $this->jadwalModel
                ->select('jadwal_reguler.*, room.nama_room')
                ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
                ->where('jadwal_reguler.id_room', $id_room)
                ->findAll();
        }

        $data = [
            'ruangs' => $ruangs,
            'jadwals' => $jadwals,
            'selectedRoom' => $id_room
        ];

        return view('jadwal/kalender', $data);
    }

    /**
     * API untuk ambil data kalender (JSON)
     */
    public function getKalenderData()
{
    $id_room = $this->request->getGet('id_room');

    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    // === Ambil data jadwal reguler (biru) ===
    $jadwalBuilder = $jadwalModel;
    if ($id_room) {
        $jadwalBuilder = $jadwalBuilder->where('id_room', $id_room);
    }
    $jadwals = $jadwalBuilder->findAll();

    // === Ambil data peminjaman yang disetujui atau proses/pending ===
    $peminjamanBuilder = $peminjamanModel;
    if ($id_room) {
        $peminjamanBuilder = $peminjamanBuilder->where('id_room', $id_room);
    }

    // status bisa saja 'pending', 'proses', atau 'dalam proses'
    $peminjamans = $peminjamanBuilder
        ->whereNotIn('status', ['ditolak', 'selesai'])
        ->findAll();

    // === Gabungkan event kalender ===
    $events = [];

    // Jadwal reguler (biru)
    foreach ($jadwals as $j) {
        $events[] = [
            'title' => '[Reguler] ' . $j['nama_reguler'],
            'start' => $j['tanggal_mulai'],
            'end'   => $j['tanggal_selesai'],
            'color' => '#007bff', // biru
        ];
    }

    // Peminjaman (disetujui hijau, proses kuning)
    foreach ($peminjamans as $p) {
        $status = strtolower(trim($p['status']));
        $color = '#6c757d'; // default abu

        if (in_array($status, ['disetujui', 'approve', 'approved', 'diterima', 'acc', 'ok'])) {
            $color = '#28a745'; // hijau (disetujui)
        } elseif (in_array($status, ['pending', 'proses', 'dalam proses'])) {
            $color = '#ffc107'; // kuning (proses)
        }

        $events[] = [
            'title' => '[Peminjaman] ' . $p['keterangan'] . ' (' . ucfirst($status) . ')',
            'start' => $p['tanggal_mulai'],
            'end'   => $p['tanggal_selesai'],
            'color' => $color,
        ];
    }

    return $this->response->setJSON($events);
}
}
