<?php
class Rapat_model extends CI_Model
{

  private $table = 'rapat';

  public function get_data_rapat($where = [])
  {
    $this->db
      ->select('rapat.*, pegawai.nama as pemberi_rapat')
      ->from('rapat')
      ->join('pegawai', 'rapat.created_id = pegawai.id_pegawai')
      ->order_by('rapat.tanggal_rapat', 'ASC');

    foreach ($where as $key => $value) {
      if (is_array($value)) {
        $this->db->where_in($key, $value);
      } else {
        $this->db->where($key, $value);
      }
    }
    return $this->db->get()->result_array();
  }

  public function get_data_rapat_pegawai($where = [])
  {
    $this->db
      ->select('
      rapat.*, 
      pemberi.nama as pemberi_rapat, 
      penerima.nama as penerima_rapat
    ')
      ->from('rapat')
      ->join('rapat_pegawai', 'rapat.id = rapat_pegawai.rapat_id')
      ->join('pegawai as pemberi', 'rapat.created_id = pemberi.id_pegawai')
      ->join('pegawai as penerima', 'rapat_pegawai.id_pegawai = penerima.id_pegawai')
      ->order_by('rapat.tanggal_rapat', 'ASC');

    if (!empty($where['rapat_id'])) {
      $this->db->where('rapat_pegawai.rapat_id', $where['rapat_id']);
    }
    if (!empty($where['id_pegawai'])) {
      $this->db->where('rapat_pegawai.id_pegawai', $where['id_pegawai']);
    }
    if (!empty($where['status'])) {
      $this->db->where('rapat.status', $where['status']);
    }

    return $this->db->get()->result_array();
  }


  public function insert($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function insert_rapat_pegawai($data)
  {
    $this->db->insert('rapat_pegawai', $data);
  }

  public function update($id, $data)
  {
    return $this->db->where('id', $id)->update($this->table, $data);
  }

  public function delete($id)
  {
    return $this->db->where('id', $id)->delete($this->table);
  }

  public function get_by_id($id)
  {
    return $this->db->where('id', $id)->get($this->table)->row();
  }
}
