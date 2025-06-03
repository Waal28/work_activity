<table class="table align-middle gs-0 gy-4">
  <thead>
    <tr class="fw-bold text-muted bg-light">
      <th class="ps-4 rounded-start">No</th>
      <th>Nama Pekerjaan</th>
      <th>Diberikan Kepada</th>
      <th>Dedline</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($rows)): ?>
      <?php foreach ($rows as $index => $row): ?>
        <tr>
          <td class="ps-4 rounded-start"><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($row['nama_pekerjaan']) ?></td>
          <td><?= htmlspecialchars($row['penerima']) ?></td>
          <td><?= htmlspecialchars($row['deadline']) ?></td>
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
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
          <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>