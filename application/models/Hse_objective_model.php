<?php
class Hse_objective_model extends CI_Model {

  private $table = 'hse_objective';

  public function get_hse_by_pegawai($id_pegawai) {
    $this->db
      ->select('hse_objective.*, pegawai.nama')
      ->from('hse_objective')
      ->join('pegawai', 'hse_objective.id_pegawai = pegawai.id_pegawai')
      ->where('hse_objective.id_pegawai', $id_pegawai)
      ->order_by('hse_objective.tanggal_pelaksanaan', 'ASC');
    return $this->db->get()->result_array();
  }

  public function insert($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($id, $data) {
    return $this->db->where('id', $id)->update($this->table, $data);
  }

  public function delete($id) {
    return $this->db->where('id', $id)->delete($this->table);
  }

  public function get_by_id($id) {
    return $this->db->where('id', $id)->get($this->table)->row();
  }
}