<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemilikTable extends Migration
{
    public function up()
    {
        // Tabel Pemilik
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_pemilik' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'nohp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pemilik', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemilik', true);
    }
}
