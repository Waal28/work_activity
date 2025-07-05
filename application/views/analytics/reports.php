<!-- <?=
      '<pre>';
      print_r($rows);
      '</pre>';
      ?> -->
<div class="d-flex align-items-center justify-content-end mb-5">
  <a href="<?= base_url('excel_export/generate') ?>" class="btn btn-success">
    <img src="https://api.iconify.design/tabler:file-excel.svg?color=%23ffffff" alt="..." style="min-width: 25px; min-height: 25px; margin-top: -5px">
    Export Excel
  </a>
</div>
<div style="max-width: 100%; max-height: 700px; overflow: auto">
  <table class="table table-bordered text-center align-middle" style="width: 100%">
    <thead class="table-success">
      <tr>
        <th rowspan="2">Aspek</th>
        <th rowspan="2">KPI</th>
        <th rowspan="2">Freq. Mon</th>
        <th rowspan="2">Bobot</th>
        <th rowspan="2">Satuan</th>
        <th rowspan="2">Annual Target</th>
        <th colspan="2">Target</th>
        <th rowspan="2">Realisasi</th>
        <th rowspan="2">Performance</th>
        <th rowspan="2">Weight Performance</th>
      </tr>
      <tr>
        <th>Semester I</th>
        <th>Semester II</th>
      </tr>
    </thead>
    <tbody>
      <!-- Cascading KPI Fungsi -->
      <?php
      $total_bobot_kpi = 0;
      $weighted_performance_obj = 0;
      $weighted_performance_kpi = 0;

      foreach ($rows['pekerjaan'] as $item) {
        $total_bobot_kpi += $item['bobot'];
      }
      ?>
      <?php if (empty($rows['pekerjaan'])): ?>
        <tr>
          <td class="bg-primary text-white fw-bold text-capitalize">cascading<br>kpi fungsi</td>
          <td class="text-center" colspan="11">Pekerjaan masih kosong</td>
        </tr>
      <?php else: ?>
        <?php foreach ($rows['pekerjaan'] as $index => $item): ?>
          <?php
          $realisasi = $item['target_semester_1'] + $item['target_semester_2'];
          $performance = hitung_performance($realisasi, $item['annual_target']);
          $weighted_performance = hitung_weighted_performance($performance, $item['bobot'], $total_bobot_kpi);
          $weighted_performance_kpi += $weighted_performance;
          ?>
          <?php if ($index === 0): ?>
            <tr>
              <td class="bg-primary text-white fw-bold text-capitalize" rowspan="<?= count($rows['pekerjaan']) ?>">cascading<br>kpi fungsi</td>
              <td><?= $item['judul'] ?></td>
              <td><?= $item['freq_mon'] ?></td>
              <td><?= formatAngka($item['bobot']) ?>%</td>
              <td><?= $item['satuan'] ?></td>
              <td><?= formatAngka($item['annual_target']) ?>%</td>
              <td><?= formatAngka($item['target_semester_1']) ?>%</td>
              <td><?= formatAngka($item['target_semester_2']) ?>%</td>
              <td><?= $realisasi ?>%</td>
              <td><?= number_format($performance, 2) ?>%</td>
              <td><?= number_format($weighted_performance, 2) ?>%</td>
            </tr>
          <?php else: ?>
            <tr>
              <td><?= $item['judul'] ?></td>
              <td><?= $item['freq_mon'] ?></td>
              <td><?= formatAngka($item['bobot']) ?>%</td>
              <td><?= $item['satuan'] ?></td>
              <td><?= formatAngka($item['annual_target']) ?>%</td>
              <td><?= formatAngka($item['target_semester_1']) ?>%</td>
              <td><?= formatAngka($item['target_semester_2']) ?>%</td>
              <td><?= $realisasi ?>%</td>
              <td><?= number_format($performance, 2) ?>%</td>
              <td><?= number_format($weighted_performance, 2) ?>%</td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>

      <!-- Objectives -->
      <?php
      $total_bobot_obj = 0;
      foreach ($rows['objectives'] as $item) {
        $total_bobot_obj += $item['bobot'];
      }
      ?>
      <?php if ($this->session->userdata('role') === 'Staf'): ?>
        <?php if (empty($rows['objectives'])): ?>
          <tr>
            <td class="bg-primary text-white fw-bold text-capitalize">Objectives</td>
            <td class="text-center" colspan="11">Objectives masih kosong</td>
          </tr>
        <?php else: ?>
          <?php foreach ($rows['objectives'] as $objective): ?>
            <?php
            $realisasi = $objective['target_semester_1'] + $objective['target_semester_2'];
            $performance = $objective['hse_point'] + $objective['dev_point'] + $objective['community_point'];
            $weighted_performance = hitung_weighted_performance($performance, $objective['bobot'], $total_bobot_obj);
            $weighted_performance_obj += $weighted_performance;
            ?>
            <tr>
              <td class="bg-primary text-white fw-bold"><?= $objective['nama_objective'] ?></td>
              <td><?= $objective['deskripsi'] ?></td>
              <td><?= $objective['freq_mon'] ?></td>
              <td><?= formatAngka($objective['bobot']) ?>%</td>
              <td><?= $objective['satuan'] ?></td>
              <td><?= formatAngka($objective['annual_target']) ?>%</td>
              <td><?= formatAngka($objective['target_semester_1']) ?>%</td>
              <td><?= formatAngka($objective['target_semester_2']) ?>%</td>
              <td><?= $realisasi ?>%</td>
              <td><?= number_format($performance, 2) ?>%</td>
              <td><?= number_format($weighted_performance, 2) ?>%</td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
      <tr>
        <td colspan="10"></td>
        <td class="bg-primary text-white fw-bold">
          <?= number_format($weighted_performance_obj + $weighted_performance_kpi, 2) ?>%
        </td>
      </tr>
    </tbody>
  </table>
</div>