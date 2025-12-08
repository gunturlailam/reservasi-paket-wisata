<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoPasswordColumns extends Migration
{
    public function up()
    {
        // Tambah kolom foto dan password ke tabel karyawan
        $fieldsKaryawan = [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'nohp'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'foto'
            ]
        ];

        try {
            $this->forge->addColumn('karyawan', $fieldsKaryawan);
        } catch (\Exception $e) {
            // Kolom mungkin sudah ada, skip
            log_message('info', 'Kolom karyawan mungkin sudah ada: ' . $e->getMessage());
        }

        // Tambah kolom foto dan password ke tabel penyewa
        $fieldsPenyewa = [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'email'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'foto'
            ]
        ];

        try {
            $this->forge->addColumn('penyewa', $fieldsPenyewa);
        } catch (\Exception $e) {
            // Kolom mungkin sudah ada, skip
            log_message('info', 'Kolom penyewa mungkin sudah ada: ' . $e->getMessage());
        }
    }

    public function down()
    {
        // Hapus kolom dari karyawan
        try {
            $this->forge->dropColumn('karyawan', ['password', 'foto']);
        } catch (\Exception $e) {
            log_message('info', 'Error dropping karyawan columns: ' . $e->getMessage());
        }

        // Hapus kolom dari penyewa
        try {
            $this->forge->dropColumn('penyewa', ['password', 'foto']);
        } catch (\Exception $e) {
            log_message('info', 'Error dropping penyewa columns: ' . $e->getMessage());
        }
    }
}
