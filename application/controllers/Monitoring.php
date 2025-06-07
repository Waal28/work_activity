<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['monitoring']);
	}
	public function index()
	{
		$data['page_title'] = 'Monitoring Pekerjaan';
		$data['content_view'] = 'monitoring/index';
		$this->load->view('main', $data);
	}
}
