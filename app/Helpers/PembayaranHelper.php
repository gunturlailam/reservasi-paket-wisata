<?php

if (!function_exists('formatMetode')) {
    /**
     * Format metode pembayaran
     */
    function formatMetode($metode)
    {
        $metodeMap = [
            'Transfer' => 'Transfer Bank',
            'Kartu' => 'Kartu Kredit',
            'E-Wallet' => 'E-Wallet',
            'Tunai' => 'Tunai'
        ];
        return $metodeMap[$metode] ?? $metode;
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Format angka ke format Rupiah
     */
    function formatRupiah($value)
    {
        $num = (int)$value ?? 0;
        return number_format($num, 0, ',', '.');
    }
}

if (!function_exists('formatTanggal')) {
    /**
     * Format tanggal ke format Indonesia
     */
    function formatTanggal($tanggal)
    {
        if (!$tanggal) return '-';
        return date('d/m/Y', strtotime($tanggal));
    }
}
