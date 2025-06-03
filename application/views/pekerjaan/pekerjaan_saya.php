<div class="card mb-5 mb-xl-12">
	<div class="card-header border-0 pt-5">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bold fs-3 mb-1">Pekerjaan Saya</span>
			<span class="text-muted mt-1 fw-semibold fs-7">Pekerjaan</span>
		</h3>
	</div>
	<div class="card-body py-3">
		<div class="table-responsive">
			<?php $this->load->view('partials/pekerjaan_saya_tabel.php', ['rows' => $rows]); ?>
		</div>
	</div>
</div>
