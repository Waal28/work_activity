<?php
class Abs_model extends CI_Model {
  public function get_core_values_pegawai($id_pegawai) {
    // Jika belum ada penilaian, isi default
    if ($this->check_penilaian_pegawai($id_pegawai) == 0) {
        $this->insert_default_penilaian($id_pegawai);
    }

    $this->db->select('
        cv.id AS core_value_id,
        cv.nama AS core_value_nama,
        cv.arti AS core_value_arti,
        b.id AS behavior_id,
        b.no_urut,
        b.deskripsi AS behavior_deskripsi,
        al.label AS level_label,
        ba.tanggal,
        ba.level_id,
        ba.id AS assessment_id,
    ');
    $this->db->from('behavior_assessments ba');
    $this->db->join('behaviors b', 'ba.behavior_id = b.id');
    $this->db->join('core_values cv', 'b.core_value_id = cv.id');
    $this->db->join('assessment_levels al', 'ba.level_id = al.id');
    $this->db->where('ba.id_pegawai', $id_pegawai);
    $this->db->order_by('cv.id, b.no_urut');

    return $this->db->get()->result_array();
  }

  public function check_penilaian_pegawai($id_pegawai) {
    return $this->db->where('id_pegawai', $id_pegawai)
                    ->count_all_results('behavior_assessments');
  }

  public function insert_default_penilaian($id_pegawai, $default_level_id = 5) {
    // Ambil semua perilaku
    $behaviors = $this->db->get('behaviors')->result_array();

    $data = [];
    $today = date('Y-m-d');

    foreach ($behaviors as $b) {
        $data[] = [
            'id_pegawai' => $id_pegawai,
            'behavior_id' => $b['id'],
            'level_id' => $default_level_id,
            'tanggal' => $today
        ];
    }

    if (!empty($data)) {
        $this->db->insert_batch('behavior_assessments', $data);
    }
  }

  public function update_behavior_assessments($data_array)
  {
    foreach ($data_array as $item) {
      $this->db->where('id', $item['assessment_id']);
      $this->db->update('behavior_assessments', [
          'level_id' => $item['level_id'],
      ]);
    }
  }


}