<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBuktiBayarToPembayaran extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pembayaran', [
            'bukti_bayar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'metode_bayar',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pembayaran', 'bukti_bayar');
    }
}
