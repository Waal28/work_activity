<!-- <?=
      '<pre>';
      print_r($rows);
      '</pre>';
      ?> -->
<table class="table align-middle gs-0 gy-4">
  <thead>
    <tr class="fw-bold text-muted bg-light">
      <th class="ps-4 rounded-start">No</th>
      <th>Aktivitas</th>
      <th>Poin</th>
      <th>Tanggal Pelaksanaan</th>
      <th>Lokasi</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $index => $row): ?>
        <tr>
          <td class="ps-4 rounded-start"><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($row['aktivitas']) ?></td>
          <td><?= !empty($row['point']) ? $row['point'] : '-' ?></td>
          <td><?= !empty($row['tanggal_pelaksanaan']) ? formatTanggalIndo($row['tanggal_pelaksanaan']) : '-' ?></td>
          <td><?= !empty($row['lokasi']) ? htmlspecialchars($row['lokasi']) : '-' ?></td>
          <td><?= !empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '-' ?></td>
          <td>
            <button
              type="button"
              data-bs-toggle="modal"
              data-bs-target="#modalHseObjective"
              class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
              onclick="handleClickEditPekerjaan(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)">
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
              data-href="<?= base_url('hseobjective/delete/' . $row['id']) ?>">
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
        <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>