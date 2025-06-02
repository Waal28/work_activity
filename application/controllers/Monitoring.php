<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Monitoring Pekerjaan';
		$data['content_dir'] = 'direktur_utama/monitoring';
		$data['content_name'] = 'index';
		$this->load->view('main', $data);
	}
}
