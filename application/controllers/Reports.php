<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');

		$this->load->model('Reports_model');

    $this->load->helper('format');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['reports']);
	}
	public function index()
	{
		$data['page_title'] = 'Individual Goal Setting';
		$data['content_view'] = 'analytics/reports';
		$current_user = $this->session->userdata('current_user');
		$data['rows'] = $this->Reports_model->get_reports($current_user['id_pegawai'], '2025');
		$this->load->view('main', $data);
	}
}
