<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'password', 'telepon', 'role', 'foto']; // ✅ tambahkan foto
    protected $returnType = 'array';

    public function getTotalBooking($id_user)
{
    $db = \Config\Database::connect();
    // Ganti fungsi yang tidak ada dengan query COUNT langsung
    $query = $db->query("SELECT COUNT(*) AS total FROM booking WHERE id_user = ?", [$id_user]);
    $row = $query->getRow();
    return $row ? $row->total : 0;
}

}