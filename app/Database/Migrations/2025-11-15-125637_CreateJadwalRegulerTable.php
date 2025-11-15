<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalRegulerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_reguler' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_reguler' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'id_room' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_reguler');
        $this->forge->addForeignKey('id_room', 'room', 'id_room', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal_reguler');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_reguler');
    }
}