<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatan extends Migration
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
            'nama_jabatan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ]
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Buat Tabel
        $this->forge->createTable('jabatan');
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
