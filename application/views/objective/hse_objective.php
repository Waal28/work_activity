<?php
$current_user = $this->session->userdata('current_user');
?>
<div class="card mb-5 mb-xl-12">
	<div class="ps-8 pe-8 mt-3">
		<table class="table table-bordered pegawai-info-objective">
			<tbody>
				<tr>
					<td class="fw-bold">Nama</td>
					<td>: <?= $current_user['nama'] ?></td>
					<td class="fw-bold">No. Pegawai</td>
					<td>: <?= !empty($current_user['nik']) ? $current_user['nik'] : '-' ?></td>
				</tr>
				<tr>
					<td class="fw-bold">Unit Bisnis</td>
					<td>: <?= !empty($current_user['nm_unit_bisnis']) ? $current_user['nm_unit_bisnis'] : '-' ?></td>
					<td class="fw-bold">Fungsi</td>
					<td>: <?= !empty($current_user['nm_unit_kerja']) ? $current_user['nm_unit_kerja'] : '-' ?></td>
				</tr>
				<tr>
					<td class="fw-bold">Jabatan</td>
					<td>: <?= !empty($current_user['nm_unit_level']) ? $current_user['nm_unit_level'] : '-' ?></td>
					<td class="fw-bold">Periode</td>
					<td>: 2025</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Hsse Participation</span>
		</h3>
		<div class="card-toolbar">
			<button type="button" class="btn btn-sm tombol-tambah" onclick="handleClickTambahPekerjaan()" data-bs-toggle="modal" data-bs-target="#modalHseObjective">
				<i class="ki-duotone ki-plus fs-2 text-white"></i>Tambah</button>
		</div>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<?php $this->load->view('partials/tabel_hse_objective.php', ['rows' => $rows]); ?>
		</div>
		<?php
		$total_point = 0;
		foreach ($rows as $row) {
			$total_point += $row['point'];
		}
		?>
		<span class="badge text-white" style="font-size: 14px; background-color: #0f4c89 !important;">Total Point: <?= $total_point ?></span>
	</div>
</div>
<!-- Modal -->
<?php $this->load->view('partials/form_hse_objective.php'); ?>
<!-- end modal -->
<script>
	const root = document.querySelector(".form_pekerjaan");
	const formErrorAlert = document.getElementById("form-error-alert");
	const form = {
		title: document.querySelector(".form_hse_objective_title"),
		element: root,
		fields: {
			aktivitas: root.querySelector('[form-field="aktivitas"]'),
			keterangan: root.querySelector('[form-field="keterangan"]'),
			lokasi: root.querySelector('[form-field="lokasi"]'),
			point: root.querySelector('[form-field="point"]'),
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

	const openForm = ({
		data = {},
		formTitle,
		actionUrl
	} = {}) => {
		form.title.innerText = formTitle;
		form.element.action = BASE_URL + actionUrl;

		const previewBox = document.getElementById("preview-bukti");
		const buktiInput = document.querySelector('[form-field="bukti"]');
		const buktiInputLama = document.querySelector('[form-field="bukti_lama"]');
		const previewLink = previewBox.querySelector("a");

		for (const [key, el] of Object.entries(form.fields)) {
			setValue(el, data?.[key] ?? "");
		}
		if (data.bukti || data.bukti_lama) {
			const value = data.bukti || data.bukti_lama;
			previewLink.href = BASE_URL + 'uploads/' + value;
			previewLink.innerText = value; // hanya nama file
			buktiInputLama.value = value;

			previewBox.classList.remove("d-none");
			buktiInput.classList.add("d-none");
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
		handleClearImage();
	};

	function handleClearImage() {
		const previewBox = document.getElementById("preview-bukti");
		const buktiInput = document.querySelector('[form-field="bukti"]');
		const buktiInputLama = document.querySelector('[form-field="bukti_lama"]');

		previewBox.classList.add("d-none");
		buktiInput.classList.remove("d-none");

		// Optional: reset file input
		buktiInput.value = '';
		buktiInputLama.value = '';
	}

	// Expose ke global scope
	function handleClearForm() {
		clearErrorForm();
	};

	function handleClickTambahPekerjaan() {
		clearErrorForm();
		openForm({
			data: {},
			formTitle: "HSSE Participation Form",
			actionUrl: "hseObjective/create",
		});
	};

	function handleClickEditPekerjaan(data) {
		clearErrorForm({
			isClickEdit: true
		});
		openForm({
			data,
			formTitle: "Edit HSSE Participation",
			actionUrl: `hseObjective/edit/${data.id}`,
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
		document.addEventListener('DOMContentLoaded', function() {
			const modal = new bootstrap.Modal(document.getElementById('modalHseObjective'));
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
				formTitle: isEdit ? "Edit HSSE Participation" : "HSSE Participation Form",
				actionUrl: isEdit ? `hseObjective/edit/${oldInput.id}` : "hseObjective/create",
			});
			modal.show();
		});
	</script>
<?php endif; ?>