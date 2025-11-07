<?php

namespace App\Controllers;

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

    // 📋 Daftar jadwal reguler + booking
    public function index()
    {
        $filter = $this->request->getGet('filter') ?? 'all';
        $jadwalModel = new \App\Models\JadwalModel();
        $peminjamanModel = new \App\Models\PeminjamanModel();

        // 🔹 Ambil jadwal reguler (HINDARI yang dibuat dari booking: nama_reguler LIKE 'Booking-%')
        $jadwals = $jadwalModel
            ->select('jadwal_reguler.* , room.nama_room')
            ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
            ->where('jadwal_reguler.tanggal_selesai >=', date('Y-m-d H:i:s'))
            ->where("jadwal_reguler.nama_reguler NOT LIKE 'Booking-%'") // skip entry hasil booking
            ->orderBy('jadwal_reguler.tanggal_mulai', 'ASC')
            ->findAll();

        // 🔹 Ambil booking aktif (HANYA yg disetujui) — include various capitalization
        $acceptedStatuses = [
            'Disetujui','disetujui',
            'Diterima','diterima',
            'Approve','approve',
            'Approved','approved',
            'Acc','acc'
        ];

        $peminjamans = $peminjamanModel
            ->select('booking.* , room.nama_room, user.username')
            ->join('room', 'room.id_room = booking.id_room', 'left')
            ->join('user', 'user.id_user = booking.id_user', 'left')
            ->whereIn('booking.status', $acceptedStatuses)
            ->where('booking.tanggal_selesai >=', date('Y-m-d H:i:s'))
            ->orderBy('booking.tanggal_mulai', 'ASC')
            ->findAll();

        $gabungan = [];

        // 🔵 Tambahkan jadwal reguler (sertakan id + raw tanggal)
        if ($filter === 'all' || $filter === 'reguler') {
            foreach ($jadwals as $j) {
                $gabungan[] = [
                    'id'             => $j['id_reguler'],
                    'nama_ruang'     => $j['nama_room'] ?? '-',
                    'nama_kegiatan'  => $j['nama_reguler'] ?? '-',
                    'tanggal'        => date('Y-m-d', strtotime($j['tanggal_mulai'])),
                    'tanggal_mulai'  => $j['tanggal_mulai'],
                    'tanggal_selesai'=> $j['tanggal_selesai'],
                    'jam_mulai'      => date('H:i', strtotime($j['tanggal_mulai'])),
                    'jam_selesai'    => date('H:i', strtotime($j['tanggal_selesai'])),
                    'status'         => 'Reguler',
                    'keterangan'     => $j['keterangan'] ?? null
                ];
            }
        }

        // 🟢 Tambahkan jadwal booking (yang disetujui) — sertakan id_booking
        if ($filter === 'all' || $filter === 'booking') {
            foreach ($peminjamans as $p) {
                $gabungan[] = [
                    'id'             => $p['id_booking'],
                    'nama_ruang'     => $p['nama_room'] ?? '-',
                    'nama_kegiatan'  => $p['keterangan'] ?? 'Booking Ruangan',
                    'tanggal'        => date('Y-m-d', strtotime($p['tanggal_mulai'])),
                    'tanggal_mulai'  => $p['tanggal_mulai'],
                    'tanggal_selesai'=> $p['tanggal_selesai'],
                    'jam_mulai'      => date('H:i', strtotime($p['tanggal_mulai'])),
                    'jam_selesai'    => date('H:i', strtotime($p['tanggal_selesai'])),
                    'status'         => 'Booking',
                    'keterangan'     => $p['keterangan'] ?? '-'
                ];
            }
        }

        // Urutkan berdasarkan tanggal + jam mulai (pakai raw tanggal supaya konsisten)
        usort($gabungan, function ($a, $b) {
            $ta = strtotime(($a['tanggal'] ?? '') . ' ' . ($a['jam_mulai'] ?? '00:00'));
            $tb = strtotime(($b['tanggal'] ?? '') . ' ' . ($b['jam_mulai'] ?? '00:00'));
            return $ta <=> $tb;
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
    if ($res = $this->onlyNonPeminjam()) return $res;

    $tipe = $this->request->getPost('tipe') ?? 'reguler';
    $namaKegiatan = $this->request->getPost('nama_kegiatan');

    // data umum tanggal/jam/ruang/user
    $dataCommon = [
        'id_room'         => $this->request->getPost('id_room'),
        'id_user'         => $this->request->getPost('id_user'),
        'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
        'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
    ];

    if ($tipe === 'reguler') {
        // update jadwal_reguler
        $data = $dataCommon;
        $data['nama_reguler'] = $namaKegiatan;
        $data['keterangan'] = $this->request->getPost('keterangan');
        $this->jadwalModel->update($id, $data);
    } else {
        // update booking (peminjaman)
        $peminjamanModel = new \App\Models\PeminjamanModel();
        $data = $dataCommon;
        // booking menyimpan nama kegiatan di kolom 'keterangan'
        $data['keterangan'] = $namaKegiatan;
        // jangan lupa update juga status jika ada field status di form (opsional)
        if ($this->request->getPost('status') !== null) {
            $data['status'] = $this->request->getPost('status');
        }
        $peminjamanModel->update($id, $data);
    }

    return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil diperbarui.');
}

    public function edit($id)
{
    // cari di jadwal reguler dulu
    $jadwal = $this->jadwalModel->find($id);
    $tipe = 'reguler';

    // kalau gak ketemu, coba di booking (peminjaman)
    if (!$jadwal) {
        $peminjamanModel = new \App\Models\PeminjamanModel();
        $jadwal = $peminjamanModel->find($id);
        $tipe = 'booking';
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

        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal/index')->with('success', 'Jadwal berhasil dihapus.');
    }

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
    // ... kalender & getKalenderData tetap seperti sebelumnya (jika ada)
    public function publicIndex()
{
    $filter = $this->request->getGet('filter') ?? 'all';
    $jadwalModel = new JadwalModel();
    $peminjamanModel = new PeminjamanModel();

    $now = date('Y-m-d H:i:s');

    // Ambil jadwal reguler
    $jadwals = $jadwalModel
        ->select('jadwal_reguler.id_reguler, jadwal_reguler.id_room, jadwal_reguler.nama_reguler, jadwal_reguler.tanggal_mulai, jadwal_reguler.tanggal_selesai, room.nama_room')
        ->join('room', 'room.id_room = jadwal_reguler.id_room', 'left')
        ->where('jadwal_reguler.tanggal_selesai >=', $now)
        ->findAll();

    // Ambil peminjaman aktif
    $peminjamans = $peminjamanModel
        ->select('booking.id_booking, booking.id_room, booking.keterangan, booking.tanggal_mulai, booking.tanggal_selesai, booking.status, room.nama_room')
        ->join('room', 'room.id_room = booking.id_room', 'left')
        ->whereNotIn('booking.status', ['Ditolak', 'Selesai'])
        ->where('booking.tanggal_selesai >=', $now)
        ->findAll();

    $gabungan = [];
    $terbooking = [];

    // Tandai ruangan yang sudah dibooking (tiap hari dalam rentang booking)
    foreach ($peminjamans as $b) {
        $mulai = new \DateTime($b['tanggal_mulai']);
        $selesai = new \DateTime($b['tanggal_selesai']);
        for ($d = clone $mulai; $d <= $selesai; $d->modify('+1 day')) {
            $tglKey = $b['id_room'] . '_' . $d->format('Y-m-d');
            $terbooking[$tglKey] = true;
        }
    }

    // Tambah jadwal reguler
    if ($filter == 'all' || $filter == 'reguler') {
        foreach ($jadwals as $j) {
            $tgl = date('Y-m-d', strtotime($j['tanggal_mulai']));
            $key = $j['id_room'] . '_' . $tgl;

            if (!isset($terbooking[$key])) {
                $gabungan[] = [
                    'nama_ruang'    => $j['nama_room'] ?? '-',
                    'nama_kegiatan' => $j['nama_reguler'] ?? '-',
                    'tanggal'       => date('d-m-Y', strtotime($j['tanggal_mulai'])),
                    'jam_mulai'     => date('H:i', strtotime($j['tanggal_mulai'])),
                    'jam_selesai'   => date('H:i', strtotime($j['tanggal_selesai'])),
                    'status'        => 'Reguler'
                ];
            }
        }
    }

    // Tambah booking aktif (rentang tanggal kalau lebih dari 1 hari)
    if ($filter == 'all' || $filter == 'booking') {
        foreach ($peminjamans as $p) {
            $mulai = date('d-m-Y', strtotime($p['tanggal_mulai']));
            $selesai = date('d-m-Y', strtotime($p['tanggal_selesai']));
            $rentangTanggal = ($mulai === $selesai) ? $mulai : "$mulai s/d $selesai";

            $gabungan[] = [
                'nama_ruang'    => $p['nama_room'] ?? '-',
                'nama_kegiatan' => $p['keterangan'] ?? '-',
                'tanggal'       => $rentangTanggal,
                'jam_mulai'     => date('H:i', strtotime($p['tanggal_mulai'])),
                'jam_selesai'   => date('H:i', strtotime($p['tanggal_selesai'])),
                'status'        => ucfirst(strtolower($p['status'] ?? 'Booking'))
            ];
        }
    }

    // Jika kosong
    if (empty($gabungan)) {
        $gabungan[] = [
            'nama_ruang'    => '-',
            'nama_kegiatan' => 'Tidak ada jadwal aktif',
            'tanggal'       => date('d-m-Y'),
            'jam_mulai'     => '-',
            'jam_selesai'   => '-',
            'status'        => '-'
        ];
    }

    // Urutkan berdasarkan tanggal dan jam
    usort($gabungan, fn($a, $b) => strcmp($a['tanggal'], $b['tanggal']) ?: strcmp($a['jam_mulai'], $b['jam_mulai']));

    return view('jadwal/public_index', [
        'jadwal' => $gabungan,
        'filter' => $filter
    ]);
}
}
