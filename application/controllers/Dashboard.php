<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');

		$this->load->model('Dashboard_model');

		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['dashboard']);
	}
	public function index()
	{
		$data['page_title'] = 'Dashboard';
		$data['content_view'] = 'dashboard/index';
		$current_user = $this->session->userdata('current_user');
		$data['metrik'] = $this->Dashboard_model->get_metrik($current_user['id_pegawai']);
		$data['summary'] = $this->Dashboard_model->get_summary_card($current_user['id_pegawai']);
		$data['summary_last_week'] = $this->Dashboard_model->get_summary_card_last_week($current_user['id_pegawai']);

		$tahun = date("Y"); // Mengambil tahun saat ini, contoh: 2025
		$bulan = date("m"); // Mengambil bulan saat ini dalam format dua digit, contoh: 06
		$data['chart_data'] = $this->Dashboard_model->get_monthly_activity_chart($current_user['id_pegawai'], $bulan, $tahun);

		$this->load->view('main', $data);
	}
}
