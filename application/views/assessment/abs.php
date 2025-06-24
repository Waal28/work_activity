<!-- <?=
        '<pre>';
        print_r($current_pegawai);
        '</pre>';
        ?> -->
<?php
$role = $this->session->userdata('role');
?>
<div id="detailPegawai">
    <?php if ($role !== 'Staf'): ?>
        <div class="row mb-5">
            <div class="col-2 mb-3">
                <span class="fs-6 fw-semibold">Nama Pegawai</span>
            </div>
            <div class="col-10 mb-3 d-flex align-items-center">:
                <select id="selectPegawai" class="form-select ms-3 border-dark">
                    <?php if (empty($pegawai_list)): ?>
                        <option value="">Pegawai tidak ditemukan</option>
                    <?php else: ?>
                        <?php foreach ($pegawai_list as $pegawai): ?>
                            <option
                                value="<?= $pegawai['id_pegawai']; ?>"
                                <?= ($pegawai['id_pegawai'] == $current_pegawai['id_pegawai']) ? 'selected' : ''; ?>>
                                <?= $pegawai['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

            </div>
            <div class="col-2 mb-3">
                <span class="fs-6 fw-semibold">NIK</span>
            </div>
            <div class="col-10 mb-3 d-flex align-items-center">:
                <span class="fs-6 ms-3"><?= empty($current_pegawai['nik']) ? '-' : $current_pegawai['nik']; ?></span>
            </div>
            <div class="col-2 mb-3">
                <span class="fs-6 fw-semibold">Jabatan</span>
            </div>
            <div class="col-10 mb-3 d-flex align-items-center">:
                <span class="fs-6 ms-3"><?= empty($current_pegawai['nm_unit_level']) ? '-' : $current_pegawai['nm_unit_level']; ?></span>
            </div>
            <div class="col-2 mb-3">
                <span class="fs-6 fw-semibold">Priode</span>
            </div>
            <div class="col-10 mb-3 d-flex align-items-center">:
                <span class="fs-6 ms-3">-</span>
            </div>
        </div>
    <?php endif; ?>
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
                            $disabled = $role === 'Staf' || empty($pegawai_list) ? 'disabled' : '';

                            echo '<td class="text-center align-middle">';
                            echo '<input type="radio" class="form-check-input" name="levels[' . $behavior_id . ']" value="' . $value . '" ' . $checked . ' ' . $disabled . '>';
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

        <?php if ($role !== 'Staf'): ?>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" <?= empty($pegawai_list) ? 'disabled' : '' ?>>Simpan Perubahan</button>
            </div>
        <?php endif; ?>
    </form>
</div>

<script>
    $('#selectPegawai').on('change', function() {
        var idPegawai = $(this).val();
        if (idPegawai !== '') {
            $.ajax({
                url: '<?= base_url() . 'abs/detail_pegawai' ?>',
                type: 'POST',
                data: {
                    id: idPegawai
                },
                success: function(data) {
                    $('#detailPegawai').html(data);
                },
                error: function() {
                    $('#detailPegawai').html('<p style="color:red">Gagal mengambil data</p>');
                }
            });
        } else {
            $('#detailPegawai').html('');
        }
    });
</script>