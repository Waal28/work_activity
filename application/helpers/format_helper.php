<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('formatTanggalIndo')) {
    function formatTanggalIndo($tanggal)
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Parse tanggal seperti new Date() di JS
        $date = new DateTime($tanggal);
        $tahun = $date->format('Y');
        $bulanNum = $date->format('m');
        $hari = $date->format('d');

        return $hari . ' ' . $bulan[$bulanNum] . ' ' . $tahun;
    }
}
if (!function_exists('hitung_performance')) {
    function hitung_performance($Realisasi, $Annual_Target): float
    {
        $Realisasi = floatval($Realisasi);
        $Annual_Target = floatval($Annual_Target);

        // Cegah pembagian dengan nol
        if ($Annual_Target == 0) {
            return 0.0;
        }

        $performance = 1 + (($Realisasi - $Annual_Target) / $Annual_Target);

        // Batasi performance antara 0 dan 1.05 (105%)
        if ($performance <= 0) {
            return 0.0;
        } elseif ($performance >= 1.05) {
            return round(1.05 * 100, 2); // Boleh pakai float 2 desimal biar lebih akurat
        } else {
            return round($performance * 100, 2);
        }
    }
}

if (!function_exists('hitung_weighted_performance')) {
    function hitung_weighted_performance(float $performance, float $bobot, float $total_bobot = 100): float
    {
        $bobot = floatval($bobot);
        $total_bobot = floatval($total_bobot);

        // Cegah pembagian nol
        if ($total_bobot == 0) {
            return 0.0;
        }

        $performance_decimal = $performance / 100;
        return round($performance_decimal * 0.8 * ($bobot / $total_bobot), 4);
    }
}

if (!function_exists('formatAngka')) {
    function formatAngka($angka)
    {
        // Validasi: Pastikan angka numerik
        if (!is_numeric($angka)) {
            return 0;
        }

        // Ubah ke float agar menghapus trailing zero (contoh: 2.50 jadi 2.5)
        $angka = (float)$angka;

        // Jika bilangan bulat, tampilkan tanpa desimal
        return ($angka == floor($angka)) ? (int)$angka : $angka;
    }
}
