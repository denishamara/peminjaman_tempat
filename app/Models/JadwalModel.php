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
     * Cek apakah jadwal bentrok dengan yang sudah ada
     *
     * @param array $data ['id_room', 'tanggal_mulai', 'tanggal_selesai']
     * @param int|null $ignoreId (dipakai saat edit jadwal agar tidak bentrok dengan dirinya sendiri)
     * @return bool True jika bentrok, false jika tidak
     */
    public function isTimeConflict(array $data, $ignoreId = null): bool
    {
        $builder = $this->where('id_room', $data['id_room'])
            ->groupStart()
                ->where('tanggal_selesai >', $data['tanggal_mulai'])
                ->where('tanggal_mulai <', $data['tanggal_selesai'])
            ->groupEnd();

        if ($ignoreId) {
            $builder->where($this->primaryKey . ' !=', $ignoreId);
        }

        return $builder->first() ? true : false;
    }

    /**
     * Ambil daftar jadwal reguler yang bentrok dengan waktu tertentu
     *
     * @param array $data ['id_room', 'tanggal_mulai', 'tanggal_selesai']
     * @return array daftar jadwal yang bentrok
     */
    public function getTimeConflicts($data)
    {
        $idRoom = $data['id_room'];
        $tanggalMulai = $data['tanggal_mulai'];
        $tanggalSelesai = $data['tanggal_selesai'];

        // Ambil semua jadwal reguler yang bentrok
        return $this->where('id_room', $idRoom)
            ->where("NOT (tanggal_selesai <= '$tanggalMulai' OR tanggal_mulai >= '$tanggalSelesai')")
            ->findAll();
    }
}
