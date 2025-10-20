<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisBus extends Migration
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
            'nama_jenisbus' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],

        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Buat tabel
        $this->forge->createTable('jenisbus', true);
    }

    public function down()
    {
        $this->forge->dropTable('jenisbus', true);
    }
}