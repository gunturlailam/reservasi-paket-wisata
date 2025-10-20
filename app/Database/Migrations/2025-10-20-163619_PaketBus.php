<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaketBus extends Migration
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
            'id_paketwisata' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_bus' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Tambahkan foreign key
        $this->forge->addForeignKey('id_paketwisata', 'paket_wisata', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_bus', 'bus', 'id', 'SET NULL', 'CASCADE');

        // Buat tabe (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('paket_bus', true);
    }

    public function down()
    {
        $this->forge->dropTable('paket_bus', true);
    }
}