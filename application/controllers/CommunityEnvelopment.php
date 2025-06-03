<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CommunityEnvelopment extends CI_Controller
{
	public function index()
	{
		$data['page_title'] = 'Community Envelopment';
		$data['content_view'] = 'objective/community_envelopment';
		$this->load->view('main', $data);
	}
}
