<div class="card mb-5 mb-xl-12">
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Pemberian Pekerjaan</span>
			<span class="text-muted mt-1 fw-semibold fs-7">Pekerjaan</span>
		</h3>
		<div class="card-toolbar">
			<button type="button" class="btn btn-sm btn-primary" onclick="handleClickTambahPekerjaan()" data-bs-toggle="modal" data-bs-target="#modalPemberianPekerjaan">
				<i class="ki-duotone ki-plus fs-2"></i>Tambah</button>
		</div>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<?php $this->load->view('partials/tabel_pemberian_pekerjaan.php', ['rows' => $rows]); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="modalPemberianPekerjaan" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content rounded">
			<div class="modal-header pb-0 border-0 justify-content-end">
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onclick="clearErrorForm()">
					<i class="ki-duotone ki-cross fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</div>
			</div>
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
				<!-- form pekerjaan -->
				<form id="kt_modal_new_target_form" class="form form_pekerjaan" action="" method="POST">
					<div class="mb-13 text-center">
						<h1 class="mb-3 form_pekerjaan_title" >Pemberian Pekerjaan</h1>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Nama Pekerjaan</span>
						</label>
						<input type="text" class="form-control form-control-solid" placeholder="Nama Pekerjaan" name="judul" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Tujuan Pemberian</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Pegawai" name="id_pegawai">
							<?php foreach ($pegawai_list as $pegawai): ?>
								<option value="<?= $pegawai['id_pegawai']; ?>"><?= $pegawai['nama']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Keterangan Pekerjaan</label>
						<textarea class="form-control form-control-solid" rows="3" name="deskripsi" placeholder="Keterangan"></textarea>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Prioritas</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Prioritas" name="prioritas">
							<option value="Low">Low</option>
							<option value="Medium">Medium</option>
							<option value="High">High</option>
						</select>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Deadline</span>
						</label>
						<input type="date" class="form-control form-control-solid" name="deadline" />
					</div>
					<div class="text-center">
						<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal" onclick="clearErrorForm()">Cancel</button>
						<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
						</button>
					</div>

					<div id="form-error-alert"></div>
				</form>
				<!-- end form -->
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url('assets/js/main.js?v=1.0.2') ?>"></script>
<script>
	const formErrorAlert = document.getElementById("form-error-alert");
	const root = document.querySelector(".form_pekerjaan");
	const form = {
		title: document.querySelector(".form_pekerjaan_title"),
		element: root,
		fields: {
			judul: root.querySelector('[name="judul"]'),
			deskripsi: root.querySelector('[name="deskripsi"]'),
			deadline: root.querySelector('[name="deadline"]'),
			id_pegawai: root.querySelector('[name="id_pegawai"]'),
			prioritas: root.querySelector('[name="prioritas"]'),
		},
	};
	const { openForm, clearErrorForm } = formHandler({ form, formErrorAlert });

	function handleClickTambahPekerjaan() {
		clearErrorForm({ isClickEdit: false });
		openForm({
			data: {},
			formTitle: "Pemberian Pekerjaan",
			actionUrl: "pemberianpekerjaan/create",
		});
	}

	function handleClickEditPekerjaan(data) {
		clearErrorForm({ isClickEdit: true });
		openForm({
			data,
			formTitle: "Edit Pemberian Pekerjaan",
			actionUrl: `pemberianpekerjaan/edit/${data.pekerjaan_id}`,
		});
	}

	const modalKonfirmasi = document.getElementById('modalKonfirmasiHapus');
  modalKonfirmasi.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const actionUrl = button.getAttribute('data-href');

    const form = modalKonfirmasi.querySelector('#formHapus');
    form.action = actionUrl;
  });
</script>
<?php if ($this->session->flashdata('validation_errors')): ?>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const modal = new bootstrap.Modal(document.getElementById('modalPemberianPekerjaan'));
			const formErrorAlert = document.getElementById('form-error-alert');
			
			const oldInput = <?= json_encode($this->session->flashdata('old_input') ?? []) ?>;
			const validationErrors = `<?= $this->session->flashdata('validation_errors') ?>`;
			const isEdit = !!oldInput.pekerjaan_id;

			if (formErrorAlert) {
				formErrorAlert.innerHTML = `
					<div class="alert alert-danger fs-7 fw-bold mt-10">
						${validationErrors}
					</div>
				`;
			}
			openForm({
				data: oldInput,
				formTitle: isEdit ? "Edit Pemberian Pekerjaan" : "Pemberian Pekerjaan",
				actionUrl: isEdit ? "pemberianpekerjaan/edit/" + oldInput.pekerjaan_id : "pemberianpekerjaan/create",
			});
			modal.show();
		});
	</script>
<?php endif; ?>
