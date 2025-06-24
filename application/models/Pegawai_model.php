<?php
class Pegawai_model extends CI_Model
{
  public function get_pegawai($payload = null)
  {
    $this->db->select('pegawai.id_pegawai, pegawai.nama');
    $this->db->from('pegawai');
    $this->db->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai', 'left');
    $this->db->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level', 'left');
    $this->db->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja', 'left');
    if (!empty($payload['id_unit_kerja'])) {
      $this->db->where('pegawai_penempatan.id_unit_kerja', $payload['id_unit_kerja']);
    }
    if (!empty($payload['id_unit_level'])) {
      $this->db->where('pegawai_penempatan.id_unit_level', $payload['id_unit_level']);
    }
    return $this->db->get()->result_array();
  }
  public function get_details_pegawai($id_pegawai)
  {
    $this->db->select('pegawai.id_pegawai, pegawai.nama, pegawai.nik, unit_kerja.nm_unit_kerja, unit_level.nm_unit_level');
    $this->db->from('pegawai');
    $this->db->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai', 'left');
    $this->db->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level', 'left');
    $this->db->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja', 'left');
    $this->db->where('pegawai.id_pegawai', $id_pegawai);
    return $this->db->get()->row_array();
  }
}
