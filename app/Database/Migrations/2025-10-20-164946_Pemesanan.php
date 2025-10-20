<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemesanan extends Migration
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
            'tanggal_pesan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'id_penyewa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_paketbus' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'total_bayar' => [
                'type' => 'DOUBLE',
                'null' => true,
            ],

        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Tambahkan foreign key
        // $this->forge->addForeignKey('id_sopir', 'karyawan', 'id', 'SET NULL', 'CASCADE');
        // $this->forge->addForeignKey('id_kernet', 'karyawan', 'id', 'SET NULL', 'CASCADE');
        // $this->forge->addForeignKey('id_bus', 'bus', 'id', 'SET NULL', 'CASCADE');

        // Buat tabe (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('pemesanan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan', true);
    }
}