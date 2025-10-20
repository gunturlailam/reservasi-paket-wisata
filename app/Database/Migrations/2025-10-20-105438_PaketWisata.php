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
                'constraint' => 20,
                'null' => true,
            ],
            'harga' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Buat tabel (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('paket_wisata', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('paket_wisata', true);
    }
}