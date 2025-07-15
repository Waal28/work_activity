<div class="card mb-5 mb-xl-12">
  <div class="card-header border-0 pt-5">
    <h3 class="card-title align-items-start flex-column">
      <span class="card-label fw-bold fs-3 mb-1">Delegasi Pekerjaan</span>
      <span class="text-muted mt-1 fw-semibold fs-7">Pekerjaan</span>
    </h3>
    <div class="card-toolbar">
      <button type="button" class="btn btn-sm tombol-tambah" onclick="handleClickDelegasi()" data-bs-toggle="modal" data-bs-target="#modalDelegasiPekerjaan">
        <i class="ki-duotone ki-plus fs-2 text-white"></i>Tambah</button>
    </div>
  </div>
  <div class="card-body py-3">
    <div class="table-responsive">
      <?php $this->load->view('partials/tabel_delegasi_pekerjaan.php', ['rows' => $rows]); ?>
    </div>
  </div>
</div>
<!-- Modal -->
<?php $this->load->view('partials/form_delegasi_pekerjaan.php', ['pegawai_list' => $pegawai_list]); ?>
<!-- end modal -->
<script>
  const listPekerjaan = <?= json_encode($pekerjaan_list) ?>;
  const root = document.querySelector(".form_pekerjaan");
  const formErrorAlert = document.getElementById("form-error-alert");
  const form = {
    title: document.querySelector(".form_pekerjaan_title"),
    element: root,
    fields: {
      pekerjaan_id: root.querySelector('[form-field="pekerjaan_id"]'),
      id_pegawai: root.querySelector('[form-field="id_pegawai"]'),
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
      setValue(el, data?.[key] ?? "");
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

  function handleClickDelegasi() {
    clearErrorForm();
    openForm({
      data: {},
      formTitle: "Delegasi Pekerjaan",
      actionUrl: "delegasipekerjaan/create",
    });
    updateSelect();
  };

  function handleClickEditDelegasi(data) {
    clearErrorForm({
      isClickEdit: true
    });
    openForm({
      data,
      formTitle: "Edit Delegasi Pekerjaan",
      actionUrl: `delegasipekerjaan/edit/${data.delegasi_id}`,
    });
    updateSelect(data);
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
  function updateSelect(data = {}) {
    const selectPekerjaan = root.querySelector('[form-field="pekerjaan_id"]');
    const selectPegawai = root.querySelector('[form-field="id_pegawai"]');

    // 1. Set selected pegawai
    if (selectPegawai) {
      Array.from(selectPegawai.options).forEach(option => {
        option.selected = data.ke_id_pegawai === option.value;
      });

      // Reinit Select2
      if ($(selectPegawai).hasClass("select2-hidden-accessible")) {
        $(selectPegawai).select2('destroy');
      }

      $(selectPegawai).select2({
        placeholder: 'Pilih Pegawai',
        multiple: data.ke_id_pegawai ? false : true,
        minimumResultsForSearch: Infinity,
      });
    }

    // 2. Populate select pekerjaan (selected item di atas)
    if (selectPekerjaan) {
      // Clear existing options
      selectPekerjaan.innerHTML = '';

      const selectedId = data.pekerjaan_id;
      const selectedText = data.judul;

      // Masukkan option terpilih paling atas (jika ada)
      if (selectedId && selectedText) {
        const selectedOption = document.createElement("option");
        selectedOption.value = selectedId;
        selectedOption.textContent = selectedText;
        selectPekerjaan.appendChild(selectedOption);
      }

      // Sisanya dari listPekerjaan (hindari duplikat)
      listPekerjaan.forEach(item => {
        if (item.pekerjaan_id !== selectedId) {
          const opt = document.createElement("option");
          opt.value = item.pekerjaan_id;
          opt.textContent = item.judul;
          selectPekerjaan.appendChild(opt);
        }
      });

      // Opsional: aktifkan select2 kalau ingin
      if ($(selectPekerjaan).hasClass("select2-hidden-accessible")) {
        $(selectPekerjaan).select2('destroy');
      }

      $(selectPekerjaan).select2({
        placeholder: 'Pilih Pekerjaan',
        minimumResultsForSearch: Infinity,
      });
    }
  }
</script>

<!-- Flashdata Handling -->
<?php if ($this->session->flashdata('validation_errors')): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = new bootstrap.Modal(document.getElementById('modalDelegasiPekerjaan'));
      const oldInput = <?= json_encode($this->session->flashdata('old_input') ?? []) ?>;
      const validationErrors = `<?= $this->session->flashdata('validation_errors') ?>`;
      const isEdit = !!oldInput.pekerjaan_id;

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
        formTitle: isEdit ? "Edit Delegasi Pekerjaan" : "Delegasi Pekerjaan",
        actionUrl: isEdit ? `delegasipekerjaan/edit/${oldInput.delegasi_id}` : "delegasipekerjaan/create",
      });
      updateSelect(oldInput);

      modal.show();
    });
  </script>
<?php endif; ?>