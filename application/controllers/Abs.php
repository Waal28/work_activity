<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Abs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');

		$this->load->model('Abs_model');
		$this->load->model('Pegawai_model');

		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['abs']);
	}
	public function index()
	{
		$data['page_title'] = 'PENILAIAN AKHLAK Behavior Survey';
		$data['content_view'] = 'assessment/abs';

		$current_user = $this->session->userdata('current_user');
		$role = $this->session->userdata('role');

		$pegawai_list = [];
		$selected_id = $current_user['id_pegawai'];

		$unit_level_map = [
			'Manager Unit' => ['id_unit_level' => 'A16', 'id_unit_kerja' => $current_user['id_unit_kerja']],
			'Vice President' => ['id_unit_level' => 'A11'],
			'Direktur Utama' => ['id_unit_level' => 'A6'],
		];

		if (isset($unit_level_map[$role])) {
			$payload = $unit_level_map[$role];
			$pegawai_list = $this->Pegawai_model->get_pegawai($payload);
			$data['pegawai_list'] = $pegawai_list;

			if (!empty($pegawai_list)) {
				$selected_id = $pegawai_list[0]['id_pegawai'];
				$data['current_pegawai'] = $this->Pegawai_model->get_details_pegawai($selected_id);
			}
		} else {
			// Role staf
			$data['current_pegawai'] = $this->Pegawai_model->get_details_pegawai($selected_id);
		}

		$data['rows'] = $this->Abs_model->get_core_values_pegawai($selected_id);

		$this->load->view('main', $data);
	}


	public function update()
	{
		$input = $this->input->post();
		$levels = $input['levels'];
		$bhv_assessments = [];

		foreach ($levels as $item) {
			list($level_id, $assessment_id) = explode('|', $item);
			$bhv_assessments[] = [
				'level_id' => $level_id,
				'assessment_id' => $assessment_id
			];
		}

		$this->Abs_model->update_behavior_assessments($bhv_assessments);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type'    => 'success'
		]);
		redirect('abs');
		// echo '<pre>';
		//   print_r($bhv_assessments);
		// echo '</pre>';
	}
	public function detail_pegawai()
	{
		$current_user = $this->session->userdata('current_user');
		$role = $this->session->userdata('role');

		if ($role !== 'Staf') {
			$pegawai_list = $this->Pegawai_model->get_pegawai();
			$data['pegawai_list'] = $pegawai_list;
			$selected_id = $this->input->post('id');
			$data['current_pegawai'] = $this->Pegawai_model->get_details_pegawai($selected_id);
		} else {
			$selected_id = $current_user['id_pegawai'];
		}
		$data['rows'] = $this->Abs_model->get_core_values_pegawai($selected_id);


		$this->load->view('assessment/detail_ajax', $data);
	}
}
