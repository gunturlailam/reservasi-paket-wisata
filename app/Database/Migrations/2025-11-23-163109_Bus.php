<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bus extends Migration
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
            'nomor_polisi'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'merek'       => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'kapasitas'       => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
            ],
            'id_jenisbus'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_jenisbus', 'jenis_bus', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('bus', true);
    }

    public function down()
    {
        $this->forge->dropTable('bus', true);
    }
}
