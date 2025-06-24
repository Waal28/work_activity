<?php
class Reports_model extends CI_Model
{

  // mengambil data laporan berdasarkan pegawai dan priode
  public function get_reports($id_pegawai, $priode = '2025')
  {
    // ambil semua objectives berdasarkan priode
    $objectives = $this->get_priode_objectives($priode);

    // tambahkan poin ke setiap objective
    foreach ($objectives as &$objective) {
      $priode_objective_id = $objective['id'];

      // ambil total poin dari masing-masing kategori
      $objective['hse_point']       = $this->get_hse_objective_point($id_pegawai, $priode_objective_id);
      $objective['dev_point']       = $this->get_dev_commitment_point($id_pegawai, $priode_objective_id);
      $objective['community_point'] = $this->get_community_point($id_pegawai, $priode_objective_id);
    }

    // kembalikan data pekerjaan dan objectives
    return [
      'pekerjaan'  => $this->get_pekerjaan_pegawai($id_pegawai),
      'objectives' => $objectives,
    ];
  }

  // mengambil data pekerjaan pegawai berdasarkan priode
  public function get_pekerjaan_pegawai($id_pegawai)
  {
    $this->db
      ->select('pekerjaan.*, pegawai.nama, users.username')
      ->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->join('users', 'pekerjaan.created_id = users.user_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->where('pekerjaan.jenis_pekerjaan', 'KPI')
      ->order_by('pekerjaan.deadline', 'asc');

    return $this->db->get()->result_array();
  }

  // mengambil daftar objectives berdasarkan priode
  public function get_priode_objectives($priode)
  {
    $this->db
      ->select('priode_objectives.*, objectives.nama_objective, objectives.deskripsi')
      ->from('priode_objectives')
      ->join('objectives', 'priode_objectives.id_objective = objectives.id')
      ->where('priode_objectives.priode', $priode)
      ->where_in('objectives.id', [1, 2, 3]);

    return $this->db->get()->result_array();
  }

  // menghitung total poin dari hse objective
  public function get_hse_objective_point($id_pegawai, $priode_objective_id)
  {
    $this->db
      ->select('sum(hse_objective.point) as total_poin')
      ->from('hse_objective')
      ->join('priode_objectives', 'hse_objective.priode_objective_id = priode_objectives.id')
      ->join('pegawai', 'hse_objective.id_pegawai = pegawai.id_pegawai')
      ->where('hse_objective.priode_objective_id', $priode_objective_id)
      ->where('hse_objective.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_poin : 0;
  }

  // menghitung total lh dari dev commitment
  public function get_dev_commitment_point($id_pegawai, $priode_objective_id)
  {
    $this->db
      ->select('sum(dev_commitment.lh) as total_lh')
      ->from('dev_commitment')
      ->join('priode_objectives', 'dev_commitment.priode_objective_id = priode_objectives.id')
      ->join('pegawai', 'dev_commitment.id_pegawai = pegawai.id_pegawai')
      ->where('dev_commitment.priode_objective_id', $priode_objective_id)
      ->where('dev_commitment.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_lh : 0;
  }

  // menghitung total poin dari community envelopment
  public function get_community_point($id_pegawai, $priode_objective_id)
  {
    $this->db
      ->select('sum(community_envelopment.point) as total_poin')
      ->from('community_envelopment')
      ->join('priode_objectives', 'community_envelopment.priode_objective_id = priode_objectives.id')
      ->join('pegawai', 'community_envelopment.id_pegawai = pegawai.id_pegawai')
      ->where('community_envelopment.priode_objective_id', $priode_objective_id)
      ->where('community_envelopment.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_poin : 0;
  }
}
