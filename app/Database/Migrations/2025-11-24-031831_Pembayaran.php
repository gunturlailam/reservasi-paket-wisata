<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
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
                'null' => false,
            ],
            'tanggal_bayar'       => [
                'type'       => 'DATE',
                'null'       => false,
            ],
            'jumlah_bayar' => [
                'type' => 'INT',
                'constraint' => '8',
                'null' => false,
            ],
            'metode_bayar'       => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_pemesanan', 'pemesanan', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('pembayaran', true);
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran', true);
    }
}
