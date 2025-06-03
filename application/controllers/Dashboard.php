<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'Dashboard';
		$data['content_view'] = 'dashboard/index';
		$this->load->view('main', $data);
	}
}
