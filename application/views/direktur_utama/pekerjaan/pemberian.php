<div class="card mb-5 mb-xl-12">
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Pemberian Pekerjaan</span>
			<span class="text-muted mt-1 fw-semibold fs-7">Pekerjaan</span>
		</h3>
		<div class="card-toolbar">
			<a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPemberianPekerjaan">
				<i class="ki-duotone ki-plus fs-2"></i>Tambah</a>
		</div>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<table class="table align-middle gs-0 gy-4">
				<thead>
					<tr class="fw-bold text-muted bg-light">
						<th class="ps-4 rounded-start">No</th>
						<th>Nama Pekerjaan</th>
						<th>Diberikan Kepada</th>
						<th>Dedline</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="ps-4 rounded-start">
							1
						</td>
						<td>
							Audit Keuangan
						</td>
						<td>
							Andika
						</td>
						<td>
							10 Februari 2025
						</td>
						<td>
							<span class="badge badge-light-primary fs-7 fw-bold">In Progress</span>
						</td>
						<td>
							<a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
								<i class="ki-duotone ki-pencil fs-2 text-primary">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</a>
							<a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
								<i class="ki-duotone ki-trash fs-2 text-danger">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
									<span class="path5"></span>
								</i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="ps-4 rounded-start">
							2
						</td>
						<td>
							Evaluasi IT
						</td>
						<td>
							Putri
						</td>
						<td>
							15 Februari 2025
						</td>
						<td>
							<span class="badge badge-light-success	 fs-7 fw-bold">Done</span>
						</td>
						<td>
							<a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
								<i class="ki-duotone ki-pencil fs-2 text-primary">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</a>
							<a href="" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
								<i class="ki-duotone ki-trash fs-2 text-danger">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
									<span class="path4"></span>
									<span class="path5"></span>
								</i>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="modalPemberianPekerjaan" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content rounded">
			<div class="modal-header pb-0 border-0 justify-content-end">
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="ki-duotone ki-cross fs-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>
				</div>
			</div>
			<div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
				<form id="kt_modal_new_target_form" class="form" action="#">
					<div class="mb-13 text-center">
						<h1 class="mb-3">Pemberian Pekerjaan</h1>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Nama Pekerjaan</span>
						</label>
						<input type="text" class="form-control form-control-solid" placeholder="Nama Pekerjaan" name="nama_pekerjaan" />
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="required fs-6 fw-semibold mb-2">Tujuan Pemberian</label>
						<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a Team" name="tim_id">
							<option value="">Pilih Tim</option>
							<option value="1">Karina Clark</option>
							<option value="2">Robert Doe</option>
							<option value="3">Niel Owen</option>
							<option value="4">Olivia Wild</option>
						</select>
					</div>
					<div class="d-flex flex-column mb-8">
						<label class="fs-6 fw-semibold mb-2">Keterangan Pekerjaan</label>
						<textarea class="form-control form-control-solid" rows="3" name="keterangan" placeholder="Keterangan"></textarea>
					</div>
					<div class="d-flex flex-column mb-8 fv-row">
						<label class="d-flex align-items-center fs-6 fw-semibold mb-2">
							<span class="required">Dedline</span>
						</label>
						<input type="date" class="form-control form-control-solid" name="dedline" />
					</div>
					<div class="text-center">
						<button type="reset" id="kt_modal_new_target_cancel" class="btn btn-light me-3">Cancel</button>
						<button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
							<span class="indicator-label">Submit</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
