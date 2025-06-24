<?php
class User_model extends CI_Model
{
  public function get_user($username, $password)
  {
    $this->db->select('users.*, unit_level.nm_unit_level, unit_level.id_unit_level, unit_kerja.nm_unit_kerja, unit_kerja.id_unit_kerja, pegawai.*');
    $this->db->from('users');
    $this->db->join('pegawai_penempatan', 'users.id_pegawai = pegawai_penempatan.id_pegawai', 'left');
    $this->db->join('pegawai', 'pegawai_penempatan.id_pegawai = pegawai.id_pegawai', 'left');
    $this->db->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level', 'left');
    $this->db->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja', 'left');
    $this->db->where('users.username', $username);
    $this->db->where('users.password', $password); // perlu diganti ke password_verify untuk keamanan
    return $this->db->get()->row();
  }
}
