<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemberangkatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idberangkat' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'idpemesanan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'idbus' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'idsopir' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'idkernet' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'tanggalberangkat' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        // Tambahkan primary key
        $this->forge->addKey('idberangkat', true);

        // Tambahkan index untuk kolom FK
        $this->forge->addKey('idpemesanan');
        $this->forge->addKey('idbus');
        $this->forge->addKey('idsopir');
        $this->forge->addKey('idkernet');

        // Tambahkan foreign key
        $this->forge->addForeignKey('idsopir', 'karyawan', 'idkaryawan', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('idkernet', 'karyawan', 'idkaryawan', 'SET NULL', 'CASCADE');

        // Buat tabel (pastikan InnoDB agar FK aktif)
        $this->forge->createTable('pemberangkatan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('pemberangkatan', true);
    }
}