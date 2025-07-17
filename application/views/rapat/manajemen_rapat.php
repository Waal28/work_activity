<!-- <?=
      '<pre>';
      print_r($rows);
      '</pre>';
      ?> -->
<div class="card">
  <div class="row card-body">
    <div class="col-12">
      <div class="d-flex justify-content-between mb-5">
        <span class="card-label fw-bold fs-3 mb-1">Undangan Rapat</span>
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
            <th>Tempat Pelaksanaan</th>
            <th>Aksi</th>
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
                <td><?= !empty($row['tempat_pelaksanaan']) ? htmlspecialchars($row['tempat_pelaksanaan']) : '-' ?></td>
                <td>
                  <button
                    type="button"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetailRapat"
                    onclick='showJobDetail(<?= json_encode($row) ?>)'>
                    <img src="https://api.iconify.design/bx:show-alt.svg?color=%230d6efd" alt="..." style="min-width: 25px; min-height: 25px">
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
    <div class="col-12 mt-5 pt-5">
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

<!-- Modal detail rapat -->
<div class="modal fade" id="modalDetailRapat" tabindex="-1" aria-labelledby="modalDetailPekerjaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <form class="modal-content" id="formDetailRapat" method="post" action="<?= base_url('rapat/setStatus/') ?>">
      <div class="modal-header">
        <h4 class="modal-title pb-4" style="border-bottom: 3px solid #007BFF" id="modalDetailPekerjaanLabel">Detail Rapat</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="rapat_id" id="rapat_id">

        <!-- Job Details -->
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Judul Rapat</span></div>
          <div class="col-8">: <span id="detail_nama_rapat"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Deskripsi</span></div>
          <div class="col-8">: <span id="detail_deskripsi"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Tanggal Rapat</span></div>
          <div class="col-8">: <span id="detail_tanggal_rapat" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Waktu Mulai</span></div>
          <div class="col-8">: <span id="detail_waktu_mulai" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Waktu Selesai</span></div>
          <div class="col-8">: <span id="detail_waktu_selesai" class="fw-bold"></span></div>
        </div>

        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Pemberi Rapat</span></div>
          <div class="col-8">: <span id="detail_pemberi_rapat"></span></div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Metode Pelaksanaan</span></div>
          <div class="col-8">: <span id="detail_metode_pelaksanaan"></span></div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Link Rapat</span></div>
          <div class="col-8">: <span id="detail_link_undangan"></span></div>
        </div>
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Tempat Pelaksanaan</span></div>
          <div class="col-8">: <span id="detail_tempat_pelaksanaan"></span></div>
        </div>

        <!-- Status Select -->
        <div class="row mb-3">
          <div class="col-4"><span class="fs-6 fw-semibold">Status</span></div>
          <div class="col-8">
            : <select class="form-select form-select-sm" name="status" id="detail_status" style="width: max-content; display: inline-block;">
              <option value="Terjadwal">Terjadwal</option>
              <option value="Selesai">Selesai</option>
              <option value="Dibatalkan">Dibatalkan</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button
            type="submit"
            class="btn btn-sm tombol-tambah">
            Simpan
          </button>
        </div>
    </form>
  </div>
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
      metode_pelaksanaan: root.querySelector('[form-field="metode_pelaksanaan"]'),
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

  const formatTanggalIndo = (tanggalString) => {
    if (!tanggalString) return "-";

    const bulanIndo = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const tanggal = new Date(tanggalString);
    if (isNaN(tanggal)) return tanggalString;

    const hari = tanggal.getDate();
    const bulan = bulanIndo[tanggal.getMonth()];
    const tahun = tanggal.getFullYear();

    return `${hari} ${bulan} ${tahun}`;
  };

  function showJobDetail(data) {
    if (!data || typeof data !== 'object') {
      console.error('Invalid job data');
      return;
    }

    // Populate form fields
    const fields = {
      'rapat_id': data.id || '',
      'detail_nama_rapat': data.nama_rapat || '-',
      'detail_deskripsi': data.deskripsi || '-',
      'detail_tanggal_rapat': formatTanggalIndo(data.tanggal_rapat),
      'detail_waktu_mulai': data.waktu_mulai || '-',
      'detail_waktu_selesai': data.waktu_selesai || '-',
      'detail_pemberi_rapat': data.pemberi_rapat || '-',
      'detail_metode_pelaksanaan': data.metode_pelaksanaan || '-',
      'detail_status': data.status || '-',
      'detail_link_undangan': data.link_undangan || '-',
      'detail_tempat_pelaksanaan': data.tempat_pelaksanaan || '-'
    };

    // Set basic fields
    Object.entries(fields).forEach(([id, value]) => {
      const element = document.getElementById(id);
      if (element) {
        if (id === 'rapat_id') {
          element.value = value;
        } else if (id === 'detail_waktu_mulai' || id === 'detail_waktu_selesai') {
          const [hours, minutes] = value.split(':');
          element.textContent = `${hours}.${minutes} WIB`;;
        } else if (id === 'detail_link_undangan') {
          element.innerHTML = value !== '-' ? `<a href="${value}" target="_blank">${value}</a>` : '-';
        } else if (id === 'detail_status') {
          const colorStatus = {
            terjadwal: '#6f42c1',
            selesai: '#00c851',
            dibatalkan: '#ff4444',
          };
          const status = data.status.toLowerCase();
          element.style.color = colorStatus[status];
          element.value = data.status;
        } else {
          element.textContent = value;
        }
      }
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