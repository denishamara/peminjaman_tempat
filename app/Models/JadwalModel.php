<?php 

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table      = 'jadwal_reguler';
    protected $primaryKey = 'id_reguler';
    protected $allowedFields = [
        'nama_reguler', 
        'id_room', 
        'id_user', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'keterangan'
    ];

    /**
     * ✅ Cek apakah jadwal bentrok dengan yang sudah ada (jadwal aktif)
     *
     * @param array $data ['id_room', 'tanggal_mulai', 'tanggal_selesai']
     * @param int|null $ignoreId (untuk edit supaya tidak bentrok dengan dirinya sendiri)
     * @return bool True jika bentrok, false jika tidak
     */
    public function isTimeConflict(array $data, $ignoreId = null): bool
    {
        $builder = $this->where('id_room', $data['id_room'])
            // Hanya cek jadwal yang belum lewat
            ->where('tanggal_selesai >=', date('Y-m-d H:i:s'))
            ->groupStart()
                ->where('tanggal_mulai <', $data['tanggal_selesai'])
                ->where('tanggal_selesai >', $data['tanggal_mulai'])
            ->groupEnd();

        if (!is_null($ignoreId)) {
            $builder->where($this->primaryKey . ' !=', $ignoreId);
        }

        return (bool) $builder->first();
    }

    /**
     * ✅ Ambil semua jadwal reguler aktif yang bentrok dengan waktu tertentu
     *
     * @param array $data ['id_room', 'tanggal_mulai', 'tanggal_selesai']
     * @return array daftar jadwal yang bentrok
     */
    public function getTimeConflicts(array $data): array
    {
        return $this->where('id_room', $data['id_room'])
            // Hanya ambil jadwal yang masih aktif
            ->where('tanggal_selesai >=', date('Y-m-d H:i:s'))
            ->groupStart()
                ->where('tanggal_mulai <', $data['tanggal_selesai'])
                ->where('tanggal_selesai >', $data['tanggal_mulai'])
            ->groupEnd()
            ->findAll();
    }
}
