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
if (!function_exists('hitung_performance')) {
    function hitung_performance($Realisasi, $Annual_Target): float {
        // Pastikan input dalam bentuk numerik
        $Realisasi = floatval($Realisasi);
        $Annual_Target = floatval($Annual_Target);

        if ($Annual_Target == 0) {
            return 0; // Hindari pembagian nol
        }

        $performance = 1 + (($Realisasi - $Annual_Target) / $Annual_Target);
        // Batasi performance antara 0 dan 1.05
        if ($performance <= 0) {
            return 0;
        } elseif ($performance >= 1.05) {
            return intval(round(1.05 * 100));
        } else {
            return intval(round($performance * 100));
        }
    }
}
if (!function_exists('hitung_weighted_performance')) {
    function hitung_weighted_performance(float $performance, float $bobot, float $total_bobot = 100): float {
        $bobot = floatval($bobot);
        $total_bobot = floatval($total_bobot);
        // performance sudah dalam bentuk persen (100), ubah ke 1.00 dulu
        $performance_decimal = $performance / 100;
        return $performance_decimal * 0.8 * ($bobot / $total_bobot);
    }
}