<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DelegasiPekerjaan extends CI_Controller
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
    $this->authmiddleware->check($menu_access['delegasi_pekerjaan']);
  }
  public function index()
  {
    $data['page_title'] = 'Delegasi Pekerjaan';
    $data['content_view'] = 'pekerjaan/delegasi_pekerjaan';

    $current_user = $this->session->userdata('current_user');
    $role = $this->session->userdata('role');

    // Role-to-payload mapping
    $payload_map = [
      'Manager' => [
        'id_unit_level' => 'A15',
        'id_unit_kerja' => $current_user['id_unit_kerja']
      ],
      'Vice President' => [
        'id_unit_level' => 'A7',
      ],
      'Direktur Utama' => [
        'id_unit_level' => 'A6',
      ]
    ];

    $payload = $payload_map[$role] ?? null;

    $data['pegawai_list'] = $this->Pegawai_model->get_pegawai($payload);
    $data['pekerjaan_list'] = $this->Pekerjaan_model->get_by_id_pegawai($current_user['id_pegawai']);
    $data['rows'] = $this->Pekerjaan_model->get_delegasi_pekerjaan([
      'id_pegawai' => $current_user['id_pegawai']
    ]);
    // echo '<pre>';
    // print_r($data['pegawai_list']);
    // print_r($data['pekerjaan_list']);
    // print_r($data['rows']);
    // echo '</pre>';
    // return;
    $this->load->view('main', $data);
  }


  public function create()
  {
    $current_user = $this->session->userdata('current_user');
    $input = $this->input->post(NULL, TRUE);
    // echo '<pre>';
    // print_r($input);
    // echo '</pre>';
    // return;

    $this->form_validation->set_rules([
      [
        'field'  => 'id_pegawai[]',
        'label'  => 'Penerima',
        'rules'  => 'required',
        'errors' => [
          'required' => 'Pilih salah satu {field} terlebih dahulu.',
        ]
      ],
      [
        'field'  => 'pekerjaan_id',
        'label'  => 'Pekerjaan',
        'rules'  => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
    ]);

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('validation_errors', validation_errors());
      $this->session->set_flashdata('old_input', $input); // agar value form tidak hilang
      redirect('delegasipekerjaan');
    }

    foreach ($input['id_pegawai'] as $pegawai) {
      $data = [
        'pekerjaan_id'    => $input['pekerjaan_id'],
        'dari_id_pegawai' => $current_user['id_pegawai'],
        'ke_id_pegawai'   => $pegawai,
      ];

      $this->Pekerjaan_model->insert_delegasi_pekerjaan($data);
      $this->Pekerjaan_model->insert_pekerjaan_pegawai([
        'pekerjaan_id' => $input['pekerjaan_id'],
        'id_pegawai'   => $pegawai,
      ]);
    }
    $where = [
      'pekerjaan_id' => $input['pekerjaan_id'],
      'id_pegawai' => [$current_user['id_pegawai']],
    ];

    $this->Pekerjaan_model->delete_pekerjaan_pegawai($where);

    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil disimpan!',
      'type'    => 'success'
    ]);
    redirect('delegasipekerjaan');
  }

  public function edit($delegsi_id)
  {
    $pekerjaan_id = $this->input->post('pekerjaan_id');
    $id_pegawai = $this->input->post('id_pegawai')[0];

    $pekerjaan = $this->Pekerjaan_model->get_by_id($pekerjaan_id);
    if (!$pekerjaan || !$delegsi_id) show_404();

    $this->form_validation->set_rules([
      [
        'field'  => 'id_pegawai[]',
        'label'  => 'Penerima',
        'rules'  => 'required',
        'errors' => [
          'required' => 'Pilih salah satu {field} terlebih dahulu.',
        ]
      ],
      [
        'field'  => 'pekerjaan_id',
        'label'  => 'Pekerjaan',
        'rules'  => 'required',
        'errors' => [
          'required' => 'Kolom {field} wajib diisi.'
        ]
      ],
    ]);

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('validation_errors', validation_errors());
      $this->session->set_flashdata('old_input', $this->input->post()); // agar value form tidak hilang
      redirect('delegasipekerjaan');
    }


    $where_1 = [
      'pekerjaan_id'    => $pekerjaan_id,
      'ke_id_pegawai'   => $id_pegawai,
    ];
    $where_2 = [
      'pekerjaan_id' => $pekerjaan_id,
      'id_pegawai'   => $id_pegawai,
    ];

    $check_delegasi = $this->Pekerjaan_model->get_delegasi_pekerjaan($where_1);
    if ($check_delegasi) {
      $this->session->set_flashdata('toast', [
        'message' => 'Data gagal diupdate, Pegawai sudah memiliki pekerjaan tersebut!',
        'type'    => 'danger' // success, danger, warning, info
      ]);
      redirect('delegasipekerjaan');
    };

    $this->Pekerjaan_model->update_delegasi_pekerjaan($where_1);
    $this->Pekerjaan_model->update_pekerjaan_pegawai($where_2);

    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil diupdate!',
      'type'    => 'success' // success, danger, warning, info
    ]);
    redirect('delegasipekerjaan');
  }

  public function delete()
  {
    $pekerjaan_id = $this->input->get('pekerjaan_id');
    $id_pegawai = $this->input->get('id_pegawai');

    if (!$pekerjaan_id || !$id_pegawai) {
      $this->session->set_flashdata('toast', [
        'message' => 'Data gagal dihapus, ID tidak ditemukan!',
        'type'    => 'danger' // success, danger, warning, info
      ]);
      redirect('delegasipekerjaan');
    };

    $this->session->set_flashdata('toast', [
      'message' => 'Data berhasil dihapus!',
      'type'    => 'success' // success, danger, warning, info
    ]);
    $where_1 = [
      'pekerjaan_id' => $pekerjaan_id,
      'ke_id_pegawai'   => $id_pegawai,
    ];
    $where_2 = [
      'pekerjaan_id' => $pekerjaan_id,
      'id_pegawai' => $id_pegawai,
    ];
    $this->Pekerjaan_model->delete_delegasi_pekerjaan($where_1);
    $this->Pekerjaan_model->delete_pekerjaan_pegawai($where_2);
    redirect('delegasipekerjaan');
  }
}
