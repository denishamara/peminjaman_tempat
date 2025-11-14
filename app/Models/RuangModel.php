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
                WHEN b.id_booking IS NOT NULL THEN 'Tidak Tersedia'
                WHEN j.id_reguler IS NOT NULL THEN 'Terpakai (Reguler)'
                ELSE 'Tersedia'
            END AS status
        ");

        // Join booking aktif
        $builder->join(
            'booking b', 
            "b.id_room = r.id_room AND b.status != 'Selesai' AND b.tanggal_selesai >= '$today'", 
            'left'
        );

        // Join jadwal reguler aktif
        $builder->join(
            'jadwal_reguler j', 
            "j.id_room = r.id_room AND j.tanggal_selesai >= '$today'", 
            'left'
        );

        $builder->groupBy('r.id_room');

        return $builder->get()->getResultArray();
    }
}
