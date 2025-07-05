<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PekerjaanSaya extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$this->load->library('form_validation');

		$this->load->model('Pekerjaan_model');

		$this->load->helper('format');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['pekerjaan_saya']);
	}
	public function index()
	{
		$data['page_title'] = 'Pekerjaan Saya';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'semua';
		$current_user = $this->session->userdata('current_user');

		$payload = ['tipe_pelaksanaan' => 'Individu'];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function kpi()
	{
		$data['page_title'] = 'Pekerjaan Saya';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'kpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Individu',
			'jenis_pekerjaan' => 'KPI'
		];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function nonkpi()
	{
		$data['page_title'] = 'Pekerjaan Saya';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'nonkpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Individu',
			'jenis_pekerjaan' => 'Non KPI'
		];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function pekerjaanTim()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'semua';
		$current_user = $this->session->userdata('current_user');

		$payload = ['tipe_pelaksanaan' => 'Team'];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function pekerjaanTimKpi()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'kpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Team',
			'jenis_pekerjaan' => 'KPI'
		];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function pekerjaanTimNonkpi()
	{
		$data['page_title'] = 'Pekerjaan Tim';
		$data['content_view'] = 'pekerjaan/pekerjaan_saya';
		$data['tab_active'] = 'nonkpi';
		$current_user = $this->session->userdata('current_user');

		$payload = [
			'tipe_pelaksanaan' => 'Team',
			'jenis_pekerjaan' => 'Non KPI'
		];
		$data['rows'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai'], $payload);
		$this->load->view('main', $data);
	}
	public function updateStatus()
	{
		$input = $this->input->post(NULL, TRUE);
		$pekerjaan_id = $input['pekerjaan_id'];

		if (!$pekerjaan_id || !$input['status']) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal diubah, ID tidak ditemukan!',
				'type'    => 'error' // success, danger, warning, info
			]);
			redirect('pekerjaansaya');
		}
		$payload = [
			'status' => $input['status'],
			'progress' => intval($input['progress'])
		];

		if ($input['status'] === 'Done') {
			$payload['progress'] = 100;
			$payload['tanggal_selesai'] = date('Y-m-d H:i:s');
		}

		$this->Pekerjaan_model->update($pekerjaan_id, $payload);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diubah!',
			'type'    => 'success' // success, danger, warning, info
		]);
		redirect('pekerjaansaya');
	}
}
