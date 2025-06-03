<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DevelopmentCommitment extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'Development Commitment';
		$data['content_view'] = 'objective/development_commitment';
		$this->load->view('main', $data);
	}
}
