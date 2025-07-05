<?php
class Abs_model extends CI_Model
{
  public function getCoreValues()
  {
    return $this->db->get('core_values')->result();
  }

  public function get_all_perilaku()
  {
    $this->db->select('p.*, cv.nama as core_value_nama, cv.arti as core_value_arti');
    $this->db->from('perilaku p');
    $this->db->join('core_values cv', 'cv.id = p.core_value_id');
    $this->db->order_by('p.core_value_id, p.no_urut');
    return $this->db->get()->result();
  }

  public function getAllPenilaian($id_pemberi)
  {
    $this->db->select('penilaian_session.*, pegawai.nama as nama_pegawai, pegawai.nik as nik_pegawai, unit_level.nm_unit_level');
    $this->db->from('penilaian_session');
    $this->db->join('pegawai', 'pegawai.id_pegawai = penilaian_session.id_pegawai');
    $this->db->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai');
    $this->db->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level');
    $this->db->where('penilaian_session.id_pemberi', $id_pemberi);
    return $this->db->get()->result_array();
  }

  public function getDetailPenilaian($id_penilaian_session)
  {
    $penilaian_session = $this->db->select('penilaian_session.*, pegawai.nama as nama_pemberi, unit_level.nm_unit_level as jabatan_pemberi')
      ->join('pegawai', 'pegawai.id_pegawai = penilaian_session.id_pemberi')
      ->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai')
      ->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level')
      ->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja')
      ->where('penilaian_session.id', $id_penilaian_session)
      ->get('penilaian_session')
      ->row_array();

    if (!$penilaian_session) {
      return null; // atau lempar exception jika mau
    }

    $penilaian = $this->db->select('*')
      ->where('id_penilaian_session', $id_penilaian_session)
      ->get('penilaian')
      ->result_array();

    $pegawai = $this->db->select('pegawai.nama, pegawai.nik, unit_level.nm_unit_level, unit_kerja.nm_unit_kerja')
      ->join('pegawai_penempatan', 'pegawai.id_pegawai = pegawai_penempatan.id_pegawai')
      ->join('unit_level', 'pegawai_penempatan.id_unit_level = unit_level.id_unit_level')
      ->join('unit_kerja', 'pegawai_penempatan.id_unit_kerja = unit_kerja.id_unit_kerja')
      ->where('pegawai.id_pegawai', $penilaian_session['id_pegawai'])
      ->get('pegawai')
      ->row_array();

    $perilaku = $this->db->select('p.*, cv.nama as core_value_nama, cv.arti as core_value_arti')
      ->from('perilaku p')
      ->join('core_values cv', 'cv.id = p.core_value_id')
      ->order_by('p.core_value_id, p.no_urut')
      ->get()
      ->result_array();

    $komentar_penilaian = $this->db->select('k.id as id_komentar_penilaian, k.komentar_umum, k.area_kekuatan, k.area_pengembangan')
      ->from('komentar_penilaian k')
      ->where('k.id_penilaian_session', $id_penilaian_session)
      ->get()
      ->row_array();

    return [
      'penilaian_session' => $penilaian_session,
      'penilaian' => $penilaian,
      'pegawai' => $pegawai,
      'perilaku' => $perilaku,
      'komentar_penilaian' => $komentar_penilaian
    ];
  }


  public function delete($id)
  {
    // Hapus anak-anaknya dulu
    $this->db->where('id_penilaian_session', $id);
    $this->db->delete('komentar_penilaian');

    $this->db->where('id_penilaian_session', $id);
    $this->db->delete('penilaian');

    // Baru hapus parent-nya
    $this->db->where('id', $id);
    $this->db->delete('penilaian_session');
  }


  public function simpanPenilaian($post, $id_pemberi)
  {
    // Simpan ke penilaian_session
    $this->db->insert('penilaian_session', [
      'id_pegawai' => $post['id_pegawai'],
      'periode' => $post['periode'],
      'id_pemberi' => $id_pemberi,
    ]);

    // Ambil ID terakhir yang disisipkan
    $session_id = $this->db->insert_id();

    // Siapkan data penilaian
    $data = [];
    foreach ($post['perilaku'] as $id_perilaku => $skor) {
      $data[] = [
        'id_perilaku' => $id_perilaku,
        'id_penilaian_session' => $session_id,
        'skor' => $skor
      ];
    }

    // Simpan semua skor ke tabel penilaian
    $this->db->insert_batch('penilaian', $data);

    // Simpan komentar
    $komentar = [
      'id_penilaian_session' => $session_id,
      'komentar_umum' => $post['komentar_umum'],
      'area_kekuatan' => $post['area_kekuatan'],
      'area_pengembangan' => $post['area_pengembangan'],
    ];
    $this->db->insert('komentar_penilaian', $komentar);
  }
}
