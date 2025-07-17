<?php
class User_model extends CI_Model
{
  public function get_user($nik, $password)
  {
    $hashed_password = md5($password);
    $this->db->select('unit_level.nm_unit_level, unit_level.id_unit_level, unit_kerja.nm_unit_kerja, unit_kerja.id_unit_kerja, unit_bisnis.nm_unit_bisnis, unit_bisnis.id_unit_bisnis, pegawai.*');
    $this->db->from('users');
    $this->db->join('pegawai_penempatan', 'users.id_pegawai = pegawai_penempatan.id_pegawai', 'left');
    $this->db->join('pegawai', 'pegawai_penempatan.id_pegawai = pegawai.id_pegawai', 'left');
    $this->db->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level', 'left');
    $this->db->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja', 'left');
    $this->db->join('unit_bisnis', 'pegawai_penempatan.id_unit_bisnis = unit_bisnis.id_unit_bisnis', 'left');
    $this->db->where('pegawai.nik', $nik);
    $this->db->where('users.password', $hashed_password); // perlu diganti ke password_verify untuk keamanan
    return $this->db->get()->row();
  }

  public function generate_users_from_pegawai()
  {
    // Ambil semua data pegawai
    $pegawai_list = $this->db->get('pegawai')->result_array();

    foreach ($pegawai_list as $pegawai) {
      $id_pegawai = $pegawai['id_pegawai'];

      // Cek apakah user dengan id_pegawai ini sudah ada
      $existing = $this->db
        ->where('id_pegawai', $id_pegawai)
        ->get('users')
        ->row();

      // Jika belum ada, maka buat user baru
      if (!$existing) {
        $data = [
          'id_pegawai' => $id_pegawai,
          'password' => md5('12345'), // default password
        ];

        $this->db->insert('users', $data);
      }
    }

    return true;
  }
}
