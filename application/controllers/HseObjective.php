<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HseObjective extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'HSE Objective';
		$data['content_view'] = 'objective/hse_objective';
		$this->load->view('main', $data);
	}
}
