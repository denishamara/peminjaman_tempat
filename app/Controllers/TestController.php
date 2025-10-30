<?php
namespace App\Controllers;

use App\Models\UserModel;

class TestController extends BaseController
{
    public function insertUser()
    {
        $model = new UserModel();

        $data = [
            'username' => 'tesuser2',
            'password' => password_hash('tes123', PASSWORD_BCRYPT),
            'role' => 'peminjam'
        ];

        try {
            $id = $model->insert($data);
            echo "Insert berhasil, ID baru: $id";
        } catch (\Exception $e) {
            echo "Gagal insert: " . $e->getMessage();
        }
    }
}
