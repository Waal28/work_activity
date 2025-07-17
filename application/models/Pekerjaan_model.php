<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pekerjaan_model extends CI_Model
{

  private $table = 'pekerjaan';

  public function get_all($payload = null)
  {
    $this->db->select('
      pekerjaan.*, 
      pegawai.nama, 
      pegawai.id_pegawai,
      (
        SELECT COUNT(*) 
        FROM riwayat_delegasi_pekerjaan 
        WHERE riwayat_delegasi_pekerjaan.pekerjaan_id = pekerjaan.pekerjaan_id
      ) > 0 AS is_delegasi
    ', false);


    $this->db->from('pekerjaan');
    $this->db->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id');
    $this->db->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai');
    $this->db->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai', 'left');

    $this->db->order_by('deadline', 'ASC');

    // Filter opsional
    if (!empty($payload['id_unit_level'])) {
      $this->db->where('pegawai_penempatan.id_unit_level', $payload['id_unit_level']);
    }
    if (!empty($payload['id_unit_kerja'])) {
      $this->db->where('pegawai_penempatan.id_unit_kerja', $payload['id_unit_kerja']);
    }
    if (!empty($payload['created_id'])) {
      $this->db->where('pekerjaan.created_id', $payload['created_id']);
    }

    return $this->db->get()->result_array();
  }


  public function get_by_id($id)
  {
    return $this->db->where('pekerjaan_id', $id)->get($this->table)->row();
  }

  public function get_pekerjaan_pegawai_by_pekerjaan_id($id)
  {
    $this->db
      ->select('pekerjaan_pegawai.*, pegawai.nama')
      ->from('pekerjaan_pegawai')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->where('pekerjaan_id', $id);

    return $this->db->get()->result_array(); // ambil semua data
  }

  public function insert($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($id, $data)
  {
    return $this->db->where('pekerjaan_id', $id)->update($this->table, $data);
  }

  public function delete($id)
  {
    $this->db->trans_start();

    // 1. hapus relasi anak lebih dulu
    $this->db->where('pekerjaan_id', $id)
      ->delete('pekerjaan_pegawai');

    // 2. hapus record induk
    $this->db->where('pekerjaan_id', $id)
      ->delete('pekerjaan');

    $this->db->trans_complete();

    return $this->db->trans_status(); // true = sukses, false = rollback
  }

  public function insert_pekerjaan_pegawai($data)
  {
    $this->db->insert('pekerjaan_pegawai', $data);
  }

  public function update_pekerjaan_pegawai($where = [])
  {
    if (empty($where)) return false;

    $this->db->from('pekerjaan_pegawai');

    foreach ($where as $key => $value) {
      if (is_array($value)) {
        $this->db->where_in($key, $value);
      } else {
        $this->db->where($key, $value);
      }
    }

    return $this->db->update();
  }

  public function delete_pekerjaan_pegawai($where = [])
  {
    if (empty($where)) return false;

    $this->db->from('pekerjaan_pegawai');

    foreach ($where as $key => $value) {
      if (is_array($value)) {
        $this->db->where_in($key, $value);
      } else {
        $this->db->where($key, $value);
      }
    }

    return $this->db->delete();
  }



  public function get_by_id_pegawai($id_pegawai, $payload = [])
  {
    $this->db
      ->select('pekerjaan.*, pegawai.nama')
      ->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->join('users', 'pekerjaan.created_id = users.id_pegawai')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->order_by('pekerjaan.deadline', 'ASC');

    if (!empty($payload['jenis_pekerjaan'])) {
      $this->db->where('pekerjaan.jenis_pekerjaan', $payload['jenis_pekerjaan']);
    }
    if (!empty($payload['status'])) {
      $this->db->where('pekerjaan.status', $payload['status']);
    }
    if (!empty($payload['tipe_pelaksanaan'])) {
      $this->db->where('pekerjaan.tipe_pelaksanaan', $payload['tipe_pelaksanaan']);
    }

    return $this->db->get()->result_array();
  }

  public function get_delegasi_pekerjaan($where = [])
  {
    $this->db
      ->select('
      p.*, 
      rdp.id AS delegasi_id,
      rdp.dari_id_pegawai, 
      rdp.ke_id_pegawai, 
      rdp.tanggal_delegasi,
      dari_peg.nama AS dari_nama_pegawai, 
      ke_peg.nama AS ke_nama_pegawai
    ')
      ->from('pekerjaan p')
      ->join('riwayat_delegasi_pekerjaan rdp', 'p.pekerjaan_id = rdp.pekerjaan_id')
      ->join('pegawai dari_peg', 'rdp.dari_id_pegawai = dari_peg.id_pegawai')
      ->join('pegawai ke_peg', 'rdp.ke_id_pegawai = ke_peg.id_pegawai');

    if (!empty($where['pekerjaan_id'])) {
      $this->db->where('rdp.pekerjaan_id', $where['pekerjaan_id']);
    }
    if (!empty($where['id_pegawai'])) {
      $this->db->where('rdp.dari_id_pegawai', $where['id_pegawai']);
    }
    if (!empty($where['ke_id_pegawai'])) {
      $this->db->where('rdp.ke_id_pegawai', $where['ke_id_pegawai']);
    }

    return $this->db->get()->result_array();
  }


  public function insert_delegasi_pekerjaan($data)
  {
    $this->db->insert('riwayat_delegasi_pekerjaan', $data);
  }

  public function update_delegasi_pekerjaan($where = [])
  {
    if (empty($where)) return false;

    $this->db->from('riwayat_delegasi_pekerjaan');

    foreach ($where as $key => $value) {
      if (is_array($value)) {
        $this->db->where_in($key, $value);
      } else {
        $this->db->where($key, $value);
      }
    }

    return $this->db->update();
  }

  public function delete_delegasi_pekerjaan($where = [])
  {
    if (empty($where)) return false;

    $this->db->from('riwayat_delegasi_pekerjaan');

    foreach ($where as $key => $value) {
      if (is_array($value)) {
        $this->db->where_in($key, $value);
      } else {
        $this->db->where($key, $value);
      }
    }

    return $this->db->delete();
  }
}
