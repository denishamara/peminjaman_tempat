<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id_booking';
    protected $allowedFields = [
        'id_user',
        'id_petugas',
        'id_room',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan'
    ];

    // 🔹 Ambil semua peminjaman yang masih aktif (belum selesai / belum ditolak)
    public function getAktif()
    {
        return $this->select('booking.*, user.username, room.nama_room')
            ->join('user', 'user.id_user = booking.id_user', 'left')
            ->join('room', 'room.id_room = booking.id_room', 'left')
            ->whereNotIn('booking.status', ['Selesai', 'Ditolak'])
            ->orderBy('booking.tanggal_mulai', 'ASC')
            ->findAll();
    }

    // 🔹 Ambil semua peminjaman yang sudah selesai
    public function getHistory()
    {
        return $this->select('booking.*, user.username, room.nama_room')
            ->join('user', 'user.id_user = booking.id_user', 'left')
            ->join('room', 'room.id_room = booking.id_room', 'left')
            ->where('booking.status', 'Selesai')
            ->orderBy('booking.tanggal_selesai', 'DESC')
            ->findAll();
    }
}
