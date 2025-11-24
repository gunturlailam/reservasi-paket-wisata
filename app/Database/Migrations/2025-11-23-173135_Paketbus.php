<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Paketbus extends Migration
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
            'id_paketwisata'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_bus'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_paketwisata', 'paket_wisata', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_bus', 'bus', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('paket_bus', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket_bus', true);
    }
}
