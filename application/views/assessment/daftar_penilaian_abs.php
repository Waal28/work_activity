<div class="card mb-5 mb-xl-12">
  <div class="card-body py-3">
    <div class="table-responsive">
      <table class="table align-middle gs-0 gy-4">
        <thead>
          <tr class="fw-bold thead-tabel-objective">
            <th class="ps-4 rounded-start">No</th>
            <th>Nama Pegawai</th>
            <th>NIK</th>
            <th>Jabatan</th>
            <th>Periode</th>
            <th>Tanggal Penilaian</th>
            <!-- <th>Total Skor</th> -->
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $index => $row): ?>
              <tr>
                <td class="ps-4 rounded-start"><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['nama_pegawai']) ?></td>
                <td><?= htmlspecialchars($row['nik_pegawai']) ?></td>
                <td><?= htmlspecialchars($row['nm_unit_level']) ?></td>
                <td><span class="badge badge-light-primary fs-7 fw-bold border border-primary"><?= !empty($row['periode']) ? htmlspecialchars($row['periode']) : '-' ?></span></td>
                <td><?= !empty($row['created_at']) ? formatTanggalIndo($row['created_at']) : '-' ?></td>
                <!-- <td><span class="badge badge-light-primary fs-7 fw-bold">80</span></td> -->
                <td>
                  <button type="button"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                    onclick="window.location.href='<?= base_url('abs/detail/' . $row['id']) ?>'">
                    <img src="https://api.iconify.design/bx:show-alt.svg?color=%230d6efd" alt="..." style="min-width: 25px; min-height: 25px">
                  </button>
                  <button
                    type="button"
                    data-bs-toggle="modal"
                    data-bs-target="#modalKonfirmasiHapus"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                    data-href="<?= base_url('abs/delete/' . $row['id']) ?>">
                    <i class="ki-duotone ki-trash fs-2 text-danger">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                    </i>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">
                <div class="d-flex flex-column align-items-center" style="margin-top: 100px;">
                  <img src="https://api.iconify.design/line-md:coffee-half-empty-filled-loop.svg?color=%23000" alt="..." style="width: 100px; height: 100px">
                  <h3 class="mt-3">Belum ada data</h3>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>