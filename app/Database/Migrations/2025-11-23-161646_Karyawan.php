<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
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
            'nama_karyawan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'alamat'       => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => false,
            ],
            'nohp'       => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
            ],
            'id_jabatan'       => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null' => false,
            ],
        ]);

        // Tambah primary key
        $this->forge->addKey('id', true);

        // Tambah foreign key
        $this->forge->addForeignKey('id_jabatan', 'jabatan', 'id', 'CASCADE', 'CASCADE');

        // Buat Tabel
        $this->forge->createTable('karyawan', true);
    }

    public function down()
    {
        $this->forge->dropTable('karyawan', true);
    }
}
