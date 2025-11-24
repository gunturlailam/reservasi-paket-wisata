<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Paketwisata extends Migration
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
            'nama_paket'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'tujuan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Buat Tabel
        $this->forge->createTable('paket_wisata', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket_wisata', true);
    }
}
