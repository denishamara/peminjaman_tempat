<?php namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\RuangModel;
use App\Models\UserModel;
use App\Models\PeminjamanModel;

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

    private function onlyNonPeminjam()
    {
        $user = session()->get('user');
        if (!$user || strtolower($user['role']) === 'peminjam') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }
        return null;
    }

    // 📋 Daftar jadwal reguler
    public function index()
{
    $filter = $this->request->getGet('filter') ?? 'all';
    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    // Ambil jadwal reguler
    $jadwals = $jadwalModel
    ->select('jadwal_reguler.*, room.nama_room')
    ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
    ->where('jadwal_reguler.tanggal_selesai >=', date('Y-m-d H:i:s')) // hanya yang belum lewat
    ->where('jadwal_reguler.nama_reguler NOT LIKE', 'Booking-%') // 🚫 skip data hasil booking
    ->orderBy('jadwal_reguler.tanggal_mulai', 'ASC')
    ->findAll();

    // Ambil data booking aktif
    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
        ->where('booking.tanggal_selesai >=', date('Y-m-d H:i:s'))
        ->findAll();

    $gabungan = [];

    // 🔵 Tambahkan jadwal reguler
    if ($filter === 'all' || $filter === 'reguler') {
        foreach ($jadwals as $j) {
            $gabungan[] = [
                'nama_ruang'     => $j['nama_room'],
                'nama_kegiatan'  => $j['nama_reguler'],
                'hari'           => date('l', strtotime($j['tanggal_mulai'])),
                'tanggal'        => date('Y-m-d', strtotime($j['tanggal_mulai'])),
                'jam_mulai'      => date('H:i', strtotime($j['tanggal_mulai'])),
                'jam_selesai'    => date('H:i', strtotime($j['tanggal_selesai'])),
                'status'         => 'Reguler',
                'id_booking'     => null,
                'keterangan'     => $j['keterangan'] ?? null
            ];
        }
    }

    // 🟡 Tambahkan jadwal booking
    if ($filter === 'all' || $filter === 'booking') {
        foreach ($peminjamans as $p) {
            $gabungan[] = [
                'nama_ruang'     => $p['nama_room'],
                'nama_kegiatan'  => $p['keterangan'] ?? 'Booking Ruangan',
                'hari'           => date('l', strtotime($p['tanggal_mulai'])),
                'tanggal'        => date('Y-m-d', strtotime($p['tanggal_mulai'])),
                'jam_mulai'      => date('H:i', strtotime($p['tanggal_mulai'])),
                'jam_selesai'    => date('H:i', strtotime($p['tanggal_selesai'])),
                'status'         => 'Booking',
                'id_booking'     => $p['id_booking'],
                'keterangan'     => $p['keterangan'] ?? '-'
            ];
        }
    }

    // Urutkan berdasarkan tanggal
    usort($gabungan, function ($a, $b) {
        return strtotime($a['tanggal'] . ' ' . $a['jam_mulai']) <=> strtotime($b['tanggal'] . ' ' . $b['jam_mulai']);
    });

    return view('jadwal/index', [
        'jadwal' => $gabungan,
        'filter' => $filter
    ]);
}

    // ➕ Form tambah jadwal
    public function create()
    {
        if ($res = $this->onlyNonPeminjam()) return $res;

        $data = [
            'ruangs' => $this->ruangModel->findAll(),
            'users'  => $this->userModel->findAll(),
        ];

        return view('jadwal/create', $data);
    }

    // 💾 Simpan jadwal baru (dengan repeat)
    public function store()
    {
        if ($res = $this->onlyNonPeminjam()) return $res;

        $data = [
            'nama_reguler'    => $this->request->getPost('nama_reguler'),
            'id_room'         => $this->request->getPost('id_room'),
            'id_user'         => $this->request->getPost('id_user'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ];

        $repeat = (int) $this->request->getPost('repeat_minggu');
        if ($repeat > 52) $repeat = 52; // maksimal 1 tahun

        // Validasi wajib isi
        if (empty($data['id_room']) || empty($data['id_user']) || empty($data['tanggal_mulai']) || empty($data['tanggal_selesai'])) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        // Cek bentrok dengan jadwal lain
        if ($this->jadwalModel->isTimeConflict($data)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain.');
        }

        // Buat group_id unik agar jadwal berulang bisa dikaitkan
        $groupId = uniqid('reg_');
        $data['group_id'] = $groupId;

        // Simpan jadwal utama
        $this->jadwalModel->insert($data);

        // Buat jadwal otomatis mingguan
        if ($repeat > 0) {
            $mulai = strtotime($data['tanggal_mulai']);
            $selesai = strtotime($data['tanggal_selesai']);

            for ($i = 1; $i <= $repeat; $i++) {
                $nextMulai = strtotime("+{$i} week", $mulai);
                $nextSelesai = strtotime("+{$i} week", $selesai);

                if ($nextMulai < time()) continue; // skip jika jadwal sudah lewat

                $newData = $data;
                $newData['tanggal_mulai'] = date('Y-m-d H:i:s', $nextMulai);
                $newData['tanggal_selesai'] = date('Y-m-d H:i:s', $nextSelesai);

                if (!$this->jadwalModel->isTimeConflict($newData)) {
                    $this->jadwalModel->insert($newData);
                }
            }
        }

        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil ditambahkan' . ($repeat > 0 ? " dan diulang $repeat minggu ke depan." : '.'));
    }

    // 🔁 Update jadwal
    public function update($id)
    {
        if ($res = $this->onlyNonPeminjam()) return $res;

        $data = [
            'nama_reguler'    => $this->request->getPost('nama_reguler'),
            'id_room'         => $this->request->getPost('id_room'),
            'id_user'         => $this->request->getPost('id_user'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'keterangan'      => $this->request->getPost('keterangan'),
        ];

        // Cek bentrok dengan jadwal lain
        if ($this->jadwalModel->isTimeConflict($data, $id)) {
            return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal reguler lain.');
        }

        $this->jadwalModel->update($id, $data);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal reguler berhasil diperbarui.');
    }

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

    // 🗑️ Hapus satu jadwal
    public function delete($id)
    {
        if ($res = $this->onlyNonPeminjam()) return $res;

        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // 🗑️ Hapus semua jadwal dalam satu grup (jadwal berulang)
    public function deleteGroup($group_id)
    {
        if ($res = $this->onlyNonPeminjam()) return $res;

        $this->jadwalModel->where('group_id', $group_id)->delete();
        return redirect()->to('/jadwal/index')->with('success', 'Semua jadwal dalam grup ini berhasil dihapus.');
    }

    // 📅 Halaman Kalender
    public function kalender($id_room = null)
    {
        $ruangs = $this->ruangModel->findAll();

        $jadwalQuery = $this->jadwalModel
            ->select('jadwal_reguler.*, room.nama_room')
            ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left');

        if ($id_room) {
            $jadwalQuery->where('jadwal_reguler.id_room', $id_room);
        }

        $data = [
            'ruangs' => $ruangs,
            'jadwals' => $jadwalQuery->findAll(),
            'selectedRoom' => $id_room,
        ];

        return view('jadwal/kalender', $data);
    }

    // 📦 API JSON untuk data kalender
    public function getKalenderData()
{
    $id_room = $this->request->getGet('id_room');

    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    // ✅ Ambil jadwal reguler lengkap dengan nama ruang & user
    $jadwals = $jadwalModel
    ->select('jadwal_reguler.*, room.nama_room, user.username')
    ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
    ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
    ->where('jadwal_reguler.tanggal_selesai >=', date('Y-m-d H:i:s')); // ⏳ hanya yang belum lewat

if ($id_room) $jadwals->where('jadwal_reguler.id_room', $id_room);
$jadwals = $jadwals->findAll();

    // ✅ Ambil peminjaman aktif
    $peminjamans = $peminjamanModel
    ->select('booking.*, room.nama_room, user.username')
    ->join('room', 'room.id_room = booking.id_room', 'left')
    ->join('user', 'user.id_user = booking.id_user', 'left')
    ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
    ->where('booking.tanggal_selesai >=', date('Y-m-d H:i:s')); // tambahkan ini juga

if ($id_room) $peminjamans->where('booking.id_room', $id_room);
$peminjamans = $peminjamans->findAll();

    $events = [];

    // 🔵 Jadwal reguler
    foreach ($jadwals as $j) {
        $events[] = [
            'title'       => '[Reguler] ' . $j['nama_reguler'],
            'start'       => $j['tanggal_mulai'],
            'end'         => $j['tanggal_selesai'],
            'color'       => '#007bff',
            'nama_ruang'  => $j['nama_room'] ?? '-',
            'peminjam'    => $j['username'] ?? '-',
            'keterangan'  => $j['keterangan'] ?? '-',
            'status'      => 'Jadwal Reguler',
        ];
    }

    // 🟢 Peminjaman
    foreach ($peminjamans as $p) {
        $status = strtolower(trim($p['status']));
        $color = match (true) {
            in_array($status, ['disetujui', 'approve', 'approved', 'diterima', 'acc']) => '#28a745',
            in_array($status, ['pending', 'proses', 'dalam proses']) => '#ffc107',
            default => '#6c757d',
        };

        $events[] = [
            'title'       => '[Peminjaman] ' . $p['keterangan'] . ' (' . ucfirst($status) . ')',
            'start'       => $p['tanggal_mulai'],
            'end'         => $p['tanggal_selesai'],
            'color'       => $color,
            'nama_ruang'  => $p['nama_room'] ?? '-',
            'peminjam'    => $p['username'] ?? '-',
            'keterangan'  => $p['keterangan'] ?? '-',
            'status'      => ucfirst($status),
        ];
    }

    return $this->response->setJSON($events);
}

    // 🌐 Jadwal publik
    public function publicIndex()
{
    $filter = $this->request->getGet('filter') ?? 'all';
    $jadwalModel = new JadwalModel();
    $peminjamanModel = new PeminjamanModel();

    $now = date('Y-m-d H:i:s');

    // Ambil semua jadwal reguler yang belum lewat
    $jadwals = $jadwalModel
        ->select('jadwal_reguler.*, room.nama_room')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', $now)
        ->findAll();

    // Ambil semua booking aktif
    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
        ->where('booking.tanggal_selesai >=', $now)
        ->findAll();

    $gabungan = [];

    // Jadwal reguler
    if ($filter == 'all' || $filter == 'reguler') {
        foreach ($jadwals as $j) {
            $gabungan[] = [
                'nama_ruang'   => $j['nama_room'],
                'nama_kegiatan'=> $j['nama_reguler'],
                'hari'         => date('l', strtotime($j['tanggal_mulai'])),
                'jam_mulai'    => date('H:i', strtotime($j['tanggal_mulai'])),
                'jam_selesai'  => date('H:i', strtotime($j['tanggal_selesai'])),
                'status'       => 'Reguler'
            ];
        }
    }

    // Booking
    if ($filter == 'all' || $filter == 'booking') {
        foreach ($peminjamans as $p) {
            $gabungan[] = [
                'nama_ruang'   => $p['nama_room'],
                'nama_kegiatan'=> $p['keterangan'],
                'hari'         => date('l', strtotime($p['tanggal_mulai'])),
                'jam_mulai'    => date('H:i', strtotime($p['tanggal_mulai'])),
                'jam_selesai'  => date('H:i', strtotime($p['tanggal_selesai'])),
                'status'       => ucfirst(strtolower($p['status']))
            ];
        }
    }

    // Urutkan berdasarkan tanggal mulai
    usort($gabungan, fn($a, $b) => strcmp($a['jam_mulai'], $b['jam_mulai']));

    return view('jadwal/public_index', [
        'jadwal' => $gabungan,
        'filter' => $filter
    ]);
}
}
