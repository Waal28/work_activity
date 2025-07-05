<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Abs extends CI_Controller
{
	private $current_user;
	private $user_role;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['session', 'AuthMiddleware']);
		$this->load->model(['Abs_model', 'Pegawai_model']);
		$this->load->helper('format');

		// Check access
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['abs']);

		// Set user data
		$this->current_user = $this->session->userdata('current_user');
		$this->user_role = $this->session->userdata('role');
	}

	public function index()
	{
		$data = [
			'page_title' => 'Penilaian Akhlak Behavior Survey',
			'content_view' => 'assessment/abs',
			'pegawai_list' => $this->get_pegawai_list(),
			'current_pegawai' => $this->get_current_pegawai(),
			'perilaku' => $this->Abs_model->get_all_perilaku()
		];

		$this->load->view('main', $data);
	}

	public function daftarpenilaian()
	{
		$data = [
			'page_title' => 'Daftar Penilaian Akhlak',
			'content_view' => 'assessment/daftar_penilaian_abs',
			'rows' => $this->Abs_model->getAllPenilaian($this->current_user['id_pegawai'])
		];

		$this->load->view('main', $data);
	}

	public function detail($id_penilaian_session = null)
	{
		$response = $this->Abs_model->getDetailPenilaian($id_penilaian_session);

		$data = [
			'page_title' => 'Detail Penilaian Akhlak',
			'content_view' => 'assessment/detail_daftar_penilaian_abs',
			'penilaian_session' => $response['penilaian_session'],
			'penilaian' => $response['penilaian'],
			'pegawai' => $response['pegawai'],
			'perilaku' => $response['perilaku'],
			'komentar_penilaian' => $response['komentar_penilaian']
		];

		$this->load->view('main', $data);
	}

	public function simpan()
	{
		$perilaku = $this->input->post('perilaku');
		$area_kekuatan = $this->input->post('area_kekuatan');
		$area_pengembangan = $this->input->post('area_pengembangan');
		$komentar_umum = $this->input->post('komentar_umum');

		if (!$perilaku) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal disimpan, core values belum diisi!',
				'type' => 'danger'
			]);
			redirect('abs');
		}

		if (!$area_kekuatan || !$area_pengembangan || !$komentar_umum) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal disimpan, komentar belum diisi!',
				'type' => 'danger'
			]);
			redirect('abs');
		}

		$this->Abs_model->simpanPenilaian($this->input->post(), $this->current_user['id_pegawai']);

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type' => 'success'
		]);

		redirect('abs');
	}


	public function delete($id = null)
	{
		if (!$id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal dihapus, ID tidak ditemukan!',
				'type' => 'danger'
			]);
			redirect('abs');
		}

		$this->Abs_model->delete($id);

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil dihapus!',
			'type' => 'success'
		]);

		redirect('abs/daftarpenilaian');
	}

	public function detail_pegawai()
	{
		$id_pegawai = $this->input->post('id');
		$data = [
			'pegawai_list' => $this->get_pegawai_list(),
			'current_pegawai' => $this->get_current_pegawai($id_pegawai),
			'perilaku' => $this->Abs_model->get_all_perilaku()
		];

		$this->load->view('assessment/detail_ajax', $data);
	}

	// Private helper methods
	private function get_pegawai_list()
	{
		// $unit_level_map = [
		// 	'Manager Unit' => ['id_unit_level' => 'A16', 'id_unit_kerja' => $this->current_user['id_unit_kerja']],
		// 	'Vice President' => ['id_unit_level' => 'A11'],
		// 	'Direktur Utama' => ['id_unit_level' => 'A6'],
		// ];

		// if (isset($unit_level_map[$this->user_role])) {
		// 	return $this->Pegawai_model->get_pegawai($unit_level_map[$this->user_role]);
		// }

		// return [];
		return $this->Pegawai_model->get_pegawai();
	}

	private function get_current_pegawai($id_pegawai = null)
	{
		$pegawai_list = $this->get_pegawai_list();

		if (!empty($pegawai_list)) {
			$selected_id = !empty($id_pegawai) ? $id_pegawai : $pegawai_list[0]['id_pegawai'];
			return $this->Pegawai_model->get_details_pegawai($selected_id);
		}

		return [];
	}
}
