<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemberianPekerjaan extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'Pemberian Pekerjaan';
    $data['content_view'] = 'pekerjaan/pemberian_pekerjaan';
		$rows = [
			[
					'nama_pekerjaan' => 'Audit Keuangan',
					'penerima' => 'Andika',
					'deadline' => '10 Februari 2025',
					'status' => 'In Progress'
			],
			[
					'nama_pekerjaan' => 'Evaluasi IT',
					'penerima' => 'Putri',
					'deadline' => '15 Februari 2025',
					'status' => 'Done'
			],
			[
					'nama_pekerjaan' => 'Audit Keuangan',
					'penerima' => 'Samsul',
					'deadline' => '20 Februari 2025',
					'status' => 'Pending'
			]
		];
		$data['rows'] = $rows;
		$this->load->view('main', $data);
	}
}
