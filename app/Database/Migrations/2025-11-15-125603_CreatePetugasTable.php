<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePetugasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_petugas' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_petugas' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_petugas');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('petugas');
    }

    public function down()
    {
        $this->forge->dropTable('petugas');
    }
}