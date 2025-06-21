<!-- <?=
  '<pre>';
  print_r($rows);
  '</pre>';
?> -->
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
              <td><?= rtrim(rtrim($item['bobot'], '0'), '.') ?>%</td>
              <td><?= $item['satuan'] ?></td>
              <td><?= rtrim(rtrim($item['annual_target'], '0'), '.') ?>%</td>
              <td><?= rtrim(rtrim($item['target_semester_1'], '0'), '.') ?>%</td>
              <td><?= rtrim(rtrim($item['target_semester_2'], '0'), '.') ?>%</td>
              <td><?= $realisasi ?>%</td>
              <td><?= $performance ?>%</td>
              <td><?= $weighted_performance ?>%</td>
            </tr>
          <?php else: ?>
            <tr>
              <td><?= $item['judul'] ?></td>
              <td><?= $item['freq_mon'] ?></td>
              <td><?= rtrim(rtrim($item['bobot'], '0'), '.') ?>%</td>
              <td><?= $item['satuan'] ?></td>
              <td><?= rtrim(rtrim($item['annual_target'], '0'), '.') ?>%</td>
              <td><?= rtrim(rtrim($item['target_semester_1'], '0'), '.') ?>%</td>
              <td><?= rtrim(rtrim($item['target_semester_2'], '0'), '.') ?>%</td>
              <td><?= $realisasi ?>%</td>
              <td><?= $performance ?>%</td>
              <td><?= $weighted_performance ?>%</td>
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
            <td><?= rtrim(rtrim($objective['bobot'], '0'), '.') ?>%</td>
            <td><?= $objective['satuan'] ?></td>
            <td><?= rtrim(rtrim($objective['annual_target'], '0'), '.') ?>%</td>
            <td><?= rtrim(rtrim($objective['target_semester_1'], '0'), '.') ?>%</td>
            <td><?= rtrim(rtrim($objective['target_semester_2'], '0'), '.') ?>%</td>
            <td><?= $realisasi ?>%</td>
            <td><?= $performance ?>%</td>
            <td><?= $weighted_performance ?>%</td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
        <tr>
          <td colspan="10"></td>
          <td class="bg-primary text-white fw-bold">
            <?= $weighted_performance_obj + $weighted_performance_kpi ?>%
          </td>
        </tr>
    </tbody>
  </table>
</div>
