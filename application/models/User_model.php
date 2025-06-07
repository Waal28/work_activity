<?php
class User_model extends CI_Model {
  public function get_user($username, $password) {
    $this->db->select('users.*, roles.role_name, roles.role_desc, pegawai.nama');
    $this->db->from('users');
    $this->db->join('roles', 'users.role_id = roles.role_id');
    $this->db->join('pegawai', 'users.id_pegawai = pegawai.id_pegawai', 'left');
    $this->db->where('username', $username);
    $this->db->where('password', $password);
    return $this->db->get()->row();
  }
}