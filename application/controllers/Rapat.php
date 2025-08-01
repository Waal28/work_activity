<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapat extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('session');
    $this->load->library('AuthMiddleware', null, 'authmiddleware');
    $this->load->library('form_validation');

    $this->load->model('Rapat_model');
    $this->load->model('Pegawai_model');

    $this->load->helper('format');

    $this->menu_access = $this->session->userdata('menu_access');
  }

  public function index()
  {
    $this->authmiddleware->check($this->menu_access['manajemen_rapat']);
    $data['page_title'] = 'Manajemen Rapat';
    $data['content_view'] = 'rapat/manajemen_rapat';

    $rows = $this->Rapat_model->get_data_rapat();
    $list_rapat_mendatang = [];

    $today = date('Y-m-d'); // format tanggal hari ini

    foreach ($rows as $row) {
      // Pastikan tanggal valid dan status adalah 'Terjadwal'
      if (!empty($row['tanggal_rapat']) && !empty($row['status'])) {
        $tanggal_rapat = date('Y-m-d', strtotime($row['tanggal_rapat']));
        if ($row['status'] === 'Terjadwal' && $tanggal_rapat >= $today) {
          $list_rapat_mendatang[] = $row;
        }
      }
    }

    $data['rows'] = $rows;
    $data['list_rapat_mendatang'] = $list_rapat_mendatang;
    $data['pegawai_list'] = $this->Pegawai_model->get_pegawai();

    $this->load->view('main', $data);
  }

  public function create()
  {
    $this->authmiddleware->check($this->menu_access['manajemen_rapat']);
    $current_user = $this->session->userdata('current_user');
    $input = $this->input->post(NULL, TRUE);

    $rules = $this->get_validation_rules();
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('validation_errors', validation_errors());
      $this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
      redirect('rapat');
    }

    $data = [
      'nama_rapat'          => $input['nama_rapat'],
      'deskripsi'           => $input['deskripsi'],
      'tanggal_rapat'       => $input['tanggal_rapat'],
      'waktu_mulai'         => $input['waktu_mulai'],
      'waktu_selesai'       => $input['waktu_selesai'],
      'metode_pelaksanaan'  => $input['metode_pelaksanaan'],
      'status'              => 'Terjadwal',
      'link_undangan'       => $input['link_undangan'],
      'tempat_pelaksanaan'  => $input['tempat_pelaksanaan'],
      'created_id'          => $current_user['id_pegawai'],
    ];

    $rapat_id = $this->Rapat_model->insert($data);

    foreach ($input['id_pegawai'] as $pegawai) {
      $this->Rapat_model->insert_rapat_pegawai([
        'rapat_id' => $rapat_id,
        'id_pegawai'   => $pegawai,
      ]);
    }
    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil disimpan!',
      'type'    => 'success'
    ]);
    redirect('rapat');
  }

  public function edit($id = null)
  {
    $this->authmiddleware->check($this->menu_access['manajemen_rapat']);
    $input = $this->input->post(NULL, TRUE);

    if (!$id) {
      $this->session->set_flashdata('toast', [
        'message' => 'Data gagal dihapus, ID tidak ditemukan!',
        'type'    => 'danger'
      ]);
      redirect('rapat');
    };

    $rapat = $this->Rapat_model->get_by_id($id);
    if (!$rapat) show_404();

    $rules = $this->get_validation_rules();
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() === FALSE) {
      $input['id'] = $id;
      $this->session->set_flashdata('validation_errors', validation_errors());
      $this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
      redirect('rapat');
    }

    $data = [
      'nama_rapat'          => $input['nama_rapat'],
      'deskripsi'           => $input['deskripsi'],
      'tanggal_rapat'       => $input['tanggal_rapat'],
      'waktu_mulai'         => $input['waktu_mulai'],
      'waktu_selesai'       => $input['waktu_selesai'],
      'metode_pelaksanaan'  => $input['metode_pelaksanaan'],
      'link_undangan'       => $input['link_undangan'],
      'tempat_pelaksanaan'  => $input['tempat_pelaksanaan'],
    ];

    $this->Rapat_model->update($id, $data);
    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil diupdate!',
      'type'    => 'success' // success, danger, warning, info
    ]);
    redirect('rapat');
  }

  public function delete($id = null)
  {
    $this->authmiddleware->check($this->menu_access['manajemen_rapat']);
    if (!$id) {
      $this->session->set_flashdata('toast', [
        'message' => 'Data gagal dihapus, ID tidak ditemukan!',
        'type'    => 'danger' // success, danger, warning, info
      ]);
      redirect('rapat');
    };

    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil dihapus!',
      'type'    => 'success' // success, danger, warning, info
    ]);
    $this->Rapat_model->delete($id);
    redirect('rapat');
  }

  public function daftarRapat()
  {
    $this->authmiddleware->check($this->menu_access['daftar_rapat']);
    $current_user = $this->session->userdata('current_user');

    $input = $this->input->get(NULL, TRUE);
    $data['page_title'] = 'Undangan Rapat';
    $data['content_view'] = 'rapat/daftar_rapat';
    $data['tab_active'] = $input['status'];

    $where = [
      'id_pegawai' => $current_user['id_pegawai'],
      'status' => $input['status']
    ];
    $total_rapat_terjadwal = $this->Rapat_model->get_data_rapat_pegawai([
      'id_pegawai' => $current_user['id_pegawai'],
      'status' => 'Terjadwal'
    ]);
    $data['rows'] = $this->Rapat_model->get_data_rapat_pegawai($where);
    $this->session->set_userdata(['total_rapat_terjadwal' => count($total_rapat_terjadwal)]);
    $this->load->view('main', $data);
  }

  public function setStatus()
  {
    $this->authmiddleware->check($this->menu_access['manajemen_rapat']);
    $input = $this->input->post(NULL, TRUE);
    $rapat_id = $input['rapat_id'];
    $status = $input['status'];
    $list_status = ['Terjadwal', 'Dibatalkan', 'Selesai'];


    if (!$rapat_id || !$status || !in_array($status, $list_status)) {
      $this->session->set_flashdata('toast', [
        'message' => 'Data gagal dihapus, data belum lengkap!',
        'type'    => 'danger'
      ]);
      redirect('rapat');
    };

    $rapat = $this->Rapat_model->get_by_id($rapat_id);
    if (!$rapat) show_404();


    $data = [
      'status'  => $status,
    ];

    $this->Rapat_model->update($rapat_id, $data);
    $this->session->set_flashdata('toast', [
      'message' => 'Berhasil mengubah status!',
      'type'    => 'success' // success, danger, warning, info
    ]);
    redirect('rapat');
  }

  private function get_validation_rules()
  {
    $rules = [
      [
        'field' => 'nama_rapat',
        'label' => 'Judul Rapat',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
      [
        'field' => 'deskripsi',
        'label' => 'Deskripsi',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
      [
        'field' => 'waktu_mulai',
        'label' => 'Waktu Mulai',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
      [
        'field' => 'waktu_selesai',
        'label' => 'Waktu Selesai',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
      [
        'field' => 'id_pegawai[]',
        'label' => 'Peserta Rapat',
        'rules' => 'required',
        'errors' => [
          'required' => 'Pilih minimal satu {field}.',
        ]
      ],
      [
        'field' => 'metode_pelaksanaan',
        'label' => 'Metode Pelaksanaan',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.',
          'in_list'  => '{field} hanya boleh berisi: Online, Offline.'
        ]
      ],
      [
        'field' => 'link_undangan',
        'label' => 'Link Undangan',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
      [
        'field' => 'tempat_pelaksanaan',
        'label' => 'Tempat Pelaksanaan',
        'rules' => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
    ];

    return $rules;
  }
}
