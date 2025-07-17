<!-- <?=
        '<pre>';
        print_r($pegawai_list);
        '</pre>';
        ?> -->
<?php
$role = $this->session->userdata('role');
?>
<div id="detailPegawai">
    <div class="row mb-5">
        <div class="col-2 mb-3">
            <span class="fs-6 fw-semibold">Nama Pegawai</span>
        </div>
        <div class="col-10 mb-3 d-flex align-items-center">:
            <select id="selectPegawai" class="form-select ms-3">
                <?php if (empty($pegawai_list)): ?>
                    <option value="">Tidak ada pegawai</option>
                <?php else: ?>
                    <?php
                    // Kelompokkan data berdasarkan nm_unit_level
                    $grouped_pegawai = [];
                    foreach ($pegawai_list as $pegawai) {
                        $grouped_pegawai[$pegawai['nm_unit_level']][] = $pegawai;
                    }
                    ?>
                    <?php foreach ($grouped_pegawai as $unit_level => $pegawais): ?>
                        <optgroup label="<?= htmlspecialchars($unit_level); ?>">
                            <?php foreach ($pegawais as $pegawai): ?>
                                <option
                                    value="<?= $pegawai['id_pegawai']; ?>"
                                    <?= ($pegawai['id_pegawai'] == $current_pegawai['id_pegawai']) ? 'selected' : ''; ?>>
                                    <?= $pegawai['nama'] . ' | ' . $pegawai['nm_unit_kerja']; ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
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
            <span class="fs-6 fw-semibold">periode</span>
        </div>
        <div class="col-10 mb-3 d-flex align-items-center">:
            <select id="selectPeriode" class="form-select ms-3" readonly>
                <option value="2025" selected>2025</option>
            </select>
        </div>
    </div>
    <form method="post" action="<?= base_url('abs/simpan') ?>">
        <input type="hidden" name="id_pegawai" value="<?= empty($current_pegawai['id_pegawai']) ? '' : $current_pegawai['id_pegawai']; ?>">
        <input type="hidden" id="inputperiode" name="periode" value="2025">

        <table class="table table-bordered border-dark">
            <thead class="thead-dark text-center align-middle">
                <tr>
                    <th rowspan="2">Core Values</th>
                    <th rowspan="2">No</th>
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
                // 1. Hitung jumlah perilaku per core_value
                $counts = [];
                foreach ($perilaku as $p) {
                    $cv = $p->core_value_nama;
                    if (!isset($counts[$cv])) {
                        $counts[$cv] = 0;
                    }
                    $counts[$cv]++;
                }

                $rendered_cv = []; // Penanda untuk mencegah cetak ulang core_value
                $no = 1;

                foreach ($perilaku as $p):
                    $cv = $p->core_value_nama;
                ?>
                    <tr>
                        <?php if (!in_array($cv, $rendered_cv)): ?>
                            <td rowspan="<?= $counts[$cv] ?>">
                                <strong><?= $p->core_value_nama ?></strong><br>
                                (<?= $p->core_value_arti ?>)
                            </td>
                            <?php $rendered_cv[] = $cv; ?>
                        <?php endif; ?>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $p->deskripsi ?></td>
                        <?php
                        $levels = ['Membutuhkan banyak pengembangan', 'Masih perlu dikembangkan', 'Efektif', 'Sangat Efektif', 'Belum memunculkan perilaku'];
                        foreach ($levels as $level): ?>
                            <td class="text-center align-middle">
                                <input type="radio" name="perilaku[<?= $p->id ?>]" value="<?= $level ?>" <?= empty($pegawai_list) ? 'disabled' : '' ?>>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 style="margin: 50px 0 20px;">GENERAL COMMENT</h4>
        <div class="row">
            <div class="col-6 mb-5">
                <label class="fw-semibold mb-3">1. Area kekuatan utama</label><br>
                <textarea name="area_kekuatan" placeholder="Area kekuatan utama" rows="2" class="form-control" style="width: 100%" <?= empty($pegawai_list) ? 'disabled' : '' ?>></textarea>
            </div>
            <div class="col-6 mb-5">
                <label class="fw-semibold mb-3">2. Area yang masih harus dikembangkan</label><br>
                <textarea name="area_pengembangan" placeholder="Area yang masih harus dikembangkan" rows="2" class="form-control" style="width: 100%" <?= empty($pegawai_list) ? 'disabled' : '' ?>></textarea>
            </div>
            <div class="col-12 mb-5">
                <label class="fw-semibold mb-3">3. Komentar Umum</label><br>
                <textarea name="komentar_umum" placeholder="Komentar Umum" rows="4" class="form-control" style="width: 100%" <?= empty($pegawai_list) ? 'disabled' : '' ?>></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mt-5" <?= empty($pegawai_list) ? 'disabled' : '' ?>>Simpan Penilaian</button>
        </div>
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
                    id: idPegawai,
                    t: new Date().getTime() // anti-cache
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
    $(document).on('change', '#selectPeriode', function() {
        $('#inputperiode').val(this.value);
    });
</script>