<?php
// echo '<pre>';
// print_r($rows);
// echo '</pre>';
$is_dirut = $this->session->userdata('role') == 'Direktur Utama';
?>
<!-- monitoring -->
<div class="col-xl-12 mb-10">
	<div class="row g-5 g-xl-10">
		<?php if (empty($rows)) : ?>
			<div class="d-flex flex-column align-items-center" style="margin-top: 100px;">
				<img src="https://api.iconify.design/line-md:coffee-half-empty-filled-loop.svg?color=%23000" alt="..." style="width: 100px; height: 100px">
				<h3 class="mt-3">Belum ada pekerjaan</h3>
			</div>
		<?php else : ?>
			<?php foreach ($rows as $row) : ?>
				<div class="col-xl-4 mb-xl-12">
					<div id="kt_sliders_widget_1_slider" class="card card-flush carousel carousel-custom carousel-stretch slide h-xl-100" data-bs-ride="carousel" data-bs-interval="5000">
						<div class="card-header pt-5">
							<h4 class="card-title d-flex align-items-start flex-column">
								<span class="card-label fw-bold text-gray-800"><?= $row['judul'] ?></span>
								<span class="text-gray-500 mt-1 fw-bold fs-7">Pekerjaan</span>
							</h4>
							<div class="card-toolbar">
								<ol class="p-0 m-0 carousel-indicators carousel-indicators-bullet carousel-indicators-active-primary">
									<span class="badge rounded-pill bg-primary text-white"><?= $row['jenis_pekerjaan'] ?></span>
								</ol>
							</div>
						</div>
						<div class="card-body py-6">
							<div class="carousel-inner mt-n5">
								<div class="carousel-item active show">
									<div class="d-flex align-items-center mb-5">
										<div class="w-80px flex-shrink-0 me-2">
											<div class="symbol symbol-45px border border border-dark rounded-circle p-2" style="background-color: lightgray">
												<img src="https://api.iconify.design/material-symbols:person.svg?color=%23000" alt="" />
											</div>
										</div>
										<div class="m-0">
											<h4 class="fw-bold text-gray-800 mb-3"><?= count($row['nama_pegawai']) > 1 ? $row['nama_pegawai'][0] . '...' : $row['nama_pegawai'][0] ?></h4>
											<div class="d-flex d-grid gap-5">
												<div class="d-flex flex-column flex-shrink-0 me-4">
													<span class="d-flex align-items-center fs-7 fw-bold mb-2">
														<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>Deadline</span>
													<span class="d-flex align-items-center fw-bold fs-7">
														<i class="ki-duotone ki-right-square fs-6 text-gray-600 me-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>Approval</span>
												</div>
												<div class="d-flex flex-column flex-shrink-0">
													<span class="d-flex align-items-center fs-7 fw-bold text-gray-500 mb-2">
														<?= !empty($row['deadline']) ? formatTanggalIndo($row['deadline']) : '-' ?></span>
													<span class="d-flex align-items-center fw-bold fs-7 text-primary">
														<?= $row['hasil_kerja'] ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body d-flex align-items-end pt-0">
										<div class="d-flex align-items-center flex-column mt-3 w-100">
											<div class="d-flex justify-content-between w-100 mt-auto mb-2">
												<span class="fw-bolder fs-6 text-gray-900">Progress</span>
												<span class="fw-bold fs-6 text-gray-500"><?= $row['progress'] ?>%</span>
											</div>
											<div class="h-8px mx-3 w-100 bg-light-primary rounded">
												<div class="bg-primary rounded h-8px" role="progressbar" style="width: <?= $row['progress'] ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
									<div class="m-0">
										<a href="#" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" onclick='showJobDetail(<?= json_encode($row) ?>)'>Detail</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered mw-900px">
			<div class="modal-content">
				<div class="modal-header" style="border-bottom: 1px solid lightgray;">
					<h2 id="detail_judul"></h2>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</div>
				</div>
				<div class="modal-body py-lg-10 px-lg-10">
					<div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper">
						<div class="flex-row-fluid">

							<form class="form" action="<?= base_url('monitoring/update_approval') ?>" method="post" id="kt_modal_create_app_form">
								<div class="current" data-kt-stepper-element="content">
									<div class="w-100">
										<div class="fv-row mb-10">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-2">
												<span>Keterangan</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Specify your unique app name">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<p class="fs-7 text-muted" id="detail_deskripsi"></p>
										</div>
										<div class="fv-row">
											<label class="d-flex align-items-center fs-5 fw-semibold mb-4">
												<span>Detail</span>
												<span class="ms-1" data-bs-toggle="tooltip" title="Select your app category">
													<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
													</i>
												</span>
											</label>
											<div class="fv-row">
												<label class="d-flex flex-stack mb-5 cursor-pointer">
													<span class="d-flex align-items-center me-2">
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-primary">
																<i class="ki-duotone ki-compass fs-1 text-primary">
																	<span class="path1"></span>
																	<span class="path2"></span>
																</i>
															</span>
														</span>
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">PIC Pekerjaan</span>
															<span class="fs-7 text-muted" id="detail_nama_pegawai"></span>
														</span>
													</span>
												</label>

												<label class="d-flex flex-stack mb-5 cursor-pointer">
													<span class="d-flex align-items-center me-2">
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-danger">
																<i class="ki-duotone ki-element-11 fs-1 text-danger">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																	<span class="path4"></span>
																</i>
															</span>
														</span>
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">Status</span>
															<span class="fs-7 text-muted" id="detail_status"></span>
														</span>
													</span>
												</label>

												<label class="d-flex flex-stack mb-5 cursor-pointer">
													<span class="d-flex align-items-center me-2">
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-success">
																<i class="ki-duotone ki-timer fs-1 text-success">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																</i>
															</span>
														</span>
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6">Deadline</span>
															<span class="fs-7 text-muted" id="detail_deadline"></span>
														</span>
													</span>
												</label>
												<label class="d-flex flex-stack cursor-pointer">
													<span class="d-flex align-items-center me-2">
														<span class="symbol symbol-50px me-6">
															<span class="symbol-label bg-light-success">
																<i class="ki-duotone ki-check-circle fs-1 text-success">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																</i>
															</span>
														</span>
														<span class="d-flex flex-column">
															<span class="fw-bold fs-6 mb-3">Approval</span>
															<select class="form-select form-select-sm" name="hasil_kerja" id="approval_select" style="width: max-content; display: inline-block;">
																<option value="Menunggu Persetujuan">Menunggu Persetujuan</option>
																<option value="Disetujui">Disetujui</option>
																<option value="Perlu Revisi">Perlu Revisi</option>
															</select>
														</span>
													</span>
												</label>
											</div>
										</div>
										<input type="hidden" name="pekerjaan_id" id="detail_pekerjaan_id">
										<div class="d-flex justify-content-end mt-5">
											<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- reports -->
<?php if ($is_dirut): ?>
	<h3 style="margin: 50px 0 20px;">Individual Goal Setting</h3>
	<?php $this->load->view('analytics/reports.php', ['rows' => $rows_reports]); ?>
<?php endif; ?>
<script>
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
	const showJobDetail = (data) => {
		if (!data || typeof data !== 'object') {
			console.error('Invalid job data');
			return;
		}

		// Populate form fields
		const fields = {
			'detail_judul': data.judul || '-',
			'detail_pekerjaan_id': data.pekerjaan_id || '-',
			'detail_deskripsi': data.deskripsi || '-',
			'detail_status': data.status || '-',
			'detail_deadline': formatTanggalIndo(data.deadline),
			'detail_hasil_kerja': data.hasil_kerja || '-'
		};

		// Set basic fields
		Object.entries(fields).forEach(([id, value]) => {
			const element = document.getElementById(id);
			if (element) {
				if (element.tagName === 'INPUT') {
					element.value = value;
				} else {
					element.textContent = value;
				}
			}
		});

		const namaPegawaiElement = document.getElementById('detail_nama_pegawai');
		if (namaPegawaiElement && data.nama_pegawai) {
			namaPegawaiElement.textContent = data.nama_pegawai.join(', ');
		}

		// Set priority with color
		const prioritasElement = document.getElementById('detail_prioritas');
		if (prioritasElement && data.prioritas) {
			prioritasElement.textContent = data.prioritas;
			prioritasElement.style.color = getPriorityColor(data.prioritas);
		}

		// Set status
		const approvalSelect = document.getElementById('approval_select');
		if (approvalSelect && data.hasil_kerja) {
			approvalSelect.value = data.hasil_kerja;
			approvalSelect.style.color = getStatusColor(data.hasil_kerja);
		}

		// Set progress - FIXED: Ensure progress value is properly handled
		const progressSlider = document.getElementById('progress_slider');
		const progressLabel = document.getElementById('progress_label');

		if (progressSlider && progressLabel) {
			// Convert progress to number and handle potential undefined/null values
			const progressValue = data.progress ? parseInt(data.progress) : 0;

			progressSlider.value = progressValue;
			progressLabel.textContent = progressValue;
			updateProgressSlider(progressSlider);
		}
	};
</script>