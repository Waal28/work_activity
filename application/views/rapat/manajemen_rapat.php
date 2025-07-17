<!-- <?=
      '<pre>';
      print_r($rows);
      '</pre>';
      ?> -->
<div class="card">
  <div class="row card-body">
    <div class="col-9">
      <div class="d-flex justify-content-between mb-5">
        <span class="card-label fw-bold fs-3 mb-1">Daftar Rapat</span>
        <button type="button" class="btn btn-sm tombol-tambah" onclick="handleClickTambahRapat()" data-bs-toggle="modal" data-bs-target="#modalTambahRapat">
          <i class="ki-duotone ki-plus fs-2 text-white"></i>Tambah</button>
      </div>
      <table class="table align-middle gs-0 gy-4">
        <thead>
          <tr class="fw-bold thead-tabel-objective">
            <th class="ps-4">Judul Rapat</th>
            <th>Tanggal</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Status</th>
            <th>Link Undangan</th>
            <th class="pe-4">Tempat Pelaksanaan</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $index => $row): ?>
              <tr>
                <td class="ps-4"><?= !empty($row['nama_rapat']) ? htmlspecialchars($row['nama_rapat']) : '-' ?></td>
                <td><?= !empty($row['tanggal_rapat']) ? formatTanggalIndo($row['tanggal_rapat']) : '-' ?></td>
                <td><?= !empty($row['waktu_mulai']) ? htmlspecialchars($row['waktu_mulai']) : '-' ?></td>
                <td><?= !empty($row['waktu_selesai']) ? htmlspecialchars($row['waktu_selesai']) : '-' ?></td>
                <td>
                  <?php
                  $status = !empty($row['status']) ? $row['status'] : '-';
                  $badgeClass = 'secondary'; // default jika tidak cocok

                  if ($status === 'Terjadwal') {
                    $badgeClass = 'primary';
                  } elseif ($status === 'Selesai') {
                    $badgeClass = 'success';
                  } elseif ($status === 'Dibatalkan') {
                    $badgeClass = 'danger';
                  }
                  ?>
                  <span class="badge badge-light-<?= $badgeClass ?> fs-7 fw-bold border border-<?= $badgeClass ?>">
                    <?= htmlspecialchars($status) ?>
                  </span>
                </td>
                <td>
                  <?php if (!empty($row['link_undangan']) && $row['link_undangan'] !== '-'): ?>
                    <a href="<?= htmlspecialchars($row['link_undangan']) ?>" target="_blank"><?= htmlspecialchars($row['link_undangan']) ?></a>
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
                <td class="pe-4"><?= !empty($row['tempat_pelaksanaan']) ? htmlspecialchars($row['tempat_pelaksanaan']) : '-' ?></td>
              </tr>
            <?php endforeach; ?>

          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Tidak ada data.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="col-3">
      <h4 class="mb-3">Rapat Mendatang</h4>
      <?php if (!empty($list_rapat_mendatang)): ?>
        <?php foreach ($list_rapat_mendatang as $index => $row): ?>
          <p>• <?= $row['nama_rapat'] ?> (<?= formatTanggalIndo($row['tanggal_rapat']) ?>)</p>
        <?php endforeach; ?>
      <?php else: ?>
        <span>Tidak ada rapat mendatang.</span>
      <?php endif; ?>
    </div>
  </div>
  <?php $this->load->view('partials/form_tambah_rapat.php', ['pegawai_list' => $pegawai_list]); ?>
</div>

<script>
  const root = document.querySelector(".form_tambah_rapat");
  const formErrorAlert = document.getElementById("form-error-alert");
  const form = {
    title: document.querySelector(".form_tambah_rapat_title"),
    element: root,
    fields: {
      nama_rapat: root.querySelector('[form-field="nama_rapat"]'),
      deskripsi: root.querySelector('[form-field="deskripsi"]'),
      waktu_mulai: root.querySelector('[form-field="waktu_mulai"]'),
      waktu_selesai: root.querySelector('[form-field="waktu_selesai"]'),
      id_pegawai: root.querySelector('[form-field="id_pegawai"]'),
      tanggal_rapat: root.querySelector('[form-field="tanggal_rapat"]'),
      link_undangan: root.querySelector('[form-field="link_undangan"]'),
      tempat_pelaksanaan: root.querySelector('[form-field="tempat_pelaksanaan"]'),
    },
  };

  function setValue(el, value = "") {
    if (!el) return;
    el.value = value;
    if ($(el).hasClass("select2-hidden-accessible")) {
      $(el).trigger("change");
    }
  }

  const openForm = ({
    data = {},
    formTitle,
    actionUrl
  } = {}) => {
    form.title.innerText = formTitle;
    form.element.action = BASE_URL + actionUrl;

    for (const [key, el] of Object.entries(form.fields)) {
      if (key === "satuan" && !data.satuan) {
        setValue(el, "%");
      } else {
        setValue(el, data?.[key] ?? "");
      }
    }
  };

  const clearErrorForm = ({
    isClickEdit = false
  } = {}) => {
    if (formErrorAlert) formErrorAlert.innerHTML = "";

    if (!isClickEdit) {
      for (const el of Object.values(form.fields)) {
        setValue(el, "");
      }
    }
  };
  // Expose ke global scope
  function handleClearForm() {
    clearErrorForm();
  };

  function handleClickTambahRapat() {
    clearErrorForm();
    openForm({
      data: {},
      formTitle: "Tambah Rapat",
      actionUrl: "rapat/create",
    });
  };

  function handleClickEditRapat(data) {
    clearErrorForm({
      isClickEdit: true
    });
    openForm({
      data,
      formTitle: "Edit Rapat",
      actionUrl: `rapat/edit/${data.id}`,
    });
    updateSelect(data.id_pegawai);
  };

  // Handle disable tombol submit
  const formModal = document.getElementById("kt_modal_new_target_form");
  const submitButton = document.getElementById("kt_modal_new_target_submit");

  formModal.addEventListener("submit", () => {
    submitButton.disabled = true;
    submitButton.querySelector(".indicator-label")?.classList.add("d-none");
    submitButton.querySelector(".indicator-spinner")?.classList.remove("d-none");
  });

  // Fungsi untuk update radio & select2
  function updateSelect(paramsIdPegawai = []) {
    const select = root.querySelector('[form-field="id_pegawai"]');

    // Reset dan pilih berdasarkan parameter
    Array.from(select.options).forEach(option => {
      option.selected = paramsIdPegawai.includes(option.value);
    });

    // Reinit Select2
    if ($(select).hasClass("select2-hidden-accessible")) {
      $(select).select2('destroy');
    }

    $(select).select2({
      placeholder: 'Pilih Pegawai',
      minimumResultsForSearch: Infinity,
    });
  }
</script>

<!-- Flashdata Handling -->
<?php if ($this->session->flashdata('validation_errors')): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('modalTambahRapat'));
      const oldInput = <?= json_encode($this->session->flashdata('old_input') ?? []) ?>;
      const validationErrors = `<?= $this->session->flashdata('validation_errors') ?>`;
      const isEdit = !!oldInput.id;

      // Tampilkan error
      if (formErrorAlert) {
        formErrorAlert.innerHTML = `
			<div class="alert alert-danger fs-7 fw-bold mt-10">
				${validationErrors}
			</div>
		`;
      }

      // Open form kembali dengan data sebelumnya
      openForm({
        data: oldInput,
        formTitle: isEdit ? "Edit Rapat" : "Tambah Rapat",
        actionUrl: isEdit ? `rapat/edit/${oldInput.id}` : "rapat/create",
      });
      updateSelect(oldInput.id_pegawai);

      modal.show();
    });
  </script>
<?php endif; ?>