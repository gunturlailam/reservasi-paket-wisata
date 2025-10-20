<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idkaryawan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'idjabatan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'namakaryawan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'nohp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('idkaryawan', true);


        // Tambahkan foreign key
        $this->forge->addForeignKey('idjabatan', 'jabatan', 'id', 'SET NULL', 'CASCADE');

        // Buat tabe (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('karyawan', true);
    }

    public function down()
    {
        $this->forge->dropTable('karyawan', true);
    }
}