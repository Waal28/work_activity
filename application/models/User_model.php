<?php
class User_model extends CI_Model {
  public function get_user($username, $password) {
    $this->db->select('users.*, unit_level.nm_unit_level, pegawai.*');
    $this->db->from('users');
    $this->db->join('pegawai', 'users.id_pegawai = pegawai.id_pegawai', 'left');
    $this->db->join('unit_level', 'pegawai.id_unit_level = unit_level.id_unit_level', 'left');
    $this->db->where('users.username', $username);
    $this->db->where('users.password', $password); // perlu diganti ke password_verify untuk keamanan
    return $this->db->get()->row();
  }
}