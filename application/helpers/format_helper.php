<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('formatTanggalIndo')) {
    function formatTanggalIndo($tanggal) {
        $bulan = [
            '01' => 'Januari',   '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',     '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',      '08' => 'Agustus',  '09' => 'September',
            '10' => 'Oktober',   '11' => 'November', '12' => 'Desember'
        ];

        $parts = explode('-', $tanggal);
        return $parts[2] . ' ' . $bulan[$parts[1]] . ' ' . $parts[0];
    }
}
