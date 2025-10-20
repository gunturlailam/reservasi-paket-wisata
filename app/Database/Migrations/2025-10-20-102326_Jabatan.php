<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatan extends Migration
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
            'namajabatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);

        // Buat tabel
        $this->forge->createTable('jabatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('jabatan', true);
    }
}