<!DOCTYPE html>
<html lang="en">

<head>
	<title>Work Activity</title>
	<meta charset="utf-8" />
	<meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Metronic by Keenthemes" />
	<link rel="canonical" href="http://preview.keenthemes.comindex.html" />
	<link rel="shortcut icon" href="<?= base_url('assets/') ?>media/logos/favicon.ico" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<link href="<?= base_url('assets/') ?>plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/') ?>plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		.tombol-tambah {
			background-color: #0f4c89;
			color: white;
		}

		.tombol-tambah:hover {
			background-color: rgba(12, 58, 103, 1);
			color: white;
		}

		.thead-tabel-objective {
			border-bottom: 2px solid #8fc240 !important;
			background-color: #ccec9c !important;
			color: #0f4c89 !important
		}

		.pegawai-info-objective {
			border: 1px solid #8ec63f !important;
		}

		input,
		textarea,
		select,
		span.select2-selection {
			border: 1px solid #8fc240 !important;
		}

		input:focus,
		textarea:focus,
		span.select2-selection:focus,
		select:focus {
			border-color: #5f8f1f !important;
			box-shadow: 0 0 0 0.2rem rgba(95, 143, 31, 0.25);
		}

		textarea.select2-search__field {
			border: none !important;
		}

		.title-form-data {
			width: fit-content !important;
			padding-bottom: 12px;
			border-bottom: 2px solid #8fc240 !important;
		}
	</style>
</head>

<body id="kt_body" class="aside-enabled">
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
				if (localStorage.getItem("data-bs-theme") !== null) {
					themeMode = localStorage.getItem("data-bs-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
	</script>
	<div class="d-flex flex-column flex-root">
		<!-- Toast -->
		<?php if ($this->session->flashdata('toast')): ?>
			<?php $toast = $this->session->flashdata('toast'); ?>
			<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
				<div id="ciToast" class="toast align-items-center text-white bg-<?= $toast['type'] ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
					<div class="d-flex">
						<div class="toast-body ps-5 pe-5" style="font-size: 14px">
							<?= $toast['message'] ?>
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<!-- end Toast -->
		<div class="page d-flex flex-row flex-column-fluid">
			<!-- Sidebar -->
			<div id="kt_aside" class="aside" style="background-color: #0f4c89" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
				<?php include "partials/user_info.php"; ?>
				<?php include "partials/sidebar.php"; ?>
			</div>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<div id="kt_header" class="header align-items-stretch">
					<div class="header-brand" style="background-color: rgba(9, 44, 79, 1);">
						<div class="d-flex align-items-center">
							<a href="index.html" class="me-5">
								<img alt="Logo" src="https://api.iconify.design/devicon-plain:cloudflareworkers.svg?color=%23ffffff" class="h-25px h-lg-25px" />
							</a>
							<h4 class="text-white p-0 m-0">Work Activity System</h4>
						</div>
						<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-minimize" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
							<i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default" style="color: #ffff !important">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
							<i class="ki-duotone ki-entrance-left fs-1 minimize-active" style="color: #ffff !important">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
						<div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
							<div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
								<i class="ki-duotone ki-abstract-14 fs-1" style="color: #ffff !important">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
						</div>
					</div>
					<!-- Header -->
					<div class="toolbar d-flex align-items-stretch">
						<div class="container-xxl py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
							<div class="page-title d-flex justify-content-center flex-column me-5" style="border-bottom: 2px solid #8fc240;">
								<h1 class="d-flex flex-column text-gray-900 fw-bold fs-3 mb-0"><?= $page_title ?></h1>
								<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
									<li class="breadcrumb-item text-muted"><?= $page_title ?></li>
									<li class="breadcrumb-item">
										<span class="bullet bg-gray-300 w-5px h-2px"></span>
									</li>
									<li class="breadcrumb-item text-gray-900">List</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl">
							<!-- content -->
							<?php include(APPPATH . 'views/' . $content_view . '.php'); ?>

						</div>
					</div>
				</div>
				<!-- Footer -->
				<?php include "partials/footer.php"; ?>
			</div>
		</div>
	</div>
	<!-- modal konfirmasi hapus -->
	<?php $this->load->view('partials/modal_konfirmasi_hapus.php'); ?>
	<!-- end konfirmasi hapus -->
	<script>
		var hostUrl = "<?= base_url('assets/') ?>";
		const BASE_URL = "<?= base_url() ?>";
	</script>
	<script src="<?= base_url('assets/') ?>plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('assets/') ?>js/scripts.bundle.js"></script>
	<script src="<?= base_url('assets/') ?>plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="<?= base_url('assets/') ?>js/widgets.bundle.js"></script>
	<script src="<?= base_url('assets/') ?>js/custom/widgets.js"></script>
	<script src="<?= base_url('assets/') ?>js/custom/apps/chat/chat.js"></script>
	<script src="<?= base_url('assets/') ?>js/custom/utilities/modals/users-search.js"></script>
	<script src="<?= base_url('assets/') ?>js/main.js"></script>
	<script>
		const modalKonfirmasi = document.getElementById("modalKonfirmasiHapus");
		modalKonfirmasi.addEventListener("show.bs.modal", function(event) {
			const button = event.relatedTarget;
			const actionUrl = button.getAttribute("data-href");

			const form = modalKonfirmasi.querySelector("#formHapus");
			form.action = actionUrl;
		});
	</script>
</body>

</html>