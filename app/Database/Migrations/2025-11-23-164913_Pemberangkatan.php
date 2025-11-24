<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemberangkatan extends Migration
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
            'id_pemesanan'       => [
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
            'id_sopir'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_kernet'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tanggal_berangkat'       => [
                'type'       => 'DATE',
                'null'       => false,
            ],

        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_sopir', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kernet', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_bus', 'bus', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('pemberangkatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemberangkatan', true);
    }
}
