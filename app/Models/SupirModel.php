<?php

namespace App\Models;

use CodeIgniter\Model;

class SupirModel extends Model
{
    protected $table            = 'supir';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_supir',
        'email',
        'password',
        'nohp',
        'alamat',
        'foto',
        'no_sim',
        'jenis_sim'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
}
