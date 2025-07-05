<!-- <?php
			echo '<pre>';
			print_r($penilaian_session);
			print_r($penilaian);
			print_r($pegawai);
			print_r($perilaku);
			print_r($komentar_penilaian);
			echo '</pre>';
			?> -->

<style>
	.back-btn {
		background-color: #6b7280;
		color: white;
		margin-left: 20px;
	}

	.back-btn:hover {
		background-color: #4b5563;
		color: white;
	}

	@media print {
		.print_main_container {
			zoom: 80%;
		}

		.show-print {
			display: block !important;
		}

		#kt_aside,
		#kt_header,
		#kt_footer,
		.hiden-print {
			display: none !important;
		}
	}
</style>
<main class="print_main_container">
	<div class="row mb-5">
		<div class="col-2 mb-3">
			<span class="fs-6 fw-semibold">Nama Pegawai</span>
		</div>
		<div class="col-10 mb-3 d-flex align-items-center">:
			<span class="fs-6 ms-3"><?= empty($pegawai['nama']) ? '-' : $pegawai['nama']; ?></span>
		</div>
		<div class="col-2 mb-3">
			<span class="fs-6 fw-semibold">NIK</span>
		</div>
		<div class="col-10 mb-3 d-flex align-items-center">:
			<span class="fs-6 ms-3"><?= empty($pegawai['nik']) ? '-' : $pegawai['nik']; ?></span>
		</div>
		<div class="col-2 mb-3">
			<span class="fs-6 fw-semibold">Jabatan</span>
		</div>
		<div class="col-10 mb-3 d-flex align-items-center">:
			<span class="fs-6 ms-3"><?= empty($pegawai['nm_unit_level']) ? '-' : $pegawai['nm_unit_level']; ?></span>
		</div>
		<div class="col-2 mb-3">
			<span class="fs-6 fw-semibold">Periode</span>
		</div>
		<div class="col-10 mb-3 d-flex align-items-center">:
			<span class="fs-6 ms-3"><?= empty($penilaian_session['periode']) ? '-' : $penilaian_session['periode']; ?></span>
		</div>
	</div>
	<table class="table table-bordered border-dark">
		<thead class="thead-dark text-center align-middle">
			<tr>
				<th rowspan="2">Core Values</th>
				<th rowspan="2">No</th>
				<th rowspan="2">Panduan Perilaku</th>
				<th colspan="5">Tingkat Kecakapan</th>
			</tr>
			<tr>
				<th>Membutuhkan banyak pengembangan</th>
				<th>Masih perlu dikembangkan</th>
				<th>Efektif</th>
				<th>Sangat Efektif</th>
				<th>Belum memunculkan perilaku</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// 1. Hitung jumlah perilaku per core_value untuk rowspan
			$counts = [];
			foreach ($perilaku as $p) {
				$cv = $p['core_value_nama'];
				if (!isset($counts[$cv])) {
					$counts[$cv] = 0;
				}
				$counts[$cv]++;
			}

			$rendered_cv = []; // Penanda core_value yang sudah ditampilkan
			$no = 1;

			foreach ($perilaku as $p):
				$cv = $p['core_value_nama'];
			?>
				<tr>
					<?php if (!in_array($cv, $rendered_cv)): ?>
						<td rowspan="<?= $counts[$cv] ?>">
							<strong><?= $p['core_value_nama'] ?></strong><br>
							(<?= $p['core_value_arti'] ?>)
						</td>
						<?php $rendered_cv[] = $cv; ?>
					<?php endif; ?>

					<td class="text-center"><?= $no++ ?></td>
					<td><?= $p['deskripsi'] ?></td>

					<?php
					// Cari skor perilaku terkait (pakai use untuk bawa $p)
					$hasil = array_filter($penilaian, function ($item) use ($p) {
						return $item['id_perilaku'] === $p['id'];
					});
					$hasil = reset($hasil); // Ambil 1 data (mirip find)
					?>

					<?php
					$levels = [
						'Membutuhkan banyak pengembangan',
						'Masih perlu dikembangkan',
						'Efektif',
						'Sangat Efektif',
						'Belum memunculkan perilaku'
					];

					foreach ($levels as $level): ?>
						<td class="text-center align-middle">
							<?php
							if ($hasil && $hasil['skor'] === $level) {
								echo 'X';
							}
							?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>


	</table>

	<h4 style="margin: 50px 0 20px;">GENERAL COMMENT</h4>
	<div class="row">
		<div class="col-6 mb-5">
			<label class="fw-semibold mb-3">1. Area kekuatan utama</label><br>
			<p><?= $komentar_penilaian['area_kekuatan'] ?></p>
		</div>
		<div class="col-6 mb-5">
			<label class="fw-semibold mb-3">2. Area yang masih harus dikembangkan</label><br>
			<p><?= $komentar_penilaian['area_pengembangan'] ?></p>
		</div>
		<div class="col-12 mb-5">
			<label class="fw-semibold mb-3">3. Komentar Umum</label><br>
			<p><?= $komentar_penilaian['komentar_umum'] ?></p>
		</div>
	</div>
	<div class="d-flex mt-5 hiden-print">
		<button class="btn btn-success" onclick="window.print()">
			<img src="https://api.iconify.design/material-symbols:print.svg?color=%23ffffff" alt="..." style="min-width: 25px; min-height: 25px; margin-top: -2px">
			Cetak Penilaian
		</button>
		<a href="<?= base_url('abs/daftarpenilaian') ?>" class="btn back-btn">
			<img src="https://api.iconify.design/material-symbols:arrow-back-rounded.svg?color=%23ffffff" alt="..." style="min-width: 25px; min-height: 25px; margin-top: -2px">
			Kembali
		</a>
	</div>
	<div class="d-none show-print">
		<div class="text-center mt-2" style="margin-left: auto; width: fit-content">
			<p>Pangkalpinang, <?= formatTanggalIndo($penilaian_session['created_at']) ?></p>
			<p style="margin-bottom: 100px;"><?= $penilaian_session['jabatan_pemberi'] ?></p>
			<p><?= $penilaian_session['nama_pemberi'] ?></p>
		</div>
</main>