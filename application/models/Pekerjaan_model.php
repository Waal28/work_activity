<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan_model extends CI_Model {

  private $table = 'pekerjaan';

  public function get_all() {
    $this->db->select('pekerjaan.*, pegawai.nama, pegawai.id_pegawai');
    $this->db->from('pekerjaan');
    $this->db->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id');
    $this->db->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai');
    $this->db->order_by('deadline', 'ASC');
    return $this->db->get()->result_array();
  }

  public function get_by_id($id) {
    return $this->db->where('pekerjaan_id', $id)->get($this->table)->row();
  }

  public function get_pekerjaan_pegawai_by_pekerjaan_id($id)
  {
      $this->db
          ->select('pekerjaan_pegawai.*, pegawai.nama')
          ->from('pekerjaan_pegawai')
          ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
          ->where('pekerjaan_id', $id);

      return $this->db->get()->result_array(); // ambil semua data
  }

  public function insert($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($id, $data) {
    return $this->db->where('pekerjaan_id', $id)->update($this->table, $data);
  }

  public function delete($id) {
    return $this->db->where('pekerjaan_id', $id)->delete($this->table);
  }

  public function insert_pekerjaan_pegawai($data) {
    $this->db->insert('pekerjaan_pegawai', $data);
  }
  public function delete_pegawai_relasi($id) {
    $this->db->delete('pekerjaan_pegawai', ['pekerjaan_id' => $id]);
  }
  
  public function get_by_id_pegawai($id_pegawai, $payload = []) {
    $this->db
      ->select('pekerjaan.*, pegawai.nama, users.username')
      ->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->join('users', 'pekerjaan.created_id = users.user_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->order_by('pekerjaan.deadline', 'ASC');

    if (!empty($payload['jenis_pekerjaan'])) {
        $this->db->where('pekerjaan.jenis_pekerjaan', $payload['jenis_pekerjaan']);
    }
    if (!empty($payload['status'])) {
        $this->db->where('pekerjaan.status', $payload['status']);
    }
    if (!empty($payload['tipe_pelaksanaan'])) {
        $this->db->where('pekerjaan.tipe_pelaksanaan', $payload['tipe_pelaksanaan']);
    }

    return $this->db->get()->result_array();
  }
}
