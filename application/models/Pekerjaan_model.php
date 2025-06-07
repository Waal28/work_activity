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
}
