<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HseObjective extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['hse_objective']);
	}
	public function index()
	{
		$data['page_title'] = 'HSE Objective';
		$data['content_view'] = 'objective/hse_objective';
		$this->load->view('main', $data);
	}
}
