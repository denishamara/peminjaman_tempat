<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogBookingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // gunakan TIMESTAMP dengan DEFAULT CURRENT_TIMESTAMP agar kompatibel
            'waktu_log' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'aksi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'id_booking' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_room' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_log');
        $this->forge->createTable('log_booking');

        // Catatan: jika server MySQL/MariaDB lama yang tidak menerima default pada DATETIME,
        // penggunaan TIMESTAMP di atas biasanya kompatibel.
    }

    public function down()
    {
        $this->forge->dropTable('log_booking');
    }
}