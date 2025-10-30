<?php namespace App\Models;
use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $table = 'room';
    protected $primaryKey = 'id_room';
    protected $allowedFields = ['nama_room', 'lokasi', 'deskripsi', 'kapasitas'];
}
