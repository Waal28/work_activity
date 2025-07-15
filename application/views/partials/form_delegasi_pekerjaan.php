<div class="modal fade" id="modalDelegasiPekerjaan" role="dialog" tabindex="-1" aria-hidden="true">
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
						<h1 class="mb-3 form_pekerjaan_title title-form-data">Delegasi Pekerjaan</h1>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Daftar Pekerjaan</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Pekerjaan" name="pekerjaan_id" form-field="pekerjaan_id">
							<?php if (empty($pekerjaan_list)): ?>
								<option value="">Tidak ada pekerjaan</option>
							<?php else: ?>
								<?php foreach ($pekerjaan_list as $pekerjaan): ?>
									<option value="<?= $pekerjaan['pekerjaan_id']; ?>">
										<?= $pekerjaan['judul']; ?>
									</option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Tujuan Delegasi</label>
						<select class="form-select form-select-solid" data-control="select2" multiple data-hide-search="true" data-placeholder="Pilih Pegawai" name="id_pegawai[]" form-field="id_pegawai">
							<?php if (empty($pegawai_list)): ?>
								<option value="">Tidak ada pegawai</option>
							<?php else: ?>
								<?php
								// Kelompokkan data berdasarkan nm_unit_level
								$grouped_pegawai = [];
								foreach ($pegawai_list as $pegawai) {
									$grouped_pegawai[$pegawai['nm_unit_level']][] = $pegawai;
								}
								?>
								<?php foreach ($grouped_pegawai as $unit_level => $pegawais): ?>
									<optgroup label="<?= htmlspecialchars($unit_level); ?>">
										<?php foreach ($pegawais as $pegawai): ?>
											<option
												value="<?= $pegawai['id_pegawai']; ?>">
												<?= $pegawai['nama'] . ' | ' . $pegawai['nm_unit_kerja']; ?>
											</option>
										<?php endforeach; ?>
									</optgroup>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="d-flex justify-content-end">
						<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3" data-bs-dismiss="modal" onclick="handleClearForm()">Cancel</button>
						<button type="submit" id="kt_modal_new_target_submit" class="btn tombol-tambah" <?= empty($pegawai_list) ? 'disabled' : '' ?>>
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