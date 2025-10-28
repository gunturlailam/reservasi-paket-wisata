<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PemesananDetail extends Migration
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
            'tanggal_berangkat' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tanggal_kembali' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jumlah_penumpang' => [
                'type' => 'DOUBLE',
                'null' => true,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Tambahkan foreign key
        $this->forge->addForeignKey('id_pemesanan', 'pemesanan', 'id', 'SET NULL', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('pemesanan_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan_detail', true);
    }
}