<!-- <?=
      '<pre>';
      print_r($rows);
      '</pre>';
      ?> -->
<table class="table align-middle gs-0 gy-4">
  <thead>
    <tr class="fw-bold thead-tabel-objective">
      <th class="ps-4 rounded-start">No</th>
      <th>Nama Pekerjaan</th>
      <th>Diberikan Kepada</th>
      <th>Deadline</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $index => $row): ?>
        <tr>
          <td class="ps-4 rounded-start"><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($row['judul']) ?></td>
          <td><?= htmlspecialchars(implode(', ', $row['nama_pegawai'])) ?></td>
          <td><?= !empty($row['deadline']) ? formatTanggalIndo($row['deadline']) : '-' ?></td>
          <td>
            <?php
            $status = strtolower($row['status']);
            $badgeClass = match ($status) {
              'in progress' => 'badge-light-primary',
              'done' => 'badge-light-success',
              'pending' => 'badge-light-warning',
              default => 'badge-light-secondary',
            };
            ?>
            <span class="badge <?= $badgeClass ?> fs-7 fw-bold">
              <?= htmlspecialchars($row['status']) ?>
            </span>
          </td>
          <td>
            <button
              type="button"
              data-bs-toggle="modal"
              data-bs-target="#modalPemberianPekerjaan"
              class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
              onclick='handleClickEditPekerjaan(<?= json_encode($row) ?>)'>
              <i class="ki-duotone ki-pencil fs-2 text-primary">
                <span class="path1"></span>
                <span class="path2"></span>
              </i>
            </button>
            <button
              type="button"
              data-bs-toggle="modal"
              data-bs-target="#modalKonfirmasiHapus"
              class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
              data-href="<?= base_url('pemberianpekerjaan/delete/' . $row['pekerjaan_id']) ?>">
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