<div class="modal fade" id="modalPemberianPekerjaan" role="dialog" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content rounded">
			<div class="modal-header pb-0 border-0 justify-content-end">
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onclick="handleClearForm()">
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
						<h1 class="mb-3 form_pekerjaan_title">Pemberian Pekerjaan</h1>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Nama Pekerjaan</span>
						</label>
						<input type="text" class="form-control form-control-solid" placeholder="Nama Pekerjaan" name="judul" form-field="judul" />
					</div>
					<!-- Radio Button Tipe Pelaksanaan -->
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Tipe Pelaksanaan</label>
						<div class="mt-2">
							<label class="me-4 ms-3">
								<input type="radio" name="tipe_pelaksanaan" value="Individu" checked onchange="updateSelect()"> Individu
							</label>
							<label>
								<input type="radio" name="tipe_pelaksanaan" value="Team" onchange="updateSelect()"> Team
							</label>
						</div>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Tujuan Pemberian</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Pegawai" name="id_pegawai[]" form-field="id_pegawai">
							<?php foreach ($pegawai_list as $pegawai): ?>
								<option value="<?= $pegawai['id_pegawai']; ?>"><?= $pegawai['nama']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Keterangan Pekerjaan</label>
						<textarea class="form-control form-control-solid" rows="3" name="deskripsi" form-field="deskripsi" placeholder="Keterangan"></textarea>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Jenis Pekerjaan</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Jenis Pekerjaan" name="jenis_pekerjaan" form-field="jenis_pekerjaan">
							<option value="KPI">KPI</option>
							<option value="Non KPI">Non KPI</option>
						</select>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Prioritas</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Prioritas" name="prioritas" form-field="prioritas">
							<option value="Low">Low</option>
							<option value="Medium">Medium</option>
							<option value="High">High</option>
						</select>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Freq Mon</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Freq Mon" name="freq_mon" form-field="freq_mon">
							<option value="Tahunan">Tahunan</option>
							<option value="Semi-Annually">Semi-Annually</option>
						</select>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Bobot</span>
						</label>
						<input type="number" class="form-control form-control-solid" placeholder="Tambahkan Bobot" name="bobot" form-field="bobot" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Satuan</span>
						</label>
						<input type="text" class="form-control form-control-solid" placeholder="Tambahkan Satuan" name="satuan" form-field="satuan" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Target Tahunan</span>
						</label>
						<input type="number" class="form-control form-control-solid" placeholder="Tambahkan Target Tahunan" name="annual_target" form-field="annual_target" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Target Semester 1</span>
						</label>
						<input type="number" class="form-control form-control-solid" placeholder="Tambahkan Target Semester 1" name="target_semester_1" form-field="target_semester_1" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Target Semester 2</span>
						</label>
						<input type="number" class="form-control form-control-solid" placeholder="Tambahkan Target Semester 2" name="target_semester_2" form-field="target_semester_2" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Deadline</span>
						</label>
						<input type="date" class="form-control form-control-solid" name="deadline" form-field="deadline" />
					</div>
					<div class="text-center">
						<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal" onclick="handleClearForm()">Cancel</button>
						<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
							<div class="spinner-border indicator-spinner d-none" style="width: 1rem; height: 1rem;" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</button>
					</div>

					<div id="form-error-alert"></div>
				</form>
				<!-- end form -->
			</div>
		</div>
	</div>
</div>