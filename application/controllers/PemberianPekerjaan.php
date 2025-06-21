<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemberianPekerjaan extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->library('AuthMiddleware');
		$this->load->library('form_validation');

		$this->load->model('Pekerjaan_model');
		$this->load->model('Pegawai_model');

		$this->load->helper('format');
		$menu_access = $this->session->userdata('menu_access');
		$this->authmiddleware->check($menu_access['pemberian_pekerjaan']);
	}
	public function index()
	{
		$data['page_title'] = 'Pemberian Pekerjaan';
    $data['content_view'] = 'pekerjaan/pemberian_pekerjaan';
		$data['pegawai_list'] = $this->Pegawai_model->get_pegawai();
		$original_data = $this->Pekerjaan_model->get_all();

		$mapped = [];

		foreach ($original_data as $row) {
				$id = $row['pekerjaan_id'];

				if (!isset($mapped[$id])) {
						// Copy semua field dari pekerjaan, lalu kosongkan id_pegawai
						$mapped[$id] = $row;
						$mapped[$id]['id_pegawai'] = [];
						$mapped[$id]['nama_pegawai'] = [];
				}

				$mapped[$id]['id_pegawai'][] = $row['id_pegawai'];
				$mapped[$id]['nama_pegawai'][] = $row['nama'];
		}

		// Reset indeks agar rapi
		$mapped = array_values($mapped);

		$data['rows'] = $mapped;
		$this->load->view('main', $data);
	}

	public function create() {
		$current_user = $this->session->userdata('current_user');
		$input = $this->input->post(NULL, TRUE);

		$this->form_validation->set_rules([
			[
				'field'  => 'judul',
				'label'  => 'Judul',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field'  => 'deadline',
				'label'  => 'Deadline',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Tanggal {field} harus diisi.'
				]
			],
			[
				'field'  => 'prioritas',
				'label'  => 'Prioritas',
				'rules'  => 'required|in_list[Low,Medium,High]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: Low, Medium, atau High.'
				]
			],
			[
				'field'  => 'jenis_pekerjaan',
				'label'  => 'Jenis Pekerjaan',
				'rules'  => 'required|in_list[KPI,Non KPI]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: KPI atau Non KPI.'
				]
			],
			[
				'field'  => 'tipe_pelaksanaan',
				'label'  => 'Tipe Pelaksanaan',
				'rules'  => 'required|in_list[Individu,Team]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: Individu atau Team.'
				]
			],
			[
				'field'  => 'id_pegawai[]',
				'label'  => 'Penerima',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Pilih salah satu {field} terlebih dahulu.'
				]
			],
		]);

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
			redirect('pemberianpekerjaan');
		}

		$data = [
			'judul'       			=> $input['judul'],
			'deadline'   				=> $input['deadline'],
			'jenis_pekerjaan' 	=> $input['jenis_pekerjaan'],
			'prioritas'   			=> $input['prioritas'],
			'deskripsi'   			=> $input['deskripsi'],
			'status'      			=> 'To Do',
			'tipe_pelaksanaan'	=> $input['tipe_pelaksanaan'],
			'pemberi'  					=> $current_user['nama'],
			'created_id'  			=> $current_user['user_id'],
			'freq_mon'					=> 'Tahunan',
			'bobot'							=> 15.00,
			'satuan'						=> '%',
			'annual_target'			=> 90.00,
			'target_semester_1'	=> 40.00,
			'target_semester_2'	=> 50.00,
			'priode'						=> '2025',
		];

		$pekerjaan_id = $this->Pekerjaan_model->insert($data);

		foreach ($input['id_pegawai'] as $pegawai) {
			$this->Pekerjaan_model->insert_pekerjaan_pegawai([
				'pekerjaan_id' => $pekerjaan_id,
				'id_pegawai'   => $pegawai,
			]);
		}

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil disimpan!',
			'type'    => 'success' 
		]);
		redirect('pemberianpekerjaan');
	}

	public function edit($pekerjaan_id = null) {
		$current_user = $this->session->userdata('current_user');
		$input = $this->input->post(NULL, TRUE);

		if (!$pekerjaan_id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal dihapus, ID tidak ditemukan!',
				'type'    => 'danger' 
			]);
			redirect('pemberianpekerjaan');
		};

		$data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($pekerjaan_id);
		if (!$data['pekerjaan']) show_404();

		$this->form_validation->set_rules([
			[
				'field'  => 'judul',
				'label'  => 'Judul',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field'  => 'deadline',
				'label'  => 'Deadline',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Tanggal {field} harus diisi.'
				]
			],
			[
				'field'  => 'prioritas',
				'label'  => 'Prioritas',
				'rules'  => 'required|in_list[Low,Medium,High]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: Low, Medium, atau High.'
				]
			],
			[
				'field'  => 'jenis_pekerjaan',
				'label'  => 'Jenis Pekerjaan',
				'rules'  => 'required|in_list[KPI,Non KPI]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: KPI atau Non KPI.'
				]
			],
			[
				'field'  => 'tipe_pelaksanaan',
				'label'  => 'Tipe Pelaksanaan',
				'rules'  => 'required|in_list[Individu,Team]',
				'errors' => [
					'required' => 'Silakan pilih nilai {field}.',
					'in_list'  => '{field} hanya boleh berisi: Individu atau Team.'
				]
			],
			[
				'field'  => 'id_pegawai[]',
				'label'  => 'Penerima',
				'rules'  => 'required',
				'errors' => [
					'required' => 'Pilih salah satu {field} terlebih dahulu.'
				]
			],
		]);

		if ($this->form_validation->run() === FALSE) {
			$input['pekerjaan_id'] = $pekerjaan_id;
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
			redirect('pemberianpekerjaan');
		}

		$data = [
			'judul'       		=> $input['judul'],
			'deadline'    		=> $input['deadline'],
			'jenis_pekerjaan' => $input['jenis_pekerjaan'],
			'prioritas'   		=> $input['prioritas'],
			'deskripsi'   		=> $input['deskripsi'],
			'tipe_pelaksanaan'	=> $input['tipe_pelaksanaan'],
			'updated_id'  		=> $current_user['user_id'],
		];

		$this->Pekerjaan_model->update($pekerjaan_id, $data);
		// Hapus dulu relasi lama
    $this->Pekerjaan_model->delete_pegawai_relasi($pekerjaan_id);
		foreach ($input['id_pegawai'] as $pegawai) {
			$this->Pekerjaan_model->insert_pekerjaan_pegawai([
				'pekerjaan_id' => $pekerjaan_id,
				'id_pegawai'   => $pegawai,
			]);
		}
		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type'    => 'success' // success, danger, warning, info
		]);
		redirect('pemberianpekerjaan');
	}

	public function delete($id = null) {
		if (!$id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal dihapus, ID tidak ditemukan!',
				'type'    => 'danger' // success, danger, warning, info
			]);
			redirect('pemberianpekerjaan');
		};

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil dihapus!',
			'type'    => 'success' // success, danger, warning, info
		]);
		$this->Pekerjaan_model->delete($id);
		redirect('pemberianpekerjaan');
	}

	// public function view($id = null) {
	// 	if (!$id) show_404();

	// 	$data['pekerjaan'] = $this->Pekerjaan_model->get_by_id($id);
	// 	if (!$data['pekerjaan']) show_404();

	// 	$this->load->view('pekerjaan/view', $data);
	// }
}
