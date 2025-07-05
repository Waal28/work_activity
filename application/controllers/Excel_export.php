<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Excel_export extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('AuthMiddleware');
        $this->load->helper('format');

        $this->load->model('Hse_objective_model');
        $this->load->model('Community_envelopment_model');
        $this->load->model('Development_commitment_model');
        $this->load->model('Pegawai_model');
        $this->load->model('Reports_model');
    }

    public function generate()
    {
        $spreadsheet = new Spreadsheet();
        $current_user = $this->session->userdata('current_user');
        $reports = $this->Reports_model->get_reports($current_user['id_pegawai']);

        $role = $this->session->userdata('role');
        $payload = [];
        if ($role === 'Staf') {
            $payload = [
                'id_unit_level' => 'A11',
                'id_unit_kerja' => $current_user['id_unit_kerja']
            ];
        } else if ($role === 'Manager Unit') {
            $payload = [
                'id_unit_level' => 'A6',
                'id_unit_kerja' => $current_user['id_unit_kerja']
            ];
        } else if ($role === 'Vice President') {
            $payload = [
                'id_unit_level' => 'A6',
                'id_unit_kerja' => $current_user['id_unit_kerja']
            ];
        } else if ($role === 'Direktur Utama') {
            $payload = [
                'id_unit_level' => 'A6',
                'id_unit_kerja' => $current_user['id_unit_kerja']
            ];
        }
        $atasan_user_list = $this->Pegawai_model->get_pegawai($payload);
        $atasan_user = !empty($atasan_user_list) ? $atasan_user_list[0] : [
            'nama' => '-',
            'nm_unit_level' => '-',
            'nm_unit_kerja' => '-'
        ];

        // Data employee (bisa diambil dari database)
        $employeeData = [
            'nama' => $current_user['nama'],
            'no_pegawai' => !empty($current_user['nik']) ? $current_user['nik'] : '-',
            'unit_bisnis' => !empty($current_user['nm_unit_bisnis']) ? $current_user['nm_unit_bisnis'] : '-',
            'fungsi' => !empty($current_user['nm_unit_kerja']) ? $current_user['nm_unit_kerja'] : '-',
            'jabatan' => !empty($current_user['nm_unit_level']) ? $current_user['nm_unit_level'] : '-',
            'periode' => 'Tahunan / 2025',
        ];

        // Sheet 1 - Development Commitment Form
        $this->createIndividual_goal_setting($spreadsheet, $reports, $employeeData, $atasan_user);

        // Sheet 2 - Development Commitment Form
        $this->createDevelopmentCommitmentSheet($spreadsheet, $employeeData, $atasan_user);

        // Sheet 3 - Community Involvement Form
        $this->createCommunityInvolvementSheet($spreadsheet, $employeeData, $atasan_user);

        // Sheet 4 - HSSE Participation Form
        $this->createHSSEParticipationSheet($spreadsheet, $employeeData, $atasan_user);

        // Set active sheet kembali ke sheet 1
        $spreadsheet->setActiveSheetIndex(0);

        // Output ke browser
        $filename = 'Rekapitulasi_' . str_replace(' ', '_', $employeeData['nama']) . '_2025.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    private function createIndividual_goal_setting($spreadsheet, $reports, $employeeData, $atasan_user)
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Individual Goal Setting');

        // Set page orientation and margins
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(0.5);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(45);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(8);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);

        // Set row heights
        for ($i = 1; $i <= 20; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(25);
        }

        // Header row
        $sheet->setCellValue('A1', 'Aspek');
        $sheet->setCellValue('B1', 'KPI');
        $sheet->setCellValue('C1', 'Freq. Mon');
        $sheet->setCellValue('D1', 'Bobot');
        $sheet->setCellValue('E1', 'Satuan');
        $sheet->setCellValue('F1', 'Annual Target');
        $sheet->setCellValue('G1', 'Target Semester I');
        $sheet->setCellValue('H1', 'Target Semester II');
        $sheet->setCellValue('I1', 'Realisasi');
        $sheet->setCellValue('J1', 'Target Performance 2023');
        $sheet->setCellValue('K1', 'Weighted Performance');

        // Style header row
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF8BC34A'] // Green color
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ];

        $sheet->getStyle('A1:K1')->applyFromArray($headerStyle);

        // Cascading KPI Functions section
        $sheet->setCellValue('A2', 'Cascading KPI Fungsi');

        // Style the merged cell
        $cascadingStyle = [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'textRotation' => 90
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF2196F3'] // Blue color
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ];

        // KPI data from database
        $row = 2;
        $total_bobot_kpi = 0;
        $weighted_performance_obj = 0;
        $weighted_performance_kpi = 0;

        if (!empty($reports['pekerjaan'])) {
            $kpiCount = count($reports['pekerjaan']);
            $sheet->mergeCells('A2:A' . ($row + $kpiCount - 1));

            foreach ($reports['pekerjaan'] as $item) {
                $total_bobot_kpi += $item['bobot'];
            }

            foreach ($reports['pekerjaan'] as $pekerjaan) {
                $realisasi = $pekerjaan['target_semester_1'] + $pekerjaan['target_semester_2'];
                $performance = hitung_performance($realisasi, $pekerjaan['annual_target']);
                $weighted_performance = hitung_weighted_performance($performance, $pekerjaan['bobot'], $total_bobot_kpi);
                $weighted_performance_kpi += $weighted_performance;

                $sheet->setCellValue('B' . $row, $pekerjaan['judul']);
                $sheet->setCellValue('C' . $row, $pekerjaan['freq_mon']);
                $sheet->setCellValue('D' . $row, formatAngka($pekerjaan['bobot']) . '%');
                $sheet->setCellValue('E' . $row, $pekerjaan['satuan']);
                $sheet->setCellValue('F' . $row, formatAngka($pekerjaan['annual_target']) . '%');
                $sheet->setCellValue('G' . $row, formatAngka($pekerjaan['target_semester_1']) . '%');
                $sheet->setCellValue('H' . $row, formatAngka($pekerjaan['target_semester_2']) . '%');
                $sheet->setCellValue('I' . $row, $realisasi . '%');
                $sheet->setCellValue('J' . $row, number_format($performance, 2) . '%');
                $sheet->setCellValue('K' . $row, number_format($weighted_performance, 2) . '%');
                $row++;
            }
        }

        // Style KPI data rows
        $dataStyle = [
            'font' => [
                'size' => 9
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ];

        // Define hsseStyle for objectives
        $hsseStyle = [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['argb' => 'FFFFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FF2196F3'] // Blue color
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ];

        $kpiEndRow = $row - 1;
        $sheet->getStyle('B2:K' . $kpiEndRow)->applyFromArray($dataStyle);

        // Style KPI description column (left aligned)
        $sheet->getStyle('B2:B' . $kpiEndRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Apply cascading style to merged cells
        $sheet->getStyle('A2:A' . $kpiEndRow)->applyFromArray($cascadingStyle);

        // Objectives sections (HSSE, Development, Community)
        $objectivesStartRow = $row;
        $total_bobot_obj = 0;

        if (!empty($reports['objectives'])) {
            foreach ($reports['objectives'] as $item) {
                $total_bobot_obj += $item['bobot'];
            }

            foreach ($reports['objectives'] as $objective) {
                // Calculate realization based on objective type
                $total_bobot_obj += $objective['bobot'];

                $realisasi = $objective['target_semester_1'] + $objective['target_semester_2'];
                $performance = $objective['hse_point'] + $objective['dev_point'] + $objective['community_point'];
                $weighted_performance = hitung_weighted_performance($performance, $objective['bobot'], $total_bobot_obj);
                $weighted_performance_obj += $weighted_performance;

                $sheet->setCellValue('A' . $row, $objective['nama_objective']);
                $sheet->setCellValue('B' . $row, $objective['deskripsi']);
                $sheet->setCellValue('C' . $row, $objective['freq_mon']);
                $sheet->setCellValue('D' . $row, formatAngka($objective['bobot']) . '%');
                $sheet->setCellValue('E' . $row, $objective['satuan']);
                $sheet->setCellValue('F' . $row, formatAngka($objective['annual_target']) . '%');
                $sheet->setCellValue('G' . $row, formatAngka($objective['target_semester_1']) . '%');
                $sheet->setCellValue('H' . $row, formatAngka($objective['target_semester_2']) . '%');
                $sheet->setCellValue('I' . $row, $realisasi . '%');
                $sheet->setCellValue('J' . $row, number_format($performance, 2) . '%');
                $sheet->setCellValue('K' . $row, number_format($weighted_performance, 2) . '%');

                $row++;
            }
        }

        // Style objectives data rows
        $objectivesEndRow = $row - 1;
        $sheet->getStyle('A' . $objectivesStartRow . ':K' . $objectivesEndRow)->applyFromArray($dataStyle);
        $sheet->getStyle('A' . $objectivesStartRow . ':A' . $objectivesEndRow)->applyFromArray($hsseStyle);
        $sheet->getStyle('B' . $objectivesStartRow . ':B' . $objectivesEndRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Total performance cell
        $totalWeightedPerformance = $weighted_performance_obj + $weighted_performance_kpi;
        $sheet->setCellValue('K' . $row, number_format($totalWeightedPerformance, 2) . '%');
        $sheet->getStyle('K' . $row)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000']
                ]
            ]
        ]);

        // Get current user name for signature
        $currentDate = date('d F Y');
        $currentLocation = 'Pangkalpinang'; // You can make this dynamic if needed

        // Signature section (adjust row numbers based on data)
        $signatureRow = $row + 4;
        $sheet->setCellValue('B' . $signatureRow, $currentLocation . ', ' . $currentDate);
        $sheet->setCellValue('B' . ($signatureRow + 1), $atasan_user['nm_unit_level']);
        $sheet->setCellValue('B' . ($signatureRow + 4), $atasan_user['nama']);

        $sheet->setCellValue('I' . ($signatureRow + 1), $employeeData['jabatan']);
        $sheet->setCellValue('I' . ($signatureRow + 4), $employeeData['nama']); // You can get this from database if available

        // Style signature section
        $signatureStyle = [
            'font' => [
                'size' => 10
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        $sheet->getStyle('B' . $signatureRow . ':B' . ($signatureRow + 4))->applyFromArray($signatureStyle);
        $sheet->getStyle('I' . ($signatureRow + 1) . ':I' . ($signatureRow + 4))->applyFromArray($signatureStyle);

        // Make name cells bold
        $sheet->getStyle('B' . ($signatureRow + 4))->getFont()->setBold(true);
        $sheet->getStyle('I' . ($signatureRow + 4))->getFont()->setBold(true);
    }

    private function createDevelopmentCommitmentSheet($spreadsheet, $employeeData, $atasan_user)
    {
        $current_user = $this->session->userdata('current_user');
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Development Commitment');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(30);

        // Header dengan logo area
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'Development Commitment Form');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Logo area (F1)
        // $sheet->setCellValue('F1', 'IHC\nPT Bakti Timah Medika');
        $sheet->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F1')->getAlignment()->setWrapText(true);

        // Employee info table
        $sheet->setCellValue('A3', 'Nama');
        $sheet->setCellValue('B3', ': ' . $employeeData['nama']);
        $sheet->setCellValue('D3', 'No. Pegawai');
        $sheet->setCellValue('E3', ': ' . $employeeData['no_pegawai']);

        $sheet->setCellValue('A4', 'Unit Bisnis');
        $sheet->setCellValue('B4', ': ' . $employeeData['unit_bisnis']);
        $sheet->setCellValue('D4', 'Fungsi');
        $sheet->setCellValue('E4', ': ' . $employeeData['fungsi']);

        $sheet->setCellValue('A5', 'Jabatan');
        $sheet->setCellValue('B5', ': ' . $employeeData['jabatan']);
        $sheet->setCellValue('D5', 'periode');
        $sheet->setCellValue('E5', ': ' . 'Tahunan / 2025');

        // Apply borders to employee info
        $this->applyBorders($sheet, 'A3:F5');

        // Instructions
        $sheet->setCellValue('A7', '* Masukkan tanggal pelaksanaan kegiatan, atau jika sifatnya penugasan dengan dasar Surat perintah, surat penugasan dll, bisa dituliskan tanggal diterbitkannya Surat Perintah / penugasan tersebut');
        $sheet->getStyle('A7')->getFont()->setSize(8);
        $sheet->getStyle('A7')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('A7:F7');
        $sheet->getRowDimension(7)->setRowHeight(25);

        // Table headers
        $headers = ['No', 'Aktivitas', 'LH', 'Tanggal Pelaksanaan', 'Lokasi', 'Keterangan'];
        $row = 9;
        for ($col = 0; $col < count($headers); $col++) {
            $sheet->setCellValueByColumnAndRow($col + 1, $row, $headers[$col]);
        }

        // Style headers
        $sheet->getStyle('A9:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $sheet->getStyle('A9:F9')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'))->setBold(true);
        $sheet->getStyle('A9:F9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Sample data
        $rowsData = $this->Development_commitment_model->get_development_by_pegawai($current_user['id_pegawai']);
        $data = [];
        foreach ($rowsData as $index => $row) {
            $data[] = [
                $index + 1,
                $row['aktivitas'],
                !empty($row['lh']) ? $row['lh'] : 0,
                formatTanggalIndo($row['tanggal_pelaksanaan']),
                $row['lokasi'],
                $row['keterangan']
            ];
        }

        // Fill data
        $currentRow = 10;
        foreach ($data as $rowData) {
            for ($col = 0; $col < count($rowData); $col++) {
                $sheet->setCellValueByColumnAndRow($col + 1, $currentRow, $rowData[$col]);
            }
            $currentRow++;
        }

        // Add empty rows for future entries
        for ($i = $currentRow; $i < $currentRow + 5; $i++) {
            for ($col = 1; $col <= 6; $col++) {
                $sheet->setCellValueByColumnAndRow($col, $i, '');
            }
        }

        // Total row
        $totalRow = $currentRow + 5;
        $sheet->setCellValue('A' . $totalRow, 'Akumulasi Point');
        $sheet->setCellValue('C' . $totalRow, '=SUM(C9:C' . ($totalRow - 1) . ')');
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');

        // Apply borders to data table
        $this->applyBorders($sheet, 'A9:F' . $totalRow);

        // Footer notes
        $sheet->setCellValue('A' . ($totalRow + 2), '** Masukkan lokasi pelaksanaan kegiatan (bisa berupa lokasi kegiatan atau fungsi, jika sifatnya penugasan)');
        $sheet->setCellValue('A' . ($totalRow + 3), '*** Tuliskan detail aktivitas Development yang dilakukan (misalnya judul training, penyelenggara, coach dan tema coaching, judul e-learning, dll)');
        $sheet->getStyle('A' . ($totalRow + 2))->getFont()->setSize(8);
        $sheet->getStyle('A' . ($totalRow + 3))->getFont()->setSize(8);

        // Signature section
        $signatureRow = $totalRow + 5;
        $sheet->setCellValue('A' . $signatureRow, 'Dengan ini menyatakan bahwa yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan.');
        $sheet->mergeCells('A' . $signatureRow . ':F' . $signatureRow);

        $sheet->setCellValue('E' . ($signatureRow + 2), 'Mengetahui');
        $sheet->setCellValue('A' . ($signatureRow + 3), 'Pangkalpinang, ' . formatTanggalIndo(date('Y-m-d')));
        $sheet->setCellValue('E' . ($signatureRow + 3), $atasan_user['nm_unit_level'] . ' ' . $atasan_user['nm_unit_kerja']);

        $sheet->setCellValue('A' . ($signatureRow + 7), $employeeData['nama']);
        $sheet->setCellValue('E' . ($signatureRow + 7), $atasan_user['nama']);
    }

    private function createCommunityInvolvementSheet($spreadsheet, $employeeData, $atasan_user)
    {
        $current_user = $this->session->userdata('current_user');
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('Community Involvement');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);

        // Header
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Community Involvement Form');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Logo area
        // $sheet->setCellValue('E1', 'IHC\nPT Bakti Timah Medika');
        $sheet->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E1')->getAlignment()->setWrapText(true);

        // Employee info
        $sheet->setCellValue('A3', 'Nama');
        $sheet->setCellValue('B3', ': ' . $employeeData['nama']);
        $sheet->setCellValue('D3', 'No. Pegawai');
        $sheet->setCellValue('E3', ': ' . $employeeData['no_pegawai']);

        $sheet->setCellValue('A4', 'Unit Bisnis');
        $sheet->setCellValue('B4', ': ' . $employeeData['unit_bisnis']);
        $sheet->setCellValue('D4', 'Fungsi');
        $sheet->setCellValue('E4', ': ' . $employeeData['fungsi']);

        $sheet->setCellValue('A5', 'Jabatan');
        $sheet->setCellValue('B5', ': ' . $employeeData['jabatan']);
        $sheet->setCellValue('D5', 'periode');
        $sheet->setCellValue('E5', ': ' . 'Tahunan / 2025');

        $this->applyBorders($sheet, 'A3:E5');

        // Table headers
        $headers = ['No', 'Aktivitas', 'Point', 'Tanggal Pelaksanaan', 'Lokasi'];
        $row = 7;
        for ($col = 0; $col < count($headers); $col++) {
            $sheet->setCellValueByColumnAndRow($col + 1, $row, $headers[$col]);
        }

        // Style headers
        $sheet->getStyle('A7:E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $sheet->getStyle('A7:E7')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'))->setBold(true);
        $sheet->getStyle('A7:E7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Sample data
        $rowsData = $this->Community_envelopment_model->get_community_by_pegawai($current_user['id_pegawai']);
        $data = [];
        foreach ($rowsData as $index => $row) {
            $data[] = [
                $index + 1,
                $row['aktivitas'],
                !empty($row['point']) ? $row['point'] : 0,
                formatTanggalIndo($row['tanggal_pelaksanaan']),
                $row['lokasi'],
            ];
        }

        // Fill data
        $currentRow = 8;
        foreach ($data as $rowData) {
            for ($col = 0; $col < count($rowData); $col++) {
                $sheet->setCellValueByColumnAndRow($col + 1, $currentRow, $rowData[$col]);
            }
            $currentRow++;
        }

        // Total row
        $totalRow = $currentRow + 2;
        $sheet->setCellValue('A' . $totalRow, 'Akumulasi Point');
        $sheet->setCellValue('C' . $totalRow, '=SUM(C7:C' . ($currentRow - 1) . ')');
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');

        // Apply borders
        $this->applyBorders($sheet, 'A7:E' . $totalRow);

        // Footer notes
        $sheet->setCellValue('A' . ($totalRow + 2), '* Masukkan lokasi pelaksanaan kegiatan');
        $sheet->setCellValue('A' . ($totalRow + 3), '** Tuliskan detail aktivitas Community Involvement yang dilakukan (misalnya nama organisasi, judul kegiatan, nama organisasi profesional yang diikuti, dll)');
        $sheet->getStyle('A' . ($totalRow + 2))->getFont()->setSize(8);
        $sheet->getStyle('A' . ($totalRow + 3))->getFont()->setSize(8);

        // Signature section
        $signatureRow = $totalRow + 5;
        $sheet->setCellValue('A' . $signatureRow, 'Dengan ini menyatakan bahwa yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan');
        $sheet->mergeCells('A' . $signatureRow . ':E' . $signatureRow);

        $sheet->setCellValue('D' . ($signatureRow + 2), 'Mengetahui');
        $sheet->setCellValue('A' . ($signatureRow + 3), 'Pangkalpinang, ' . formatTanggalIndo(date('Y-m-d')));
        $sheet->setCellValue('D' . ($signatureRow + 3), $atasan_user['nm_unit_level'] . ' ' . $atasan_user['nm_unit_kerja']);

        $sheet->setCellValue('A' . ($signatureRow + 7), $employeeData['nama']);
        $sheet->setCellValue('D' . ($signatureRow + 7), $atasan_user['nama']);
    }

    private function createHSSEParticipationSheet($spreadsheet, $employeeData, $atasan_user)
    {
        $current_user = $this->session->userdata('current_user');
        $sheet = $spreadsheet->createSheet();
        $sheet->setTitle('HSSE Participation');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(8);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(30);

        // Header
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'HSSE Participation Form');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Logo area
        // $sheet->setCellValue('F1', 'IHC\nPT Bakti Timah Medika');
        $sheet->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F1')->getAlignment()->setWrapText(true);

        // Employee info
        $sheet->setCellValue('A3', 'Nama');
        $sheet->setCellValue('B3', ': ' . $employeeData['nama']);
        $sheet->setCellValue('D3', 'No. Pegawai');
        $sheet->setCellValue('E3', ': ' . $employeeData['no_pegawai']);

        $sheet->setCellValue('A4', 'Unit Bisnis');
        $sheet->setCellValue('B4', ': ' . $employeeData['unit_bisnis']);
        $sheet->setCellValue('D4', 'Fungsi');
        $sheet->setCellValue('E4', ': ' . $employeeData['fungsi']);

        $sheet->setCellValue('A5', 'Jabatan');
        $sheet->setCellValue('B5', ': ' . $employeeData['jabatan']);
        $sheet->setCellValue('D5', 'periode');
        $sheet->setCellValue('E5', ': ' . 'Tahunan / 2025');

        $this->applyBorders($sheet, 'A3:F5');

        // Instructions
        $sheet->setCellValue('A7', '* Masukkan tanggal pelaksanaan kegiatan, atau jika sifatnya penugasan dengan dasar Surat perintah, surat penugasan dll, bisa dituliskan tanggal diterbitkannya Surat Perintah / penugasan tersebut');
        $sheet->getStyle('A7')->getFont()->setSize(8);
        $sheet->getStyle('A7')->getAlignment()->setWrapText(true);
        $sheet->mergeCells('A7:F7');
        $sheet->getRowDimension(7)->setRowHeight(25);

        // Table headers
        $headers = ['No', 'Aktivitas', 'Point', 'Tanggal Pelaksanaan', 'Lokasi', 'Keterangan'];
        $row = 9;
        for ($col = 0; $col < count($headers); $col++) {
            $sheet->setCellValueByColumnAndRow($col + 1, $row, $headers[$col]);
        }

        // Style headers
        $sheet->getStyle('A9:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4472C4');
        $sheet->getStyle('A9:F9')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'))->setBold(true);
        $sheet->getStyle('A9:F9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Sample data
        $rowsData = $this->Hse_objective_model->get_hse_by_pegawai($current_user['id_pegawai']);
        $data = [];
        foreach ($rowsData as $index => $row) {
            $data[] = [
                $index + 1,
                $row['aktivitas'],
                !empty($row['point']) ? $row['point'] : 0,
                formatTanggalIndo($row['tanggal_pelaksanaan']),
                $row['lokasi'],
                $row['keterangan']
            ];
        }

        // Fill data
        $currentRow = 10;
        foreach ($data as $rowData) {
            for ($col = 0; $col < count($rowData); $col++) {
                $sheet->setCellValueByColumnAndRow($col + 1, $currentRow, $rowData[$col]);
            }
            $currentRow++;
        }

        // Add empty rows
        for ($i = $currentRow; $i < $currentRow + 10; $i++) {
            for ($col = 1; $col <= 6; $col++) {
                $sheet->setCellValueByColumnAndRow($col, $i, '');
            }
        }

        // Total row
        $totalRow = $currentRow + 10;
        $sheet->setCellValue('A' . $totalRow, 'Akumulasi Point');
        $sheet->setCellValue('C' . $totalRow, '=SUM(C9:C' . ($totalRow - 1) . ')');
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRow . ':C' . $totalRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');

        // Apply borders
        $this->applyBorders($sheet, 'A9:F' . $totalRow);

        // Footer notes
        $sheet->setCellValue('A' . ($totalRow + 2), '** Masukkan lokasi pelaksanaan kegiatan (bisa berupa lokasi kegiatan atau fungsi, jika sifatnya penugasan)');
        $sheet->setCellValue('A' . ($totalRow + 3), '*** Tuliskan detail aktivitas Development yang dilakukan (misalnya judul training, penyelenggara, coach dan tema coaching, judul e-learning, dll)');
        $sheet->getStyle('A' . ($totalRow + 2))->getFont()->setSize(8);
        $sheet->getStyle('A' . ($totalRow + 3))->getFont()->setSize(8);

        // Signature section
        $signatureRow = $totalRow + 5;
        $sheet->setCellValue('A' . $signatureRow, 'Dengan ini menyatakan bahwa yang saya sampaikan adalah benar dan dapat dipertanggungjawabkan.');
        $sheet->mergeCells('A' . $signatureRow . ':F' . $signatureRow);

        $sheet->setCellValue('E' . ($signatureRow + 2), 'Mengetahui');
        $sheet->setCellValue('A' . ($signatureRow + 3), 'Pangkalpinang, ' . formatTanggalIndo(date('Y-m-d')));
        $sheet->setCellValue('E' . ($signatureRow + 3), $atasan_user['nm_unit_level'] . ' ' . $atasan_user['nm_unit_kerja']);

        $sheet->setCellValue('A' . ($signatureRow + 7), $employeeData['nama']);
        $sheet->setCellValue('E' . ($signatureRow + 7), $atasan_user['nama']);
    }

    private function applyBorders($sheet, $range)
    {
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
