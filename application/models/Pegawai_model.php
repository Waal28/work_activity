<?php
class Pegawai_model extends CI_Model {
  public function get_pegawai() {
    $this->db->select('pegawai.id_pegawai, pegawai.nama');
    $this->db->from('pegawai');
    return $this->db->get()->result_array();
}

}