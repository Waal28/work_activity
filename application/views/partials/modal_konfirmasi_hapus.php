<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-danger text-white">
				<h5 class="modal-title text-white" id="modalKonfirmasiHapusLabel">Konfirmasi Hapus</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>Apakah Anda yakin ingin menghapus data ini?</p>
			</div>
			<div class="modal-footer">
				<form id="formHapus" method="post" action="">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-danger">Hapus</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end konfirmasi hapus -->