<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemesanan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal_pesan'       => [
                'type'       => 'DATE',
                'null'       => false,
            ],
            'id_penyewa'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false,
            ],
            'id_paketbus'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false,
            ],
            'total_bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_paketbus', 'paket_bus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_penyewa', 'penyewa', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('pemesanan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan', true);
    }
}
