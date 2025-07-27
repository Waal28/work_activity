<?php
class Reports_model extends CI_Model
{

  // mengambil data laporan berdasarkan pegawai dan periode
  public function get_reports($id_pegawai, $periode = '2025')
  {
    // ambil semua objectives berdasarkan periode
    $objectives = $this->get_periode_objectives($periode);

    // tambahkan poin ke setiap objective
    foreach ($objectives as &$objective) {
      $periode_objective_id = $objective['id'];

      // ambil total poin dari masing-masing kategori
      $objective['hse_point']       = $this->get_hse_objective_point($id_pegawai, $periode_objective_id);
      $objective['dev_point']       = $this->get_dev_commitment_point($id_pegawai, $periode_objective_id);
      $objective['community_point'] = $this->get_community_point($id_pegawai, $periode_objective_id);
    }

    // kembalikan data pekerjaan dan objectives
    return [
      'pekerjaan'  => $this->get_pekerjaan_pegawai($id_pegawai),
      'objectives' => $objectives,
    ];
  }

  // mengambil data pekerjaan pegawai berdasarkan periode
  public function get_pekerjaan_pegawai($id_pegawai)
  {
    $this->db
      ->select('pekerjaan.*, pegawai.nama')
      ->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->join('users', 'pekerjaan.created_id = users.id_pegawai')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->where('pekerjaan.jenis_pekerjaan', 'KPI')
      ->order_by('pekerjaan.deadline', 'asc');

    return $this->db->get()->result_array();
  }

  // mengambil daftar objectives berdasarkan periode
  public function get_periode_objectives($periode)
  {
    $this->db
      ->select('periode_objectives.*, objectives.nama_objective, objectives.deskripsi')
      ->from('periode_objectives')
      ->join('objectives', 'periode_objectives.id_objective = objectives.id')
      ->where('periode_objectives.periode', $periode)
      ->where_in('objectives.id', [1, 2, 3]);

    return $this->db->get()->result_array();
  }

  // menghitung total poin dari hse objective
  public function get_hse_objective_point($id_pegawai, $periode_objective_id)
  {
    $this->db
      ->select('sum(hse_objective.point) as total_poin')
      ->from('hse_objective')
      ->join('periode_objectives', 'hse_objective.periode_objective_id = periode_objectives.id')
      ->join('pegawai', 'hse_objective.id_pegawai = pegawai.id_pegawai')
      ->where('hse_objective.periode_objective_id', $periode_objective_id)
      ->where('hse_objective.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_poin : 0;
  }

  // menghitung total lh dari dev commitment
  public function get_dev_commitment_point($id_pegawai, $periode_objective_id)
  {
    $this->db
      ->select('sum(dev_commitment.lh) as total_lh')
      ->from('dev_commitment')
      ->join('periode_objectives', 'dev_commitment.periode_objective_id = periode_objectives.id')
      ->join('pegawai', 'dev_commitment.id_pegawai = pegawai.id_pegawai')
      ->where('dev_commitment.periode_objective_id', $periode_objective_id)
      ->where('dev_commitment.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_lh : 0;
  }

  // menghitung total poin dari community involvement
  public function get_community_point($id_pegawai, $periode_objective_id)
  {
    $this->db
      ->select('sum(community_involvement.point) as total_poin')
      ->from('community_involvement')
      ->join('periode_objectives', 'community_involvement.periode_objective_id = periode_objectives.id')
      ->join('pegawai', 'community_involvement.id_pegawai = pegawai.id_pegawai')
      ->where('community_involvement.periode_objective_id', $periode_objective_id)
      ->where('community_involvement.id_pegawai', $id_pegawai);

    $query = $this->db->get()->row();
    return $query ? (float) $query->total_poin : 0;
  }
}
