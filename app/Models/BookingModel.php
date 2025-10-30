<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table         = 'booking';
    protected $primaryKey    = 'id_booking';
    protected $allowedFields = [
        'id_user',
        'id_petugas',
        'id_room',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan'
    ];

    protected $useTimestamps = false;

    /**
     * Mengecek apakah ada booking lain yang bentrok dengan waktu yang diajukan.
     * Abaikan booking yang sudah ditolak atau sudah selesai.
     */
    public function isTimeConflict(array $data): bool
    {
        return $this->where('id_room', $data['id_room'])
            ->groupStart()
                ->where('LOWER(status) !=', 'ditolak')
                ->where('LOWER(status) !=', 'selesai')
            ->groupEnd()
            ->groupStart()
                ->where('tanggal_selesai >', $data['tanggal_mulai'])
                ->where('tanggal_mulai <', $data['tanggal_selesai'])
            ->groupEnd()
            ->first() ? true : false;
    }

    /**
     * Update otomatis semua booking yang waktunya sudah lewat menjadi 'selesai'.
     * Hanya update jika status saat ini bukan 'selesai' atau 'ditolak'.
     */
    public function updateFinishedBookings(): void
    {
    date_default_timezone_set('Asia/Jakarta'); // Pastikan waktu lokal Indonesia
    $now = date('Y-m-d H:i:s');

    // Tes debugging
    // echo "Sekarang: $now"; exit;

    $this->set('status', 'Selesai')
        ->whereNotIn('status', ['Selesai', 'Ditolak'])
        ->where('tanggal_selesai <', $now)
        ->update();
    }
}
