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
		<div class="d-flex flex-column flex-lg-row flex-column-fluid">
			<div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
				<div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
					<div class="d-flex flex-stack py-2">
						<div class="me-2"></div>
					</div>
					<div class="py-20">
						<form class="form w-100" novalidate="novalidate" method="POST" action="<?= site_url('auth/login') ?>">
							<div class="card-body">
								<div class="text-start mb-10">
									<h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-in-title">Work Activity</h1>
									<div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">Masukkan Username dan Password</div>
								</div>
								<div class="fv-row mb-8">
									<input type="text" placeholder="Username" name="username" required class=" form-control form-control-solid" />
								</div>
								<div class="fv-row mb-7">
									<input type="password" placeholder="Password" name="password" required class="form-control form-control-solid" />
								</div>
								<div class="d-flex flex-stack">
									<button id="kt_sign_in_submit" class="btn btn-primary me-2 flex-shrink-0">
										<span class="indicator-label" data-kt-translate="sign-in-submit" type="submit">Login</span>
									</button>
								</div>
							</div>
						</form>
						<?php if ($this->session->flashdata('error')): ?>
							<span class="badge badge-danger fs-7 fw-bold mt-10">
								<?= $this->session->flashdata('error') ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="m-0">
					</div>
				</div>
			</div>
			<div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background-image: url(assets/media/auth/bg3.jpg)"></div>
		</div>
	</div>
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
</body>

</html>