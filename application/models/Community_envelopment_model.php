<?php
class Community_envelopment_model extends CI_Model {

  private $table = 'community_envelopment';

  public function get_community_by_pegawai($id_pegawai) {
    $this->db
      ->select('community_envelopment.*, pegawai.nama')
      ->from('community_envelopment')
      ->join('pegawai', 'community_envelopment.id_pegawai = pegawai.id_pegawai')
      ->where('community_envelopment.id_pegawai', $id_pegawai)
      ->order_by('community_envelopment.tanggal_pelaksanaan', 'ASC');
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