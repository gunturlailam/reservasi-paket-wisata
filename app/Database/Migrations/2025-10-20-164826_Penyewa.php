<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penyewa extends Migration
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
            'nama_penyewa' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'no_telp' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ]

        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Buat tabel
        $this->forge->createTable('penyewa', true);
    }

    public function down()
    {
        $this->forge->dropTable('penyewa', true);
    }
}