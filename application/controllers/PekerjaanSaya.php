<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PekerjaanSaya extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['pekerjaan_saya']);
	}
	public function index()
	{
		$data['page_title'] = 'Pekerjaan Saya';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
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
