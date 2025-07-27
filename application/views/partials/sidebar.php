<?php
$menu_access = $this->session->userdata('menu_access');
$is_dirut = $this->session->userdata('role') == 'Direktur Utama';
$is_corsec = $this->session->userdata('role') == 'Corporate Secretary';
$total_rapat_terjadwal = $this->session->userdata('total_rapat_terjadwal');

$menu_pekerjaan = ["Pekerjaan Saya", "Pekerjaan Tim", "Pekerjaan Selesai", "Delegasi Pekerjaan", "Pemberian Pekerjaan"];
$show_menu_pekerjaan = in_array($page_title, $menu_pekerjaan) || ($is_dirut && $page_title == "Monitoring Pekerjaan");
$show_menu_analytics = $menu_access['reports'];
?>
<style>
	.menu-text-color {
		color: #ffff !important;
	}

	.menu-icon-color {
		color: #ffff !important;
	}

	.menu-hover:hover {
		background-color: rgba(91, 144, 197, 1) !important;
	}
</style>
<div class="aside-menu flex-column-fluid">
	<div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
		<div class="menu menu-column menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary" id="#kt_aside_menu" data-kt-menu="true">

			<!-- Dashboard -->
			<?php if ($menu_access['dashboard']): ?>
				<div class="menu-item">
					<a class="menu-link menu-hover <?= $page_title == "Dashboard" ? "active" : "" ?>" href="<?= base_url('dashboard') ?>">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-element-11 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color">Dashboard</span>
					</a>
				</div>
			<?php endif; ?>
			<!-- Section: Menu -->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7" style="color: #8fc240; padding-bottom: 3px;">Menu</span>
				</div>
			</div>

			<!-- Pekerjaan -->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
				<?php if (!$is_corsec): ?>
					<span class="menu-link">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-message-text-2 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color"><?= $is_dirut || $is_corsec ? "Management" : "Objectives" ?></span>
						<span class="menu-arrow"></span>
					</span>
				<?php endif; ?>
				<div class="menu-sub menu-sub-accordion <?= $show_menu_pekerjaan ? "show" : "" ?>">
					<?php if ($menu_access['pekerjaan_saya']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Pekerjaan Saya" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaansaya' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Pekerjaan Saya</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pekerjaan_tim']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Pekerjaan Tim" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaantim' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Pekerjaan Tim</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['delegasi_pekerjaan']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Delegasi Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'delegasipekerjaan' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Delegasi Pekerjaan</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pekerjaan_selesai']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Pekerjaan Selesai" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaanselesai' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Pekerjaan Selesai</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pemberian_pekerjaan']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Pemberian Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'pemberianpekerjaan' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Pemberian Pekerjaan</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($is_dirut && $menu_access['monitoring']): ?>
						<div class="menu-item">
							<a class="menu-link menu-hover <?= $page_title == "Monitoring Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'monitoring' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title menu-text-color">Monitoring</span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Monitoring -->
			<?php if (!$is_dirut && $menu_access['monitoring']): ?>
				<div class="menu-item">
					<a class="menu-link menu-hover <?= $page_title == "Monitoring Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'monitoring' ?>">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-calendar-8 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color">Monitoring</span>
					</a>
				</div>
			<?php endif; ?>
			<?php if ($menu_access['manajemen_rapat']): ?>
				<div class="menu-item">
					<a class="menu-link menu-hover <?= $page_title == "Manajemen Rapat" ? "active" : "" ?>" href="<?= base_url() . 'rapat' ?>">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-notepad fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color">Manajemen Rapat</span>
					</a>
				</div>
			<?php endif; ?>
			<?php if ($menu_access['daftar_rapat']): ?>
				<div class="menu-item">
					<a class="menu-link menu-hover <?= $page_title == "Undangan Rapat" ? "active" : "" ?>" href="<?= base_url() . 'rapat/daftarRapat?' . 'status=Terjadwal' ?>">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-note-2 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color">Undangan Rapat</span>
						<?php if ($total_rapat_terjadwal > 0): ?>
							<span class="badge rounded-pill bg-danger text-white fw-semibold">
								<?= $total_rapat_terjadwal ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>

			<!-- OBJECTIVES -->
			<?php if ($menu_access['hse_objective'] || $menu_access['development_commitment'] || $menu_access['development_commitment']): ?>
				<div class="menu-item pt-5">
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7" style="color: #8fc240; padding-bottom: 3px;">CASCADING KPI</span>
					</div>
				</div>

				<?php if ($menu_access['hse_objective']): ?>
					<div class="menu-item">
						<a class="menu-link menu-hover <?= $page_title == "HSSE Objective" ? "active" : "" ?>" href="<?= base_url() . 'hseobjective' ?>">
							<span class="menu-icon">
								<i class="menu-icon-color ki-duotone ki-shield-tick fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title menu-text-color">HSSE Objective</span>
						</a>
					</div>
				<?php endif; ?>

				<?php if ($menu_access['development_commitment']): ?>
					<div class="menu-item">
						<a class="menu-link menu-hover <?= $page_title == "Development Commitment" ? "active" : "" ?>" href="<?= base_url() . 'developmentcommitment' ?>">
							<span class="menu-icon">
								<i class="menu-icon-color ki-duotone ki-briefcase fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title menu-text-color">Development Commitment</span>
						</a>
					</div>
				<?php endif; ?>

				<?php if ($menu_access['community_involvement']): ?>
					<div class="menu-item">
						<a class="menu-link menu-hover <?= $page_title == "Community Involvement" ? "active" : "" ?>" href="<?= base_url() . 'communityinvolvement' ?>">
							<span class="menu-icon">
								<i class="menu-icon-color ki-duotone ki-people fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title menu-text-color">Community Involvement</span>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<!-- ASSESSMENT -->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7" style="color: #8fc240; padding-bottom: 3px;">Assessment</span>
				</div>
			</div>
			<div class="menu-item">
				<a class="menu-link menu-hover <?= $page_title == "Penilaian Akhlak Behavior Survey" ? "active" : "" ?>" href="<?= base_url() . 'abs' ?>">
					<span class="menu-icon">
						<i class="menu-icon-color ki-duotone ki-check-square fs-2">
							<span class="path1"></span><span class="path2"></span>
						</i>
					</span>
					<span class="menu-title menu-text-color">ABS</span>
				</a>
			</div>
			<div class="menu-item">
				<a class="menu-link menu-hover <?= $page_title == "Daftar Penilaian Akhlak" ? "active" : "" ?>" href="<?= base_url() . 'abs/daftarpenilaian' ?>">
					<span class="menu-icon">
						<i class="menu-icon-color ki-duotone ki-tablet-text-down fs-2">
							<span class="path1"></span><span class="path2"></span>
						</i>
					</span>
					<span class="menu-title menu-text-color">Daftar Penilaian</span>
				</a>
			</div>

			<!-- ANALYTICS -->
			<?php if ($show_menu_analytics): ?>
				<div class="menu-item pt-5">
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7" style="color: #8fc240; padding-bottom: 3px;">Analytics</span>
					</div>
				</div>
				<div class="menu-item">
					<a class="menu-link menu-hover <?= $page_title == "Individual Goal Setting" ? "active" : "" ?>" href="<?= base_url() . 'reports' ?>">
						<span class="menu-icon">
							<i class="menu-icon-color ki-duotone ki-chart-pie-4 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</span>
						<span class="menu-title menu-text-color">Reports</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>