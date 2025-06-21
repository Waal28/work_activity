<!-- <?=
  '<pre>';
  print_r($rows);
  '</pre>';
?> -->

<form action="<?= site_url('abs/update') ?>" method="post">
    <table class="table table-bordered border-dark">
        <thead class="thead-dark text-center align-middle">
            <tr>
                <th rowspan="2">Core Values</th>
                <th rowspan="2">No.</th>
                <th rowspan="2">Panduan Perilaku</th>
                <th colspan="5">Tingkat Kecakapan</th>
            </tr>
            <tr>
                <th>Membutuhkan banyak pengembangan</th>
                <th>Masih perlu dikembangkan</th>
                <th>Efektif</th>
                <th>Sangat Efektif</th>
                <th>Belum memunculkan perilaku</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $last_core_value = '';
            $rowspan_count = [];

            // Hitung rowspan per core_value_id
            foreach ($rows as $row) {
                $core_value_id = $row['core_value_id'];
                if (!isset($rowspan_count[$core_value_id])) {
                    $rowspan_count[$core_value_id] = 0;
                }
                $rowspan_count[$core_value_id]++;
            }

            foreach ($rows as $row):
                $core_value_id = $row['core_value_id'];
                $is_first = ($last_core_value !== $core_value_id);
                $behavior_id = $row['behavior_id'];
                $selected_level = $row['level_label'];
                $level_id = $row['level_id'];
                $assessment_id = $row['assessment_id'];
            ?>
            <tr>
                <?php if ($is_first): ?>
                    <td rowspan="<?= $rowspan_count[$core_value_id] ?>">
                        <strong><?= $row['core_value_nama'] ?></strong><br>
                        <small><?= $row['core_value_arti'] ?></small>
                    </td>
                <?php endif; ?>

                <td class="text-center"><?= $row['no_urut'] ?></td>
                <td><?= $row['behavior_deskripsi'] ?></td>

                <?php
                $levels = [
                    1 => 'Membutuhkan banyak pengembangan',
                    2 => 'Masih perlu dikembangkan',
                    3 => 'Efektif',
                    4 => 'Sangat Efektif',
                    5 => 'Belum memunculkan perilaku'
                ];
                foreach ($levels as $id => $label) {
                    $value = $id . '|' . $assessment_id;
                    $checked = ($selected_level === $label) ? 'checked' : '';
                    echo '<td class="text-center">';
                    echo '<input type="radio" name="levels[' . $behavior_id . ']" value="' . $value . '" ' . $checked . '>';
                    echo '</td>';
                }
                ?>
            </tr>
            <?php
                $last_core_value = $core_value_id;
            endforeach;
            ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>

