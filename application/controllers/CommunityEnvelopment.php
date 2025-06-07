<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CommunityEnvelopment extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['community_envelopment']);
	}
	public function index()
	{
		$data['page_title'] = 'Community Envelopment';
		$data['content_view'] = 'objective/community_envelopment';
		$this->load->view('main', $data);
	}
}
