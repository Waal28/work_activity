<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CommunityInvolvement extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$this->load->library('form_validation');

		$this->load->model('Community_involvement_model');

		$this->load->helper('format');
		$this->load->helper(['form', 'url']);

		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['community_involvement']);
	}
	public function index()
	{
		$data['page_title'] = 'Community Involvement';
		$data['content_view'] = 'objective/community_involvement';;
		$current_user = $this->session->userdata('current_user');

		$data['rows'] = $this->Community_involvement_model->get_community_by_pegawai($current_user['id_pegawai']);
		$this->load->view('main', $data);
	}
	public function create()
	{
		$current_user = $this->session->userdata('current_user');
		$input = $this->input->post(NULL, TRUE);

		$rules = $this->get_validation_rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
			redirect('communityinvolvement');
		}

		$bukti = '';
		if (!empty($_FILES['bukti']['name'])) {
			$bukti = upload_file('bukti');
		}

		$data = [
			'aktivitas'       		=> $input['aktivitas'],
			'tanggal_pelaksanaan' => $input['tanggal_pelaksanaan'],
			'lokasi' 							=> $input['lokasi'],
			'keterangan'   				=> $input['keterangan'],
			'point'   						=> $input['point'],
			'id_pegawai'  				=> $current_user['id_pegawai'],
			'periode_objective_id' => 3,
			'bukti'   						=> $bukti
		];

		$this->Community_involvement_model->insert($data);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil disimpan!',
			'type'    => 'success'
		]);
		redirect('communityinvolvement');
	}

	public function edit($id = null)
	{
		$input = $this->input->post(NULL, TRUE);

		if (!$id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal dihapus, ID tidak ditemukan!',
				'type'    => 'danger'
			]);
			redirect('communityinvolvement');
		};

		$data['pekerjaan'] = $this->Community_involvement_model->get_by_id($id);
		if (!$data['pekerjaan']) show_404();

		$rules = $this->get_validation_rules();
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() === FALSE) {
			$input['id'] = $id;
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
			redirect('communityinvolvement');
		}

		$bukti = '';
		if (!empty($_FILES['bukti']['name'])) {
			$bukti = upload_file('bukti');
		} elseif (!empty($input['bukti_lama'])) {
			$bukti = $input['bukti_lama'];
		}

		$data = [
			'aktivitas'       		=> $input['aktivitas'],
			'tanggal_pelaksanaan' => $input['tanggal_pelaksanaan'],
			'lokasi' 							=> $input['lokasi'],
			'keterangan'   				=> $input['keterangan'],
			'point'   						=> $input['point'],
			'bukti'   						=> $bukti
		];

		$this->Community_involvement_model->update($id, $data);
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type'    => 'success' // success, danger, warning, info
		]);
		redirect('communityinvolvement');
	}

	public function delete($id = null)
	{
		if (!$id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal dihapus, ID tidak ditemukan!',
				'type'    => 'danger' // success, danger, warning, info
			]);
			redirect('communityinvolvement');
		};

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil dihapus!',
			'type'    => 'success' // success, danger, warning, info
		]);
		$this->Community_involvement_model->delete($id);
		redirect('communityinvolvement');
	}

	private function get_validation_rules()
	{
		$rules = [
			[
				'field'  => 'aktivitas',
				'label'  => 'Aktivitas',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field'  => 'tanggal_pelaksanaan',
				'label'  => 'Tanggal Pelaksanaan',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} harus diisi.'
				]
			],
			[
				'field'  => 'lokasi',
				'label'  => 'Lokasi',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} harus diisi.'
				]
			],
			[
				'field'  => 'point',
				'label'  => 'Point',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} harus diisi.'
				]
			],
			[
				'field'  => 'keterangan',
				'label'  => 'Keterangan',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} harus diisi.'
				]
			],
		];

		return $rules;
	}
}
