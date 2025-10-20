<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
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
            'nama_karyawan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'id_jabatan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);


        // Tambahkan foreign key
        $this->forge->addForeignKey('id_jabatan', 'jabatan', 'id', 'SET NULL', 'CASCADE');

        // Buat tabe (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('karyawan', true);
    }

    public function down()
    {
        $this->forge->dropTable('karyawan', true);
    }
}