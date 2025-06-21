<?php
class Development_commitment_model extends CI_Model {

  private $table = 'dev_commitment';

  public function get_development_by_pegawai($id_pegawai) {
    $this->db
      ->select('dev_commitment.*, pegawai.nama')
      ->from('dev_commitment')
      ->join('pegawai', 'dev_commitment.id_pegawai = pegawai.id_pegawai')
      ->where('dev_commitment.id_pegawai', $id_pegawai)
      ->order_by('dev_commitment.tanggal_pelaksanaan', 'ASC');
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