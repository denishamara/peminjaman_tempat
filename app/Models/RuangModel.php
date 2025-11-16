<?php 

namespace App\Models;

use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $table = 'room';
    protected $primaryKey = 'id_room';
    protected $allowedFields = ['nama_room', 'lokasi', 'deskripsi', 'kapasitas'];

    /**
     * Ambil daftar ruang beserta status (booking / reguler / tersedia)
     */
    public function getRuangWithStatus()
{
    $today = date('Y-m-d H:i:s');

    $builder = $this->db->table('room r');

    $builder->select("
        r.*,
        CASE
            WHEN EXISTS (
                SELECT 1 FROM booking b 
                WHERE b.id_room = r.id_room 
                AND b.status != 'Selesai' 
                AND b.status != 'Dibatalkan'
                AND b.tanggal_selesai >= '$today'
            ) THEN 'Tidak Tersedia'
            WHEN EXISTS (
                SELECT 1 FROM jadwal_reguler j 
                WHERE j.id_room = r.id_room 
                AND j.tanggal_selesai >= '$today'
            ) THEN 'Terpakai (Reguler)'
            ELSE 'Tersedia'
        END AS status
    ");

    return $builder->get()->getResultArray();
}
}
