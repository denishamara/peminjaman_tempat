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
    $query = $db->query("SELECT total_booking_user($id_user) AS total");
    return $query->getRow()->total;
}

}