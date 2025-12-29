<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyPembayaranTable extends Migration
{
    public function up()
    {
        // Ubah tanggal_bayar menjadi nullable
        $this->forge->modifyColumn('pembayaran', [
            'tanggal_bayar' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('pembayaran', [
            'tanggal_bayar' => [
                'type' => 'DATE',
                'null' => false,
            ],
        ]);
    }
}
