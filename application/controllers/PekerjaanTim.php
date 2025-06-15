<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PekerjaanTim extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
    $this->load->library('form_validation');
		
		$this->load->model('Pekerjaan_model');
    $this->load->model('Pegawai_model');

		$this->load->helper('format');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['pekerjaan_tim']);
	}
	public function index()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_tim';
		$data['tab_active'] = 'semua';
		$current_user = $this->session->userdata('current_user');

		$payload = ['tipe_pelaksanaan' => 'Team'];
		$original_data = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
    $mapped = $this->getPekerjaanDenganPegawai($original_data);
    $data['rows'] = $mapped;
		$this->load->view('main', $data);
	}
	public function kpi()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_tim';
		$data['tab_active'] = 'kpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Team',
			'jenis_pekerjaan' => 'KPI'
		];
		$original_data = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$mapped = $this->getPekerjaanDenganPegawai($original_data);
    $data['rows'] = $mapped;
		$this->load->view('main', $data);
	}
	public function nonkpi()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_tim';
		$data['tab_active'] = 'nonkpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Team',
			'jenis_pekerjaan' => 'Non KPI'
		];
		$original_data = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
    $mapped = $this->getPekerjaanDenganPegawai($original_data);
    $data['rows'] = $mapped;
		$this->load->view('main', $data);
	}
	public function updateStatus() {
		$input = $this->input->post(NULL, TRUE);
		$pekerjaan_id = $input['pekerjaan_id'];
		$status = $input['status'];
		if (!$pekerjaan_id || !$status) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal diubah, ID tidak ditemukan!',
				'type'    => 'error' // success, danger, warning, info
			]);
			redirect('pekerjaantim');
		}
		$this->Pekerjaan_model->update($pekerjaan_id, ['status' => $status]);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diubah!',
			'type'    => 'success' // success, danger, warning, info
		]);
		redirect('pekerjaantim');
	}

  public function getPekerjaanDenganPegawai($original_data) {
    $mapped = [];
    
		foreach ($original_data as $row) {
      $id = $row['pekerjaan_id'];
      $pekerjaan_list = $this->Pekerjaan_model->get_pekerjaan_pegawai_by_pekerjaan_id($id);

				if (!isset($mapped[$id])) {
						// Copy semua field dari pekerjaan, lalu kosongkan id_pegawai
						$mapped[$id] = $row;
						$mapped[$id]['nama_pegawai'] = [];
				}

        // Loop semua pegawai yang terkait pekerjaan_id ini
				foreach ($pekerjaan_list as $pegawai) {
            $mapped[$id]['nama_pegawai'][] = $pegawai['nama'];
        }
		}

		// Reset indeks agar rapi
		$mapped = array_values($mapped);
    return $mapped;
  }
}
