<?php
$menu_access = $this->session->userdata('menu_access');
$is_dirut = $this->session->userdata('role') == 'Direktur Utama';
?>

<div class="aside-menu flex-column-fluid">
	<div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
		<div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

			<!-- Dashboard -->
			<?php if ($menu_access['dashboard']): ?>
				<div class="menu-item">
					<a class="menu-link <?= $page_title == "Dashboard" ? "active" : "" ?>" href="<?= base_url('dashboard') ?>">
						<span class="menu-icon">
							<i class="ki-duotone ki-element-11 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title">Dashboard</span>
					</a>
				</div>
			<?php endif; ?>
			<!-- Section: Menu -->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Menu</span>
				</div>
			</div>

			<!-- Pekerjaan -->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
				<span class="menu-link">
					<span class="menu-icon">
						<i class="ki-duotone ki-message-text-2 fs-2">
							<span class="path1"></span>
							<span class="path2"></span>
							<span class="path3"></span>
						</i>
					</span>
					<span class="menu-title"><?= $is_dirut ? "Management" : "Cascading KPI" ?></span>
					<span class="menu-arrow"></span>
				</span>
				<?php
				$menu_pekerjaan = ["Pekerjaan Saya", "Pekerjaan Tim", "Pekerjaan Selesai", "Pemberian Pekerjaan"];
				?>
				<div class="menu-sub menu-sub-accordion <?= in_array($page_title, $menu_pekerjaan) || ($is_dirut && $page_title == "Monitoring Pekerjaan") ? "show" : "" ?>">
					<?php if ($menu_access['pekerjaan_saya']): ?>
						<div class="menu-item">
							<a class="menu-link <?= $page_title == "Pekerjaan Saya" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaansaya' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Pekerjaan Saya</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pekerjaan_tim']): ?>
						<div class="menu-item">
							<a class="menu-link <?= $page_title == "Pekerjaan Tim" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaantim' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Pekerjaan Tim</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pekerjaan_selesai']): ?>
						<div class="menu-item">
							<a class="menu-link <?= $page_title == "Pekerjaan Selesai" ? "active" : "" ?>" href="<?= base_url() . 'pekerjaanselesai' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Pekerjaan Selesai</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($menu_access['pemberian_pekerjaan']): ?>
						<div class="menu-item">
							<a class="menu-link <?= $page_title == "Pemberian Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'pemberianpekerjaan' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Pemberian Pekerjaan</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($is_dirut && $menu_access['monitoring']): ?>
						<div class="menu-item">
							<a class="menu-link <?= $page_title == "Monitoring Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'monitoring' ?>">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Monitoring</span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Monitoring -->
			<?php if (!$is_dirut && $menu_access['monitoring']): ?>
				<div class="menu-item">
					<a class="menu-link <?= $page_title == "Monitoring Pekerjaan" ? "active" : "" ?>" href="<?= base_url() . 'monitoring' ?>">
						<span class="menu-icon">
							<i class="ki-duotone ki-calendar-8 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
								<span class="path6"></span>
							</i>
						</span>
						<span class="menu-title">Monitoring</span>
					</a>
				</div>
			<?php endif; ?>

			<!-- OBJECTIVES -->
			<?php if ($menu_access['hse_objective'] || $menu_access['development_commitment'] || $menu_access['development_commitment']): ?>
				<div class="menu-item pt-5">
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7">Objectives</span>
					</div>
				</div>

				<?php if ($menu_access['hse_objective']): ?>
					<div class="menu-item">
						<a class="menu-link <?= $page_title == "HSSE Objective" ? "active" : "" ?>" href="<?= base_url() . 'hseobjective' ?>">
							<span class="menu-icon">
								<i class="ki-duotone ki-shield-tick fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">HSSE Objective</span>
						</a>
					</div>
				<?php endif; ?>

				<?php if ($menu_access['development_commitment']): ?>
					<div class="menu-item">
						<a class="menu-link <?= $page_title == "Development Commitment" ? "active" : "" ?>" href="<?= base_url() . 'developmentcommitment' ?>">
							<span class="menu-icon">
								<i class="ki-duotone ki-briefcase fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Development Commitment</span>
						</a>
					</div>
				<?php endif; ?>

				<?php if ($menu_access['community_envelopment']): ?>
					<div class="menu-item">
						<a class="menu-link <?= $page_title == "Community Envelopment" ? "active" : "" ?>" href="<?= base_url() . 'communityenvelopment' ?>">
							<span class="menu-icon">
								<i class="ki-duotone ki-people fs-2">
									<span class="path1"></span><span class="path2"></span>
								</i>
							</span>
							<span class="menu-title">Community Envelopment</span>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<!-- ASSESSMENT -->
			<div class="menu-item pt-5">
				<div class="menu-content">
					<span class="menu-heading fw-bold text-uppercase fs-7">Assessment</span>
				</div>
			</div>
			<div class="menu-item">
				<a class="menu-link <?= $page_title == "Penilaian Akhlak Behavior Survey" ? "active" : "" ?>" href="<?= base_url() . 'abs' ?>">
					<span class="menu-icon">
						<i class="ki-duotone ki-check-square fs-2">
							<span class="path1"></span><span class="path2"></span>
						</i>
					</span>
					<span class="menu-title">ABS</span>
				</a>
			</div>
			<div class="menu-item">
				<a class="menu-link <?= $page_title == "Daftar Penilaian Akhlak" ? "active" : "" ?>" href="<?= base_url() . 'abs/daftarpenilaian' ?>">
					<span class="menu-icon">
						<i class="ki-duotone ki-tablet-text-down fs-2">
							<span class="path1"></span><span class="path2"></span>
						</i>
					</span>
					<span class="menu-title">Daftar Penilaian</span>
				</a>
			</div>

			<!-- ANALYTICS -->
			<?php if (!$is_dirut): ?>
				<div class="menu-item pt-5">
					<div class="menu-content">
						<span class="menu-heading fw-bold text-uppercase fs-7">Analytics</span>
					</div>
				</div>
				<div class="menu-item">
					<a class="menu-link <?= $page_title == "Individual Goal Setting" ? "active" : "" ?>" href="<?= base_url() . 'reports' ?>">
						<span class="menu-icon">
							<i class="ki-duotone ki-chart-pie-4 fs-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
							</i>
						</span>
						<span class="menu-title">Reports</span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>