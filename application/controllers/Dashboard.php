<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['content_dir'] = 'direktur_utama/dashboard';
		$data['content_name'] = 'index';
		$this->load->view('main', $data);
	}
}
