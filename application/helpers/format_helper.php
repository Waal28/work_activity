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
if (!function_exists('hitung_performance_objective')) {
    function hitung_performance_objective(float $realisasi, float $target_total): float
    {
        $raw_performance = 1 + (($realisasi - $target_total) / $target_total);
        if ($raw_performance <= 0) {
            $performance = 0;
        } elseif ($raw_performance >= 1.05) {
            $performance = 1.05;
        } else {
            $performance = $raw_performance;
        }

        $performance_percent = round($performance * 100, 2); // misal: 105.00
        return $performance_percent;
    }
}

if (!function_exists('hitung_weighted_performance')) {
    function hitung_weighted_performance(float $performance, float $bobot, float $total_bobot = 100, float $performance_weight_factor = 0.8): float
    {
        if ($total_bobot == 0) return 0.0;

        return round($performance * $performance_weight_factor * ($bobot / $total_bobot), 2);
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

if (!function_exists('upload_file')) {
    function upload_file($field_name, $redirect_url = 'hseobjective')
    {
        $CI = &get_instance(); // akses CI instance
        $CI->load->library('upload');
        $CI->load->library('session');

        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload($field_name)) {
            $error = $CI->upload->display_errors('', '');

            // Translasi pesan error ke bahasa Indonesia
            $translations = [
                'The filetype you are attempting to upload is not allowed.' => 'Tipe file yang diunggah tidak diizinkan.',
                'The file you are attempting to upload is larger than the permitted size.' => 'Ukuran file terlalu besar. Maksimal 2MB.',
                'You did not select a file to upload.' => 'Silakan pilih file untuk diunggah.',
            ];

            foreach ($translations as $en => $id) {
                $error = str_replace($en, $id, $error);
            }

            $CI->session->set_flashdata('toast', [
                'message' => $error,
                'type'    => 'danger'
            ]);
            redirect($redirect_url);
        }

        $upload_data = $CI->upload->data();
        return $upload_data['file_name'];
    }
}
