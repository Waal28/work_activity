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

		// Tambahkan menu monitoring & pemberian_pekerjaan jika belum ada
		$menu_access = (array) $this->session->userdata('menu_access');
		$menu_access = array_merge($menu_access, [
			'dashboard' => true,
			'pekerjaan_saya' => true,
			'pekerjaan_tim' => true,
			'delegasi_pekerjaan' => true,
			'pekerjaan_selesai' => true,
			'pemberian_pekerjaan' => true,
			'monitoring' => true,
		]);
		$this->session->set_userdata('menu_access', $menu_access);
	}

	public function index()
	{
		$data['page_title'] = 'Dashboard';
		$data['content_view'] = 'dashboard/index';
		$current_user = $this->session->userdata('current_user');

		$data['metrik'] = $this->Dashboard_model->get_metrik($current_user['id_pegawai']);
		$data['summary'] = $this->Dashboard_model->get_summary_card($current_user['id_pegawai']);
		$data['summary_last_week'] = $this->Dashboard_model->get_summary_card_last_week($current_user['id_pegawai']);

		$tahun = date("Y");
		$bulan = date("m");
		$data['chart_data'] = $this->Dashboard_model->get_monthly_activity_chart($current_user['id_pegawai'], $bulan, $tahun);

		$this->load->view('main', $data);
	}
}
