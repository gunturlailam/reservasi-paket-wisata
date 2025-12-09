<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = '';
    protected $primaryKey = 'id';

    public function findUserByCredential(string $identifier): ?array
    {
        $db = \Config\Database::connect();

        // 1. Cari di tabel karyawan
        try {
            $karyawan = $db->table('karyawan')
                ->select('id, nama_karyawan AS name, username, email, nohp, password')
                ->groupStart()
                ->where('username', $identifier)
                ->orWhere('email', $identifier)
                ->orWhere('nohp', $identifier)
                ->groupEnd()
                ->get()
                ->getRowArray();

            if ($karyawan) {
                return [
                    'id'       => $karyawan['id'],
                    'name'     => $karyawan['nama_karyawan'],
                    'email'    => $karyawan['email'] ?? null,
                    'phone'    => $karyawan['nohp'] ?? null,
                    'password' => $karyawan['password'] ?? null,
                    'role'     => 'karyawan',
                    'source'   => 'karyawan',
                ];
            }
        } catch (\Throwable $e) {
            log_message('error', 'User lookup failed (karyawan): {msg}', ['msg' => $e->getMessage()]);
        }

        // 2. Cari di tabel lain (mis. mst_penyewa)
        $tablesToTry = [
            'penyewa' => [
                'nameField' => 'nama_penyewa',
                'role'      => 'penyewa',
            ],
        ];

        foreach ($tablesToTry as $table => $meta) {
            try {
                $row = $db->table($table)
                    ->select('id, ' . $meta['nameField'] . ' AS name, username, email, nohp, password')
                    ->groupStart()
                    ->where('username', $identifier)
                    ->orWhere('email', $identifier)
                    ->orWhere('nohp', $identifier)
                    ->groupEnd()
                    ->get()
                    ->getRowArray();

                if ($row) {
                    return [
                        'id'       => $row['id'],
                        'name'     => $row['name'],
                        'email'    => $row['email'] ?? null,
                        'phone'    => $row['nohp'] ?? null,
                        'password' => $row['password'] ?? null,
                        'role'     => $meta['role'],
                        'source'   => $table,
                    ];
                }
            } catch (\Throwable $e) {
                log_message('error', 'User lookup failed (' . $table . '): {msg}', ['msg' => $e->getMessage()]);
            }
        }

        return null;
    }

    public function findUserByEmail(string $email): ?array
    {
        $db = \Config\Database::connect();

        // Cari di karyawan
        $karyawan = $db->table('karyawan')
            ->select('id, nama_karyawan AS name, email, nohp AS phone, password')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($karyawan) {
            $karyawan['role'] = 'karyawan';
            return $karyawan;
        }

        // Cari di penyewa
        $penyewa = $db->table('penyewa')
            ->select('id, nama_penyewa AS name, email, no_telp AS phone, password')
            ->where('email', $email)
            ->get()
            ->getRowArray();

        if ($penyewa) {
            $penyewa['role'] = 'penyewa';
            return $penyewa;
        }

        return null;
    }

    public function findKaryawanByEmail(string $email): ?array
    {
        // Karyawan biasa (bukan Admin atau Supir)
        $db = \Config\Database::connect();
        $row = $db->table('karyawan')
            ->select('karyawan.id, karyawan.nama_karyawan AS name, karyawan.email, karyawan.nohp AS phone, karyawan.password, karyawan.foto')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
            ->where('karyawan.email', $email)
            ->where('LOWER(jabatan.nama_jabatan) !=', 'admin')
            ->where('LOWER(jabatan.nama_jabatan) !=', 'supir')
            ->get()
            ->getRowArray();
        if ($row) $row['role'] = 'karyawan';
        return $row ?: null;
    }

    public function findPenyewaByEmail(string $email): ?array
    {
        $db = \Config\Database::connect();
        $row = $db->table('penyewa')
            ->select('id, nama_penyewa AS name, email, no_telp AS phone, password, foto')
            ->where('email', $email)
            ->get()
            ->getRowArray();
        if ($row) $row['role'] = 'penyewa';
        return $row ?: null;
    }

    public function findPemilikByEmail(string $email): ?array
    {
        $db = \Config\Database::connect();
        $row = $db->table('pemilik')
            ->select('id, nama_pemilik AS name, email, nohp AS phone, password, foto')
            ->where('email', $email)
            ->get()
            ->getRowArray();
        if ($row) $row['role'] = 'pemilik';
        return $row ?: null;
    }

    public function findSupirByEmail(string $email): ?array
    {
        // Supir adalah karyawan dengan nama_jabatan = "Sopir"
        $db = \Config\Database::connect();
        $row = $db->table('karyawan')
            ->select('karyawan.id, karyawan.nama_karyawan AS name, karyawan.email, karyawan.nohp AS phone, karyawan.password, karyawan.foto')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
            ->where('karyawan.email', $email)
            ->where('LOWER(jabatan.nama_jabatan)', 'sopir') // Case-insensitive match untuk "Sopir"
            ->get()
            ->getRowArray();
        if ($row) $row['role'] = 'supir';
        return $row ?: null;
    }

    public function findAdminByEmail(string $email): ?array
    {
        // Admin adalah karyawan dengan nama_jabatan = "Admin"
        $db = \Config\Database::connect();
        $row = $db->table('karyawan')
            ->select('karyawan.id, karyawan.nama_karyawan AS name, karyawan.email, karyawan.nohp AS phone, karyawan.password, karyawan.foto')
            ->join('jabatan', 'jabatan.id = karyawan.id_jabatan', 'left')
            ->where('karyawan.email', $email)
            ->where('LOWER(jabatan.nama_jabatan)', 'admin') // Case-insensitive match untuk "Admin"
            ->get()
            ->getRowArray();
        if ($row) $row['role'] = 'admin';
        return $row ?: null;
    }



    public function verifyPassword(?string $hashOrPlain, string $inputPassword): bool
    {
        if ($hashOrPlain === null || $hashOrPlain === '') {
            return false;
        }

        $info = password_get_info($hashOrPlain);

        if ($info['algo'] !== 0) {
            return password_verify($inputPassword, $hashOrPlain);
        }

        return hash_equals($hashOrPlain, $inputPassword);
    }
}
