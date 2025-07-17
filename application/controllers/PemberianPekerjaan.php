<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PemberianPekerjaan extends CI_Controller
{
	public function __construct()
	{
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

		$current_user = $this->session->userdata('current_user');
		$role = $this->session->userdata('role');

		// Role-to-payload mapping
		$payload_map = [
			'Manager Unit' => [
				'id_unit_level' => 'A16', //ambil hanya staf
				'id_unit_kerja' => $current_user['id_unit_kerja'],
			],
			'Vice President' => [
				'id_unit_level' => 'A11', //ambil hanya manager unit
			],
			'Direktur Utama' => [
				'id_unit_level' => 'A6', //ambil hanya vp
			]
		];

		$payload_pegawai = $payload_map[$role] ?? null;
		$payload_pekerjaan = ['created_id' => $current_user['id_pegawai']];

		$data['pegawai_list'] = $this->Pegawai_model->get_pegawai($payload_pegawai);

		$original_data = $this->Pekerjaan_model->get_all($payload_pekerjaan);
		$mapped = [];

		foreach ($original_data as $row) {
			$id = $row['pekerjaan_id'];

			if (!isset($mapped[$id])) {
				$mapped[$id] = $row;
				$mapped[$id]['id_pegawai'] = [];
				$mapped[$id]['nama_pegawai'] = [];
			}

			$mapped[$id]['id_pegawai'][] = $row['id_pegawai'];
			$mapped[$id]['nama_pegawai'][] = $row['nama'];
		}

		$data['rows'] = array_values($mapped); // Reset index
		// echo '<pre>';
		// print_r($original_data);
		// echo '</pre>';
		// return;
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
			'created_id'  			=> $current_user['id_pegawai'],
			'freq_mon'					=> $input['freq_mon'],
			'bobot'							=> floatval($input['bobot']),
			'progress'					=> 0,
			'satuan'						=> $input['satuan'],
			'annual_target'			=> floatval($input['annual_target']),
			'target_semester_1'	=> floatval($input['target_semester_1']),
			'target_semester_2'	=> floatval($input['target_semester_2']),
			'hasil_kerja'				=> 'Menunggu Persetujuan',
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

	public function edit($pekerjaan_id = null)
	{
		$current_user = $this->session->userdata('current_user');
		$input = $this->input->post(NULL, TRUE);

		if (!$pekerjaan_id) {
			$this->session->set_flashdata('toast', [
				'message' => 'Data gagal diubah, ID tidak ditemukan!',
				'type'    => 'danger'
			]);
			redirect('pemberianpekerjaan');
		}

		$data_pekerjaan = $this->Pekerjaan_model->get_by_id($pekerjaan_id);
		if (!$data_pekerjaan) show_404();

		$rules = $this->get_validation_rules($input['is_delegasi']);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() === FALSE) {
			$input['pekerjaan_id'] = $pekerjaan_id;
			$this->session->set_flashdata('validation_errors', validation_errors());
			$this->session->set_flashdata('old_input', $input);
			redirect('pemberianpekerjaan');
		}

		$data = [
			'judul'              => $input['judul'],
			'deadline'           => $input['deadline'],
			'jenis_pekerjaan'    => $input['jenis_pekerjaan'],
			'prioritas'          => $input['prioritas'],
			'deskripsi'          => $input['deskripsi'],
			'updated_id'         => $current_user['id_pegawai'],
			'freq_mon'           => $input['freq_mon'],
			'bobot'              => floatval($input['bobot']),
			'satuan'             => $input['satuan'],
			'annual_target'      => floatval($input['annual_target']),
			'target_semester_1'  => floatval($input['target_semester_1']),
			'target_semester_2'  => floatval($input['target_semester_2']),
		];

		if (!$input['is_delegasi']) {
			$data['tipe_pelaksanaan'] = $input['tipe_pelaksanaan'];
		}
		$this->Pekerjaan_model->update($pekerjaan_id, $data);

		// Handle delegasi
		if (!$input['is_delegasi']) {
			$this->Pekerjaan_model->delete_pekerjaan_pegawai(['pekerjaan_id' => $pekerjaan_id]);
			foreach ($input['id_pegawai'] as $pegawai) {
				$this->Pekerjaan_model->insert_pekerjaan_pegawai([
					'pekerjaan_id' => $pekerjaan_id,
					'id_pegawai'   => $pegawai,
				]);
			}
		}

		$this->session->set_flashdata('toast', [
			'message' => 'Data berhasil diupdate!',
			'type'    => 'success'
		]);
		redirect('pemberianpekerjaan');
	}


	public function delete($id = null)
	{
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

	public function validate_team_member_count($value)
	{
		$tipe = $this->input->post('tipe_pelaksanaan');
		$pegawai = $this->input->post('id_pegawai');

		if ($tipe === 'Team' && (!is_array($pegawai) || count($pegawai) <= 1)) {
			$this->form_validation->set_message('validate_team_member_count', 'Jika Tipe Pengerjaan adalah Team, maka minimal harus memilih dua pegawai.');
			return false;
		}

		return true;
	}


	private function get_validation_rules($isDelegasi = false)
	{
		$rules = [
			[
				'field' => 'judul',
				'label' => 'Judul',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'deadline',
				'label' => 'Deadline',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'prioritas',
				'label' => 'Prioritas',
				'rules' => 'required|in_list[Low,Medium,High]',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.',
					'in_list'  => '{field} hanya boleh berisi: Low, Medium, atau High.'
				]
			],
			[
				'field' => 'jenis_pekerjaan',
				'label' => 'Jenis Pekerjaan',
				'rules' => 'required|in_list[KPI,Non KPI]',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.',
					'in_list'  => '{field} hanya boleh berisi: KPI atau Non KPI.'
				]
			],
			[
				'field' => 'freq_mon',
				'label' => 'Freq Mon',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'bobot',
				'label' => 'Bobot',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'satuan',
				'label' => 'Satuan',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'annual_target',
				'label' => 'Target Tahunan',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'target_semester_1',
				'label' => 'Target Semester 1',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
			[
				'field' => 'target_semester_2',
				'label' => 'Target Semester 2',
				'rules' => 'required',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.'
				]
			],
		];

		if (!$isDelegasi) {
			$rules[] = [
				'field' => 'tipe_pelaksanaan',
				'label' => 'Tipe Pengerjaan',
				'rules' => 'required|in_list[Individu,Team]',
				'errors' => [
					'required' => 'Kolom {field} wajib diisi.',
					'in_list'  => '{field} hanya boleh berisi: Individu atau Team.'
				]
			];
			$rules[] = [
				'field' => 'id_pegawai[]',
				'label' => 'Penerima',
				'rules' => 'required|callback_validate_team_member_count',
				'errors' => [
					'required' => 'Pilih minimal satu {field}.',
					'validate_team_member_count' => 'Jika Tipe Pengerjaan adalah Team, maka minimal harus memilih dua pegawai.'
				]
			];
		}

		return $rules;
	}
}
