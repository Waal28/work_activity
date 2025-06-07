<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['dashboard']);
	}
	public function index()
	{
		$data['page_title'] = 'Dashboard';
		$data['content_view'] = 'dashboard/index';
		$this->load->view('main', $data);
	}
}
