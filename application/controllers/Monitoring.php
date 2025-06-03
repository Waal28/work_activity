<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'Monitoring Pekerjaan';
		$data['content_view'] = 'monitoring/index';
		$this->load->view('main', $data);
	}
}
