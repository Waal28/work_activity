<div class="card mb-5 mb-xl-12">
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Pemberian Pekerjaan</span>
			<span class="text-muted mt-1 fw-semibold fs-7">Pekerjaan</span>
		</h3>
		<div class="card-toolbar">
			<button type="button" class="btn btn-sm tombol-tambah" onclick="handleClickTambahPekerjaan()" data-bs-toggle="modal" data-bs-target="#modalPemberianPekerjaan">
				<i class="ki-duotone ki-plus fs-2 text-white"></i>Tambah</button>
		</div>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<?php $this->load->view('partials/tabel_pemberian_pekerjaan.php', ['rows' => $rows]); ?>
		</div>
	</div>
</div>
<!-- Modal -->
<?php $this->load->view('partials/form_pemberian_pekerjaan.php', ['pegawai_list' => $pegawai_list]); ?>
<!-- end modal -->
<script>
	const root = document.querySelector(".form_pekerjaan");
	const formErrorAlert = document.getElementById("form-error-alert");
	const form = {
		title: document.querySelector(".form_pekerjaan_title"),
		element: root,
		fields: {
			judul: root.querySelector('[form-field="judul"]'),
			deskripsi: root.querySelector('[form-field="deskripsi"]'),
			jenis_pekerjaan: root.querySelector('[form-field="jenis_pekerjaan"]'),
			deadline: root.querySelector('[form-field="deadline"]'),
			id_pegawai: root.querySelector('[form-field="id_pegawai"]'),
			prioritas: root.querySelector('[form-field="prioritas"]'),
			freq_mon: root.querySelector('[form-field="freq_mon"]'),
			bobot: root.querySelector('[form-field="bobot"]'),
			satuan: root.querySelector('[form-field="satuan"]'),
			annual_target: root.querySelector('[form-field="annual_target"]'),
			target_semester_1: root.querySelector('[form-field="target_semester_1"]'),
			target_semester_2: root.querySelector('[form-field="target_semester_2"]'),
			is_delegasi: root.querySelector('[form-field="is_delegasi"]'),
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
		const info_delegasi = root.querySelector("#info_delegasi");
		info_delegasi.style.display = Number(data.is_delegasi) === 1 ? "block" : "none";
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

	function handleClickTambahPekerjaan() {
		clearErrorForm();
		openForm({
			data: {},
			formTitle: "Pemberian Pekerjaan",
			actionUrl: "pemberianpekerjaan/create",
		});
	};

	function handleClickEditPekerjaan(data) {
		clearErrorForm({
			isClickEdit: true
		});
		openForm({
			data,
			formTitle: "Edit Pemberian Pekerjaan",
			actionUrl: `pemberianpekerjaan/edit/${data.pekerjaan_id}`,
		});
		updateSelect(data.tipe_pelaksanaan, data.id_pegawai, data.is_delegasi);
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
	function updateSelect(paramsTipe = null, paramsIdPegawai = [], isDelegasi = 0) {
		const radios = [...root.querySelectorAll('input[name="tipe_pelaksanaan"]')];
		const tipe = paramsTipe || radios.find(radio => radio.checked)?.value;
		const select = root.querySelector('[form-field="id_pegawai"]');

		// Sinkronkan radio yang dipilih
		radios.forEach(radio => {
			radio.checked = radio.value === tipe;
			if (Number(isDelegasi) === 1) {
				radio.disabled = true;
			}
		});

		// Atur multiple
		const isTeam = tipe === 'Team';
		select.multiple = isTeam;

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
			multiple: isTeam,
			minimumResultsForSearch: Infinity,
			disabled: Number(isDelegasi) === 1
		});
	}
</script>

<!-- Flashdata Handling -->
<?php if ($this->session->flashdata('validation_errors')): ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const modal = new bootstrap.Modal(document.getElementById('modalPemberianPekerjaan'));
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
				formTitle: isEdit ? "Edit Pemberian Pekerjaan" : "Pemberian Pekerjaan",
				actionUrl: isEdit ? `pemberianpekerjaan/edit/${oldInput.pekerjaan_id}` : "pemberianpekerjaan/create",
			});
			updateSelect(oldInput.tipe_pelaksanaan, oldInput.id_pegawai, oldInput.is_delegasi);

			modal.show();
		});
	</script>
<?php endif; ?>