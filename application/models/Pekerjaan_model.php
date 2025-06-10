<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan_model extends CI_Model {

  private $table = 'pekerjaan';

  public function get_all() {
    $this->db->select('pekerjaan.*, pegawai.nama');
    $this->db->from('pekerjaan');
    $this->db->join('pegawai', 'pekerjaan.id_pegawai = pegawai.id_pegawai');
    $this->db->order_by('deadline', 'ASC');
    return $this->db->get()->result_array();
  }

  public function get_by_id($id) {
    return $this->db->where('pekerjaan_id', $id)->get($this->table)->row();
  }

  public function insert($data) {
    return $this->db->insert($this->table, $data);
  }

  public function update($id, $data) {
    return $this->db->where('pekerjaan_id', $id)->update($this->table, $data);
  }

  public function delete($id) {
    return $this->db->where('pekerjaan_id', $id)->delete($this->table);
  }
  
  public function get_by_id_pegawai($id, $jenis_pekerjaan = null) {
    $this->db
      ->select('pekerjaan.*, pegawai.nama, users.username')
      ->from('pekerjaan')
      ->join('pegawai', 'pekerjaan.id_pegawai = pegawai.id_pegawai')
      ->join('users', 'pekerjaan.created_id = users.user_id')
      ->where('pekerjaan.id_pegawai', $id)
      ->order_by('pekerjaan.deadline', 'ASC');

    // Tambahkan kondisi jika $jenis_pekerjaan ada
    if ($jenis_pekerjaan !== null) {
        $this->db->where('pekerjaan.jenis_pekerjaan', $jenis_pekerjaan);
    }

    return $this->db->get()->result_array();
  }
}
