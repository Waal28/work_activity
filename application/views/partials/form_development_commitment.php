<div class="modal fade" id="modalDevelopmentCommitment" role="dialog" tabindex="-1" aria-hidden="true">
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
				<form id="kt_modal_new_target_form" class="form form_pekerjaan" action="" method="POST" enctype="multipart/form-data">
					<div class="mb-13 text-center">
						<h1 class="mb-3 form_development_commitment_title title-form-data">Development Commitment</h1>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Aktivitas</span>
						</label>
						<input type="text" class="form-control form-control-solid" placeholder="Aktivitas" name="aktivitas" form-field="aktivitas" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Tanggal Pelaksanaan</span>
						</label>
						<input type="date" class="form-control form-control-solid" name="tanggal_pelaksanaan" form-field="tanggal_pelaksanaan" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Lh</span>
						</label>
						<input type="number" class="form-control form-control-solid" placeholder="lh" name="lh" form-field="lh" />
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Lokasi</label>
						<textarea class="form-control form-control-solid" rows="3" name="lokasi" form-field="lokasi" placeholder="Lokasi"></textarea>
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Keterangan</label>
						<textarea class="form-control form-control-solid" rows="3" name="keterangan" form-field="keterangan" placeholder="Keterangan"></textarea>
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Bukti</label>
						<input class="form-control form-control-solid" type="file" accept="image/*" name="bukti" form-field="bukti" placeholder="Bukti">
						<input type="hidden" name="bukti_lama" form-field="bukti_lama">
						<div class="px-3 row d-none" id="preview-bukti">
							<div class="badge bg-light row mx-auto" style="border: 1px solid #8fc240;">
								<div class="col-9 text-truncate text-start">
									<a href="#" target="_blank"></a>
								</div>
								<div class="col-3 d-flex justify-content-end">
									<button type="button" class="btn btn-sm btn-light fw-bold" onclick="handleClearImage()">X</button>
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-end">
						<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal" onclick="handleClearForm()">Cancel</button>
						<button type="submit" id="kt_modal_new_target_submit" class="btn tombol-tambah">
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