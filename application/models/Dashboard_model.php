<?php
class Dashboard_model extends CI_Model
{
  public function get_summary_card($id_pegawai)
  {
    $summary = [];

    // --- PEKERJAAN ---
    $this->db->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai);
    $total_pekerjaan = $this->db->count_all_results();

    $this->db->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->where('pekerjaan.status', 'Done');
    $pekerjaan_selesai = $this->db->count_all_results();

    $summary['pekerjaan'] = [
      'total_pekerjaan' => $total_pekerjaan,
      'pekerjaan_selesai' => $pekerjaan_selesai,
    ];

    // --- COMMUNITY ENVELOPMENT ---
    // 1. Total Point
    $this->db->select_sum('community_envelopment.point');
    $this->db->from('community_envelopment');
    $this->db->where('community_envelopment.id_pegawai', $id_pegawai);
    $total_point_ce = $this->db->get()->row()->point ?? 0;

    // 2. Total Aktivitas (count)
    $this->db->from('community_envelopment');
    $this->db->where('community_envelopment.id_pegawai', $id_pegawai);
    $aktivitas_ce = $this->db->count_all_results();

    $summary['community_envelopment'] = [
      'total_point' => (int)$total_point_ce,
      'aktivitas' => $aktivitas_ce,
    ];

    // --- DEV COMMITMENT ---
    // 1. Total Point
    $this->db->select_sum('dev_commitment.lh');
    $this->db->from('dev_commitment');
    $this->db->where('dev_commitment.id_pegawai', $id_pegawai);
    $total_lh_dc = $this->db->get()->row()->lh ?? 0;

    // 2. Total Aktivitas (count)
    $this->db->from('dev_commitment');
    $this->db->where('dev_commitment.id_pegawai', $id_pegawai);
    $aktivitas_dc = $this->db->count_all_results();

    $summary['dev_commitment'] = [
      'total_lh' => (int)$total_lh_dc,
      'aktivitas' => $aktivitas_dc,
    ];

    // --- HSE OBJECTIVE ---
    // 1. Total Point
    $this->db->select_sum('hse_objective.point');
    $this->db->from('hse_objective');
    $this->db->where('hse_objective.id_pegawai', $id_pegawai);
    $total_point_hse = $this->db->get()->row()->point ?? 0;

    // 2. Total Aktivitas (count)
    $this->db->from('hse_objective');
    $this->db->where('hse_objective.id_pegawai', $id_pegawai);
    $aktivitas_hse = $this->db->count_all_results();

    $summary['hse_objective'] = [
      'total_point' => (int)$total_point_hse,
      'aktivitas' => $aktivitas_hse,
    ];

    return $summary;
  }
  public function get_summary_card_last_week($id_pegawai)
  {
    $summary = [];
    $seven_days_ago = date('Y-m-d H:i:s', strtotime('-7 days'));

    // --- PEKERJAAN ---
    $this->db->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->where('pekerjaan.deadline >=', $seven_days_ago);
    $total_pekerjaan = $this->db->count_all_results();

    $this->db->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->where('pekerjaan.status', 'Done')
      ->where('pekerjaan.deadline >=', $seven_days_ago);
    $pekerjaan_selesai = $this->db->count_all_results();

    $summary['pekerjaan'] = [
      'total_pekerjaan' => $total_pekerjaan,
      'pekerjaan_selesai' => $pekerjaan_selesai,
    ];

    // --- COMMUNITY ENVELOPMENT ---
    $this->db->select_sum('community_envelopment.point');
    $this->db->from('community_envelopment');
    $this->db->where('community_envelopment.id_pegawai', $id_pegawai);
    $this->db->where('community_envelopment.created_at >=', $seven_days_ago);
    $total_point_ce = $this->db->get()->row()->point ?? 0;

    $this->db->from('community_envelopment');
    $this->db->where('community_envelopment.id_pegawai', $id_pegawai);
    $this->db->where('community_envelopment.created_at >=', $seven_days_ago);
    $aktivitas_ce = $this->db->count_all_results();

    $summary['community_envelopment'] = [
      'total_point' => (int)$total_point_ce,
      'aktivitas' => $aktivitas_ce,
    ];

    // --- DEV COMMITMENT ---
    $this->db->select_sum('dev_commitment.lh');
    $this->db->from('dev_commitment');
    $this->db->where('dev_commitment.id_pegawai', $id_pegawai);
    $this->db->where('dev_commitment.created_at >=', $seven_days_ago);
    $total_lh_dc = $this->db->get()->row()->lh ?? 0;

    $this->db->from('dev_commitment');
    $this->db->where('dev_commitment.id_pegawai', $id_pegawai);
    $this->db->where('dev_commitment.created_at >=', $seven_days_ago);
    $aktivitas_dc = $this->db->count_all_results();

    $summary['dev_commitment'] = [
      'total_lh' => (int)$total_lh_dc,
      'aktivitas' => $aktivitas_dc,
    ];

    // --- HSE OBJECTIVE ---
    $this->db->select_sum('hse_objective.point');
    $this->db->from('hse_objective');
    $this->db->where('hse_objective.id_pegawai', $id_pegawai);
    $this->db->where('hse_objective.created_at >=', $seven_days_ago);
    $total_point_hse = $this->db->get()->row()->point ?? 0;

    $this->db->from('hse_objective');
    $this->db->where('hse_objective.id_pegawai', $id_pegawai);
    $this->db->where('hse_objective.created_at >=', $seven_days_ago);
    $aktivitas_hse = $this->db->count_all_results();

    $summary['hse_objective'] = [
      'total_point' => (int)$total_point_hse,
      'aktivitas' => $aktivitas_hse,
    ];

    return $summary;
  }

  public function get_metrik($id_pegawai)
  {
    $query = $this->db
      ->select('pekerjaan.*')
      ->from('pekerjaan')
      ->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id')
      ->join('pegawai', 'pekerjaan_pegawai.id_pegawai = pegawai.id_pegawai')
      ->where('pekerjaan_pegawai.id_pegawai', $id_pegawai)
      ->get(); // <- WAJIB ada ini

    $data = $query->result();

    $total = count($data);
    $jumlah_done = 0;
    $done_tepat_waktu = 0;
    $total_bobot_done = 0;
    $total_progress = 0;

    foreach ($data as $d) {
      if ($d->status === 'Done') {
        $jumlah_done++;
        $total_bobot_done += $d->bobot;

        if ($d->tanggal_selesai && $d->deadline && $d->tanggal_selesai <= $d->deadline) {
          $done_tepat_waktu++;
        }
      }

      if (in_array($d->status, ['In Progress', 'Pending', 'Done'])) {
        $total_progress++;
      }
    }

    return [
      'penyelesaian_tugas' => $total > 0 ? round(($jumlah_done / $total) * 100, 1) : 0,
      'tepat_waktu'        => $jumlah_done > 0 ? round(($done_tepat_waktu / $jumlah_done) * 100, 1) : 0,
      'rata_skor'          => $jumlah_done > 0 ? round($total_bobot_done / $jumlah_done, 1) : 0,
      'rata_progress'      => $total > 0 ? round(($total_progress / $total) * 100, 1) : 0,
    ];
  }
  public function get_monthly_activity_chart($id_pegawai, $month = null, $year = null, $priode = '2025')
  {
    if (!$year) $year = date('Y');

    // 1. Generate label dan rentang bulan (Jan - Jun atau sesuai)
    $labels = [];
    $months = [];
    for ($m = 1; $m <= $month; $m++) {
      $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT);
      $labels[] = date('M Y', strtotime("$year-$monthNum-01"));
      $months[] = "$year-$monthNum";
    }

    // 2. Fungsi bantu untuk menghitung per bulan
    $count_by_month = function ($table, $date_column, $join_type) use ($months, $id_pegawai, $priode) {
      $result = array_fill(0, count($months), 0);

      $this->db->select("DATE_FORMAT($date_column, '%Y-%m') AS bulan, COUNT(*) AS total");
      $this->db->from($table);

      if ($table === 'pekerjaan') {
        $this->db->join('pekerjaan_pegawai', 'pekerjaan.pekerjaan_id = pekerjaan_pegawai.pekerjaan_id');
        $this->db->where('pekerjaan_pegawai.id_pegawai', $id_pegawai);
      } elseif ($join_type === 'join_priode') {
        $this->db->join('priode_objectives', "$table.priode_objective_id = priode_objectives.id");
        $this->db->where('priode_objectives.priode', $priode);
        $this->db->where("$table.id_pegawai", $id_pegawai);
      }

      $this->db->where("$date_column >=", $months[0] . '-01');
      $this->db->where("$date_column <=", $months[count($months) - 1] . '-31');
      $this->db->group_by('bulan');

      $query = $this->db->get()->result();

      foreach ($query as $row) {
        $idx = array_search($row->bulan, $months);
        if ($idx !== false) {
          $result[$idx] = (int)$row->total;
        }
      }

      return $result;
    };

    return [
      'labels'     => $labels,
      'pekerjaan'  => $count_by_month('pekerjaan', 'pekerjaan.created_at', 'join_pekerjaan'),
      'community'  => $count_by_month('community_envelopment', 'community_envelopment.created_at', 'join_priode'),
      'development' => $count_by_month('dev_commitment', 'dev_commitment.created_at', 'join_priode'),
      'hsse'       => $count_by_month('hse_objective', 'hse_objective.created_at', 'join_priode'),
    ];
  }
}
