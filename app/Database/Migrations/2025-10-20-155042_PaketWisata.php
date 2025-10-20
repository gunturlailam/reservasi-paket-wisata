<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaketWisata extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_paket' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tujuan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'harga' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],

        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);

        // Buat tabel
        $this->forge->createTable('paket_wisata', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket_wisata', true);
    }
}