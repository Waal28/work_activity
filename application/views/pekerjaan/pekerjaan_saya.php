<div class="card mb-5 mb-xl-12">
	<div class="card-body py-3">
		<ul class="nav nav-tabs mb-10" id="myTab" role="tablist" style="border-bottom: 1px solid #dcdcdc">
			<?php
				$tabs = [
					[
						'id' => 'semua',
						'title' => 'Semua Pekerjaan',
						'icon' => 'https://api.iconify.design/material-symbols:format-list-bulleted.svg?color=%23',
						'url' => site_url('pekerjaansaya')
					],
					[
						'id' => 'kpi',
						'title' => 'KPI',
						'icon' => 'https://api.iconify.design/gg:performance.svg?color=%23',
						'url' => site_url('pekerjaansaya/kpi')
					],
					[
						'id' => 'nonkpi',
						'title' => 'Non KPI',
						'icon' => 'https://api.iconify.design/hugeicons:task-01.svg?color=%23',
						'url' => site_url('pekerjaansaya/nonkpi')
					]
				]
			?>
			<?php foreach ($tabs as $tab): ?>
				<?php
					$borderStyle = $tab_active == $tab['id'] ? '3px solid #0d6efd' : 'none';
					$textColor = $tab_active == $tab['id'] ? '#0d6efd' : '#000';
					$iconColor = $tab_active == $tab['id'] ? '0d6efd' : '000';
				?>
				<li class="nav-item">
					<a
						class="nav-link fw-bold"
						data-toggle="tab"
						href=<?= $tab['url'] ?>
						role="tab"
						style="border-bottom: <?= $borderStyle ?>; color: <?= $textColor ?>"
					>
						<img src="<?= $tab['icon'] ?><?= $iconColor ?>" alt="...">
						<?= $tab['title'] ?>
					</a>
				</li>
			<?php endforeach; ?>
    </ul>
		<!-- <div class="table-responsive">
			<?php $this->load->view('partials/tabel_pekerjaan_saya.php', ['rows' => $rows]); ?>
		</div> -->
		<?php $this->load->view('partials/cards_pekerjaan_saya.php', ['rows' => $rows]); ?>
	</div>
</div>
