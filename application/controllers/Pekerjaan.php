<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pekerjaan extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Pekerjaan Saya';
		$data['content_dir'] = 'direktur_utama/pekerjaan';  // ✅ Ganti folder sesuai struktur
		$data['content_name'] = 'index';
		$this->load->view('main', $data);
	}

	public function pemberian()
	{
		$data['title'] = 'Pemberian Pekerjaan';
		$data['content_dir'] = 'direktur_utama/pekerjaan';  // ✅ Ganti juga di sini
		$data['content_name'] = 'pemberian';
		$this->load->view('main', $data);
	}
}
