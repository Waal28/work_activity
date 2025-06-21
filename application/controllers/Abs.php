<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Abs extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');

		$this->load->model('Abs_model');

		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['abs']);
	}
	public function index()
	{
		$data['page_title'] = 'PENILAIAN AKHLAK Behavior Survey';
		$data['content_view'] = 'assessment/abs';
		$current_user = $this->session->userdata('current_user');
		$data['rows'] = $this->Abs_model->get_core_values_pegawai($current_user['id_pegawai']);
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
}
