<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DevelopmentCommitment extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['development_commitment']);
	}
	public function index()
	{
		$data['page_title'] = 'Development Commitment';
		$data['content_view'] = 'objective/development_commitment';
		$this->load->view('main', $data);
	}
}
