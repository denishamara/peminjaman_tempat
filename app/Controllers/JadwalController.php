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
    $jadwalModel = new \App\Models\JadwalModel();
    $peminjamanModel = new \App\Models\PeminjamanModel();

    // 🔹 Ambil jadwal reguler
    $jadwals = $jadwalModel
        ->select('jadwal_reguler.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', date('Y-m-d H:i:s'))
        ->where("jadwal_reguler.nama_reguler NOT LIKE 'Booking-%'")
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

    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereIn('booking.status', $acceptedStatuses)
        ->where('booking.tanggal_selesai >=', date('Y-m-d H:i:s'))
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

    // Urutkan berdasar waktu mulai
    usort($gabungan, function ($a, $b) {
        return strtotime($a['tanggal_mulai']) <=> strtotime($b['tanggal_mulai']);
    });

    return view('jadwal/index', [
        'jadwal' => $gabungan,
        'filter' => $filter,
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
    $tipe = $this->request->getPost('tipe');

    $data = [
        'id_room'         => $this->request->getPost('id_room'),
        'id_user'         => $this->request->getPost('id_user'),
        'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        'keterangan'      => $this->request->getPost('keterangan'),
    ];

    // ✅ Kalau jadwal reguler (manual input)
    if ($tipe === 'reguler') {
        $data['nama_reguler'] = $this->request->getPost('nama_kegiatan');
        $data['status'] = $this->request->getPost('status'); // boleh ubah status
        $this->jadwalModel->update($id, $data);

    // ✅ Kalau jadwal dari booking (hasil persetujuan peminjaman)
    } else {
        $data['keterangan'] = $this->request->getPost('keterangan');
        $data['status'] = 'Diterima'; // pastikan status tetap diterima
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

    // Coba cari di jadwal_reguler
    $jadwal = $this->jadwalModel->find($id);
    if ($jadwal) {
        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal reguler berhasil dihapus.');
    }

    // Kalau gak ada, coba cari di booking
    $peminjamanModel = new \App\Models\PeminjamanModel();
    $peminjaman = $peminjamanModel->find($id);
    if ($peminjaman) {
        $peminjamanModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal booking berhasil dihapus.');
    }

    // Kalau dua-duanya gak ketemu
    return redirect()->to('/jadwal/index')->with('error', 'Data tidak ditemukan.');
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

    // --- Ambil jadwal reguler (yang belum lewat) ---
    $jadwals = $jadwalModel
        ->select('jadwal_reguler.*, room.nama_room, user.username')
        ->join('user', 'user.id_user = jadwal_reguler.id_user', 'left')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', $now)
        ->findAll();

    // --- Ambil peminjaman aktif (belum ditolak / selesai / lewat) ---
    $peminjamans = $peminjamanModel
        ->select('booking.*, room.nama_room, user.username')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->join('user', 'user.id_user = booking.id_user', 'left')
        ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
        ->where('booking.tanggal_selesai >=', $now)
        ->findAll();

    $gabungan = [];
    $terbooking = [];

    // 🔹 tandai ruangan yang dibooking tiap tanggal
    foreach ($peminjamans as $b) {
        if (empty($b['tanggal_mulai']) || empty($b['tanggal_selesai'])) continue;
        $mulai = new \DateTime($b['tanggal_mulai']);
        $selesai = new \DateTime($b['tanggal_selesai']);
        for ($d = clone $mulai; $d <= $selesai; $d->modify('+1 day')) {
            $tglKey = $b['id_room'] . '_' . $d->format('Y-m-d');
            $terbooking[$tglKey] = true;
        }
    }

    // 🔹 tambah jadwal reguler
    if ($filter == 'all' || $filter == 'reguler') {
        foreach ($jadwals as $j) {
            if (empty($j['tanggal_mulai']) || empty($j['tanggal_selesai'])) continue;

            $tglMulai = new \DateTime($j['tanggal_mulai']);
            $tglSelesai = new \DateTime($j['tanggal_selesai']);
            $tglKey = $j['id_room'] . '_' . $tglMulai->format('Y-m-d');

            if (!isset($terbooking[$tglKey]) && $tglSelesai->format('Y-m-d H:i:s') >= $now) {
                $gabungan[] = [
                    'nama_ruang'    => $j['nama_room'] ?? '-',
                    'nama_kegiatan' => $j['nama_reguler'] ?? '-',
                    'peminjam'      => $j['username'] ?? '(Reguler)',
                    'tanggal'       => $tglMulai->format('Y-m-d'),
                    'jam_mulai'     => date('H:i', strtotime($j['tanggal_mulai'])),
                    'jam_selesai'   => date('H:i', strtotime($j['tanggal_selesai'])),
                    'status'        => 'Reguler'
                ];
            }
        }
    }

    // 🔹 tambah booking aktif
    if ($filter == 'all' || $filter == 'booking') {
        foreach ($peminjamans as $p) {
            if (empty($p['tanggal_mulai']) || empty($p['tanggal_selesai'])) continue;

            $tglMulai = new \DateTime($p['tanggal_mulai']);
            $tglSelesai = new \DateTime($p['tanggal_selesai']);

            if ($tglSelesai->format('Y-m-d H:i:s') >= $now) {
                $rentangTanggal = ($tglMulai->format('Y-m-d') === $tglSelesai->format('Y-m-d'))
                    ? $tglMulai->format('Y-m-d')
                    : $tglMulai->format('Y-m-d') . ' s/d ' . $tglSelesai->format('Y-m-d');

                $gabungan[] = [
                    'nama_ruang'    => $p['nama_room'] ?? '-',
                    'nama_kegiatan' => $p['keterangan'] ?? '-',
                    'peminjam'      => $p['username'] ?? '-',
                    'tanggal'       => $rentangTanggal,
                    'jam_mulai'     => date('H:i', strtotime($p['tanggal_mulai'])),
                    'jam_selesai'   => date('H:i', strtotime($p['tanggal_selesai'])),
                    'status'        => ucfirst(strtolower($p['status'] ?? 'Booking'))
                ];
            }
        }
    }

    // 🔹 jika kosong
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

    // 🔹 urutkan benar-benar berdasar tanggal mulai (bukan string strip)
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
