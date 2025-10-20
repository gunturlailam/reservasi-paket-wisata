<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemberangkatan extends Migration
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
            'id_pemesanan' => [
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
            ],
            'id_sopir' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_kernet' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'tanggal_berangkat' => [
                'type' => 'DATE',
                'null' => true,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Tambahkan foreign key
        $this->forge->addForeignKey('id_sopir', 'karyawan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_kernet', 'karyawan', 'id', 'SET NULL', 'CASCADE');

        // Buat tabe (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('pemberangkatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemberangkatan', true);
    }
}