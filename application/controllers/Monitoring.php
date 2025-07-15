<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');

		$this->load->model('Pekerjaan_model');
		$this->load->model('Reports_model');

		$this->load->helper('format');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['monitoring']);
	}
	public function index()
	{
		$data['page_title'] = 'Monitoring Pekerjaan';
		$data['content_view'] = 'monitoring/index';

		$current_user = $this->session->userdata('current_user');
		$role = $this->session->userdata('role');
		$is_dirut = $role == 'Direktur Utama';

		if ($is_dirut) {
			$data['rows_reports'] = $this->Reports_model->get_reports($current_user['id_pegawai']);
		}

		$payload_pekerjaan = ['created_id' => $current_user['user_id']];

		$original_data = $this->Pekerjaan_model->get_all($payload_pekerjaan);
		$mapped = [];

		foreach ($original_data as $row) {
			$id = $row['pekerjaan_id'];

			if (!isset($mapped[$id])) {
				$mapped[$id] = $row;
				$mapped[$id]['id_pegawai'] = [];
				$mapped[$id]['nama_pegawai'] = [];
			}

			$mapped[$id]['id_pegawai'][] = $row['id_pegawai'];
			$mapped[$id]['nama_pegawai'][] = $row['nama'];
		}

		$data['rows'] = array_values($mapped); // Reset index
		$this->load->view('main', $data);
	}
	public function update_approval()
	{
		$pekerjaan_id = $this->input->post('pekerjaan_id');
		$data = [
			'hasil_kerja' => $this->input->post('hasil_kerja')
		];
		$this->Pekerjaan_model->update($pekerjaan_id, $data);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type'    => 'success' // success, danger, warning, info
		]);
		redirect('monitoring');
	}
}
