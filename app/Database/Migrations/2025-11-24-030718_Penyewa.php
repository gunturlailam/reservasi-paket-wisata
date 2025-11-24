<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penyewa extends Migration
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
            'nama_penyewa'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'alamat'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'no_telp'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Buat Tabel
        $this->forge->createTable('penyewa', true);
    }

    public function down()
    {
        $this->forge->dropTable('penyewa', true);
    }
}
