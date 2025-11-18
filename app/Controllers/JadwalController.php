<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\RuangModel;
use App\Models\UserModel;
use App\Models\PeminjamanModel;
use App\Models\BookingModel;

class JadwalController extends BaseController
{
    protected $jadwalModel;
    protected $ruangModel;
    protected $userModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->ruangModel  = new RuangModel();
        $this->userModel   = new UserModel();
        $this->bookingModel = new BookingModel();
    }

    private function onlyNonPeminjam()
    {
        $user = session()->get('user');
        if (!$user || strtolower($user['role']) === 'peminjam') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }
        return null;
    }

    // 📋 Daftar jadwal reguler + booking
    public function index()
{
    $filter = $this->request->getGet('filter') ?? 'all';
    $search = $this->request->getGet('search') ?? '';
    
    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    // 🔹 Ambil jadwal reguler
    $jadwalQuery = $jadwalModel
        ->select('jadwal_reguler.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', date('Y-m-d H:i:s'))
        ->where("jadwal_reguler.nama_reguler NOT LIKE 'Booking-%'");

    // 🔹 Filter search untuk jadwal reguler
    if (!empty($search)) {
        $jadwalQuery->groupStart()
            ->like('room.nama_room', $search)
            ->orLike('jadwal_reguler.nama_reguler', $search)
            ->orLike('user.username', $search)
            ->groupEnd();
    }

    $jadwals = $jadwalQuery
        ->orderBy('jadwal_reguler.tanggal_mulai', 'ASC')
        ->findAll();

    // 🔹 Ambil booking aktif (yang disetujui)
    $acceptedStatuses = [
        'Disetujui','disetujui',
        'Diterima','diterima',
        'Approve','approve',
        'Approved','approved',
        'Acc','acc'
    ];

    $peminjamanQuery = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereIn('booking.status', $acceptedStatuses)
        ->where('booking.tanggal_selesai >=', date('Y-m-d H:i:s'));

    // 🔹 Filter search untuk booking
    if (!empty($search)) {
        $peminjamanQuery->groupStart()
            ->like('room.nama_room', $search)
            ->orLike('booking.keterangan', $search)
            ->orLike('user.username', $search)
            ->groupEnd();
    }

    $peminjamans = $peminjamanQuery
        ->orderBy('booking.tanggal_mulai', 'ASC')
        ->findAll();

    $gabungan = [];

    // 🔵 Tambahkan jadwal reguler
    if ($filter === 'all' || $filter === 'reguler') {
        foreach ($jadwals as $j) {
            $gabungan[] = [
                'id'             => $j['id_reguler'],
                'nama_ruang'     => $j['nama_room'] ?? '-',
                'nama_kegiatan'  => $j['nama_reguler'] ?? '-',
                'peminjam'       => $j['username'] ?? '(Reguler)',
                'tanggal_mulai'  => $j['tanggal_mulai'],
                'tanggal_selesai'=> $j['tanggal_selesai'],
                'jam_mulai'      => date('H:i', strtotime($j['tanggal_mulai'])),
                'jam_selesai'    => date('H:i', strtotime($j['tanggal_selesai'])),
                'status'         => 'Reguler',
            ];
        }
    }

    // 🟢 Tambahkan jadwal booking (yang disetujui)
    if ($filter === 'all' || $filter === 'booking') {
        foreach ($peminjamans as $p) {
            $gabungan[] = [
                'id'             => $p['id_booking'],
                'nama_ruang'     => $p['nama_room'] ?? '-',
                'nama_kegiatan'  => $p['keterangan'] ?? 'Booking Ruangan',
                'peminjam'       => $p['username'] ?? '(Tidak diketahui)',
                'tanggal_mulai'  => $p['tanggal_mulai'],
                'tanggal_selesai'=> $p['tanggal_selesai'],
                'jam_mulai'      => date('H:i', strtotime($p['tanggal_mulai'])),
                'jam_selesai'    => date('H:i', strtotime($p['tanggal_selesai'])),
                'status'         => 'Booking',
            ];
        }
    }

    // 🔍 Filter manual untuk search (backup filter)
    if (!empty($search)) {
        $searchLower = strtolower($search);
        $gabungan = array_filter($gabungan, function($item) use ($searchLower) {
            return strpos(strtolower($item['nama_ruang']), $searchLower) !== false ||
                   strpos(strtolower($item['nama_kegiatan']), $searchLower) !== false ||
                   strpos(strtolower($item['peminjam']), $searchLower) !== false;
        });
    }

    // Urutkan berdasar waktu mulai
    usort($gabungan, function ($a, $b) {
        return strtotime($a['tanggal_mulai']) <=> strtotime($b['tanggal_mulai']);
    });

    return view('jadwal/index', [
        'jadwal' => $gabungan,
        'filter' => $filter,
        'search' => $search,
        'user'   => session()->get('user'),
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

    // ⛔ VALIDASI BARU: Cegah membuat jadwal di waktu yang sudah lewat
    $now = time();
    $mulai = strtotime($data['tanggal_mulai']);
    $selesai = strtotime($data['tanggal_selesai']);

    if ($mulai < $now || $selesai < $now) {
        return redirect()->back()->withInput()->with('error', 'Tidak dapat membuat jadwal pada waktu yang sudah lewat.');
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

            // tetap benar → skip jadwal yang sudah lewat
            if ($nextMulai < time()) continue;

            $newData = $data;
            $newData['tanggal_mulai'] = date('Y-m-d H:i:s', $nextMulai);
            $newData['tanggal_selesai'] = date('Y-m-d H:i:s', $nextSelesai);

            // tetap benar → cek bentrok untuk jadwal repeat
            if (!$this->jadwalModel->isTimeConflict($newData)) {
                $this->jadwalModel->insert($newData);
            }
        }
    }

    return redirect()->to('/jadwal')->with('success', 'Jadwal berhasil dibuat.');
}

    // 🔁 Update jadwal
    public function update($id)
{
    $tipe = $this->request->getPost('tipe');

    /* ======================================================
       ==============  UPDATE JADWAL REGULER  ===============
       ====================================================== */
    if ($tipe === 'reguler') {

        $data = [
            'id_room' => $this->request->getPost('id_room'),
            'id_user' => $this->request->getPost('id_user'),
            'nama_reguler' => $this->request->getPost('nama_kegiatan'),
            'status' => $this->request->getPost('status') ?? 'Aktif',
        ];

        // Ambil sesi (jika ada)
        $sesi = $this->request->getPost('sesi');
        if (!empty($sesi)) {
            sort($sesi);
            $sesiWaktu = [
                1 => ['07:15','08:00'], 2 => ['08:05','08:50'], 3 => ['08:55','09:40'],
                4 => ['09:45','10:30'], 5 => ['10:35','11:20'], 6 => ['11:25','12:10'],
                7 => ['12:15','13:00'], 8 => ['13:05','13:50'], 9 => ['13:55','14:40'],
                10=> ['14:45','15:30']
            ];

            $tanggal = $this->request->getPost('tanggal');
            $first = $sesiWaktu[$sesi[0]];
            $last  = $sesiWaktu[end($sesi)];

            $data['tanggal_mulai'] = $tanggal . ' ' . $first[0];
            $data['tanggal_selesai'] = $tanggal . ' ' . $last[1];
        }

        /* === VALIDASI WAKTU LEWAT — hanya jika sesi diubah === */
        if (!empty($sesi)) {
            $now = time();
            $mulai  = strtotime($data['tanggal_mulai']);
            $selesai = strtotime($data['tanggal_selesai']);

            if ($mulai < $now || $selesai < $now) {
                return redirect()->back()->withInput()->with('error', 'Tidak dapat memindahkan jadwal ke waktu yang sudah lewat.');
            }

            // Cek bentrok jadwal lain (kecuali dirinya sendiri)
            if ($this->jadwalModel->isTimeConflict($data, $id)) {
                return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain.');
            }
        }

        // Update jadwal reguler
        $this->jadwalModel->update($id, $data);
    }

    /* ======================================================
       ==================  UPDATE BOOKING  ==================
       ====================================================== */
    else if ($tipe === 'booking') {

        $mulaiTgl = $this->request->getPost('tanggal_mulai_tgl');
        $selesaiTgl = $this->request->getPost('tanggal_selesai_tgl');
        $mulaiJam = $this->request->getPost('jam_mulai') ?? '00:00';
        $selesaiJam = $this->request->getPost('jam_selesai') ?? '23:59';

        $data = [
            'id_room' => $this->request->getPost('id_room'),
            'id_user' => $this->request->getPost('id_user'),
            'tanggal_mulai' => date('Y-m-d H:i:s', strtotime("$mulaiTgl $mulaiJam")),
            'tanggal_selesai' => date('Y-m-d H:i:s', strtotime("$selesaiTgl $selesaiJam")),
            'keterangan' => $this->request->getPost('nama_kegiatan') ?? '',
            'status' => 'Diterima',
        ];

        /* === VALIDASI WAKTU LEWAT === */
        $now = time();
        $mulai  = strtotime($data['tanggal_mulai']);
        $selesai = strtotime($data['tanggal_selesai']);

        if ($mulai < $now || $selesai < $now) {
            return redirect()->back()->withInput()->with('error', 'Tidak dapat memindahkan booking ke waktu yang sudah lewat.');
        }

        // Cek bentrok booking lain (kecuali dirinya sendiri)
        if ($this->bookingModel->isTimeConflict($data, $id)) {
            return redirect()->back()->withInput()->with('error', 'Waktu booking bentrok dengan jadwal lain.');
        }

        // Update booking
        $this->bookingModel->update($id, $data);
    }

    return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil diperbarui.');
}

    public function edit($id)
{
    // ambil parameter tipe dari query string (?tipe=booking / reguler)
    $tipe = strtolower($this->request->getGet('tipe') ?? 'reguler');

    if ($tipe === 'booking') {
        $peminjamanModel = new \App\Models\PeminjamanModel();
        $jadwal = $peminjamanModel->find($id);
    } else {
        $jadwal = $this->jadwalModel->find($id);
    }

    if (!$jadwal) {
        return redirect()->to('/jadwal/index')->with('error', 'Data tidak ditemukan.');
    }

    return view('jadwal/edit', [
        'title'  => 'Edit Jadwal',
        'jadwal' => $jadwal,
        'tipe'   => $tipe,
        'ruangs' => $this->ruangModel->findAll(),
        'users'  => $this->userModel->findAll(),
    ]);
}

    // 🗑️ Hapus satu jadwal
    public function delete($id)
{
    if ($res = $this->onlyNonPeminjam()) return $res;

    $tipe = $this->request->getPost('tipe') ?? 'reguler';

    if($tipe === 'reguler') {
        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal reguler berhasil dihapus.');
    } else {
        $this->bookingModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal booking berhasil dihapus.');
    }
}

    public function kalender($id_room = null)
{
    $ruangs = $this->ruangModel->findAll();

    return view('jadwal/kalender', [
        'ruangs' => $ruangs,
        'selectedRoom' => $id_room,
    ]);
}

public function getKalenderData()
{
    $id_room = $this->request->getGet('id_room');

    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    date_default_timezone_set('Asia/Jakarta');
    $now = new \DateTime(); // waktu sekarang

    // ambil semua dulu (nanti difilter manual di PHP)
    $jadwals = $jadwalModel
    ->select('jadwal_reguler.*, room.nama_room, user.username')
    ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
    ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
    ->where("jadwal_reguler.nama_reguler NOT LIKE 'Booking-%'") // 🚫 hindari duplikat dari booking
    ->when($id_room, fn($q) => $q->where('jadwal_reguler.id_room', $id_room))
    ->findAll();

    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
        ->when($id_room, fn($q) => $q->where('booking.id_room', $id_room))
        ->findAll();

    $events = [];

    // helper konversi ke DateTime aman
    $toDate = function($str) {
        if (empty($str)) return null;
        try {
            return new \DateTime($str);
        } catch (\Exception $e) {
            return null;
        }
    };

    // Jadwal Reguler
    foreach ($jadwals as $j) {
        $end = $toDate($j['tanggal_selesai']);
        if (!$end || $end <= $now) continue; // sudah lewat

        $start = $toDate($j['tanggal_mulai']) ?: clone $end;
        $events[] = [
            'title' => '[Reguler] ' . ($j['nama_reguler'] ?? '-'),
            'start' => $start->format('Y-m-d\TH:i:s'),
            'end'   => $end->format('Y-m-d\TH:i:s'),
            'color' => '#007bff',
            'nama_ruang' => $j['nama_room'] ?? '-',
            'peminjam' => $j['username'] ?? '-',
            'status' => 'Jadwal Reguler',
        ];
    }

    // Peminjaman
    foreach ($peminjamans as $p) {
        $end = $toDate($p['tanggal_selesai']);
        if (!$end || $end <= $now) continue; // sudah lewat

        $start = $toDate($p['tanggal_mulai']) ?: clone $end;
        $status = strtolower($p['status'] ?? '');
        $color = match ($status) {
            'disetujui', 'approve', 'approved', 'diterima', 'acc' => '#28a745',
            'pending', 'proses', 'dalam proses' => '#f0ad4e',
            default => '#6c757d',
        };

        $events[] = [
            'title' => '[Peminjaman] ' . ($p['keterangan'] ?? '-') . ' (' . ucfirst($status) . ')',
            'start' => $start->format('Y-m-d\TH:i:s'),
            'end'   => $end->format('Y-m-d\TH:i:s'),
            'color' => $color,
            'nama_ruang' => $p['nama_room'] ?? '-',
            'peminjam' => $p['username'] ?? '-',
            'status' => ucfirst($status),
        ];
    }

    return $this->response->setJSON($events);
}

    // ... kalender & getKalenderData tetap seperti sebelumnya (jika ada)
    public function publicIndex()
{
    date_default_timezone_set('Asia/Jakarta');
    $filter = $this->request->getGet('filter') ?? 'all';

    $jadwalModel = new JadwalModel();
    $peminjamanModel = new PeminjamanModel();

    $now = date('Y-m-d H:i:s');

    // 🔹 Ambil jadwal reguler yang belum lewat, nama_reguler bukan 'Booking-%'
    $jadwals = $jadwalModel
        ->select('jadwal_reguler.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', $now)
        ->where("jadwal_reguler.nama_reguler NOT LIKE 'Booking-%'")
        ->orderBy('jadwal_reguler.tanggal_mulai', 'ASC')
        ->findAll();

    // 🔹 Ambil booking aktif (yang disetujui)
    $acceptedStatuses = ['Disetujui','disetujui','Diterima','diterima','Approve','approve','Approved','approved','Acc','acc'];

    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereIn('booking.status', $acceptedStatuses)
        ->where('booking.tanggal_selesai >=', $now)
        ->orderBy('booking.tanggal_mulai', 'ASC')
        ->findAll();

    $gabungan = [];

    // 🔵 Tambahkan jadwal reguler
    if ($filter === 'all' || $filter === 'reguler') {
        foreach ($jadwals as $j) {
            $gabungan[] = [
                'nama_ruang'    => $j['nama_room'] ?? '-',
                'nama_kegiatan' => $j['nama_reguler'] ?? '-',
                'peminjam'      => $j['username'] ?? '(Reguler)',
                'tanggal'       => date('Y-m-d', strtotime($j['tanggal_mulai'])),
                'jam_mulai'     => date('H:i', strtotime($j['tanggal_mulai'])),
                'jam_selesai'   => date('H:i', strtotime($j['tanggal_selesai'])),
                'status'        => 'Reguler'
            ];
        }
    }

    // 🟢 Tambahkan booking
    if ($filter === 'all' || $filter === 'booking') {
        foreach ($peminjamans as $p) {
            $rentangTanggal = (date('Y-m-d', strtotime($p['tanggal_mulai'])) === date('Y-m-d', strtotime($p['tanggal_selesai'])))
                ? date('Y-m-d', strtotime($p['tanggal_mulai']))
                : date('Y-m-d', strtotime($p['tanggal_mulai'])) . ' s/d ' . date('Y-m-d', strtotime($p['tanggal_selesai']));

            $gabungan[] = [
                'nama_ruang'    => $p['nama_room'] ?? '-',
                'nama_kegiatan' => $p['keterangan'] ?? 'Booking Ruangan',
                'peminjam'      => $p['username'] ?? '-',
                'tanggal'       => $rentangTanggal,
                'jam_mulai'     => date('H:i', strtotime($p['tanggal_mulai'])),
                'jam_selesai'   => date('H:i', strtotime($p['tanggal_selesai'])),
                'status'        => 'Booking'
            ];
        }
    }

    // 🔹 Jika kosong
    if (empty($gabungan)) {
        $gabungan[] = [
            'nama_ruang'    => '-',
            'nama_kegiatan' => 'Tidak ada jadwal aktif',
            'tanggal'       => date('Y-m-d'),
            'jam_mulai'     => '-',
            'jam_selesai'   => '-',
            'status'        => '-'
        ];
    }

    // 🔹 Urutkan berdasarkan tanggal & jam mulai
    usort($gabungan, function ($a, $b) {
        $ta = strtotime(explode(' ', $a['tanggal'])[0]);
        $tb = strtotime(explode(' ', $b['tanggal'])[0]);
        return $ta <=> $tb ?: strcmp($a['jam_mulai'], $b['jam_mulai']);
    });

    return view('jadwal/public_index', [
        'jadwal' => $gabungan,
        'filter' => $filter
    ]);
}
}
