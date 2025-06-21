<?php
  $current_user = $this->session->userdata('current_user');
?>
<div class="card mb-5 mb-xl-12">
  <div class="ps-8 pe-8">
    <table class="table table-bordered border-dark">
      <tbody>
        <tr>
          <td class="fw-bold">Nama</td>
          <td>: <?= $current_user['nama'] ?></td>
          <td class="fw-bold">No. Pegawai</td>
          <td>: <?= !empty($current_user['nik']) ? $current_user['nik'] : '-' ?></td>
        </tr>
        <tr>
          <td class="fw-bold">Unit</td>
          <td>: <?= !empty($current_user['nm_unit_kerja']) ? $current_user['nm_unit_kerja'] : '-' ?></td>
          <td class="fw-bold">Fungsi</td>
          <td>: <?= !empty($current_user['fungsi']) ? $current_user['fungsi'] : '-' ?></td>
        </tr>
        <tr>
          <td class="fw-bold">Jabatan</td>
          <td>: <?= !empty($current_user['nm_unit_level']) ? $current_user['nm_unit_level'] : '-' ?></td>
          <td class="fw-bold">Priode</td>
          <td>: <?= !empty($current_user['priode']) ? $current_user['priode'] : '-' ?></td>
        </tr>
      </tbody>
    </table>
  </div>
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Development Commitment</span>
		</h3>
		<div class="card-toolbar">
			<button type="button" class="btn btn-sm btn-primary" onclick="handleClickTambahPekerjaan()" data-bs-toggle="modal" data-bs-target="#modalDevelopmentCommitment">
				<i class="ki-duotone ki-plus fs-2"></i>Tambah</button>
		</div>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<?php $this->load->view('partials/tabel_development_commitment.php', ['rows' => $rows]); ?>
		</div>
		<?php
			$total_point = 0;
			foreach ($rows as $row) {
				$total_point += $row['lh'];
			}
		?>
		<span class="badge bg-primary text-white" style="font-size: 14px;">Total Point: <?= $total_point ?></span>
	</div>
</div>
<!-- Modal -->
<?php $this->load->view('partials/form_development_commitment.php'); ?>
<!-- end modal -->
<script>
const root = document.querySelector(".form_pekerjaan");
const formErrorAlert = document.getElementById("form-error-alert");
const form = {
	title: document.querySelector(".form_development_commitment_title"),
	element: root,
	fields: {
		aktivitas: root.querySelector('[form-field="aktivitas"]'),
		keterangan: root.querySelector('[form-field="keterangan"]'),
		lokasi: root.querySelector('[form-field="lokasi"]'),
		tanggal_pelaksanaan: root.querySelector('[form-field="tanggal_pelaksanaan"]'),
	},
};

function setValue(el, value = "") {
		if (!el) return;
		el.value = value;
		if ($(el).hasClass("select2-hidden-accessible")) {
			$(el).trigger("change");
		}
	}

	const openForm = ({ data = {}, formTitle, actionUrl } = {}) => {
		form.title.innerText = formTitle;
		form.element.action = BASE_URL + actionUrl;

		for (const [key, el] of Object.entries(form.fields)) {
			setValue(el, data?.[key] ?? "");
		}
	};

	const clearErrorForm = ({ isClickEdit = false } = {}) => {
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

	function handleClickTambahPekerjaan() {
		clearErrorForm();
		openForm({
			data: {},
			formTitle: "Development Commitment Form",
			actionUrl: "developmentCommitment/create",
		});
	};

	function handleClickEditPekerjaan(data) {
		clearErrorForm({ isClickEdit: true });
		openForm({
			data,
			formTitle: "Edit Development Commitment",
			actionUrl: `developmentCommitment/edit/${data.id}`,
		});
	};

	// Handle disable tombol submit
	const formModal = document.getElementById("kt_modal_new_target_form");
	const submitButton = document.getElementById("kt_modal_new_target_submit");

	formModal.addEventListener("submit", () => {
		submitButton.disabled = true;
		submitButton.querySelector(".indicator-label")?.classList.add("d-none");
		submitButton.querySelector(".indicator-spinner")?.classList.remove("d-none");
	});
</script>

<!-- Flashdata Handling -->
<?php if ($this->session->flashdata('validation_errors')): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const modal = new bootstrap.Modal(document.getElementById('modalDevelopmentCommitment'));
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
		formTitle: isEdit ? "Edit Development Commitment" : "Development Commitment Form",
		actionUrl: isEdit ? `developmentCommitment/edit/${oldInput.id}` : "developmentCommitment/create",
	});
	modal.show();
});
</script>
<?php endif; ?>

