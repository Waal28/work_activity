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
		body {
			background: linear-gradient(135deg, #0f4c89, #8fc240);
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.login-card {
			width: 100%;
			max-width: 400px;
			border: 1px solid #ccc;
			padding: 2rem;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			background-color: #ffffff;
		}

		.login-title {
			color: #0f4c89;
			font-weight: bold;
			text-align: center;
		}

		.form-label {
			color: #000000;
		}

		.btn-login {
			background-color: #8fc240;
			color: #000000;
			font-weight: bold;
		}

		.btn-login:hover {
			background-color: #76aa34;
		}

		input.form-control:focus {
			border-color: #5f8f1f !important;
			box-shadow: 0 0 0 0.2rem rgba(95, 143, 31, 0.25);
		}
	</style>
</head>

<body id="kt_body">
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

	<div class="login-card">
		<div class="d-flex flex-column align-items-center">
			<h1 class="login-title w-100" style="border-bottom: 3px solid #8fc240; padding-bottom: 25px; margin-bottom: 20px;">Work Activity System</h1>
			<img src="https://api.iconify.design/streamline:interface-share-user-human-person-share-signal-transmit-user.svg?color=%230f4c89" alt="...." style="width: 80px; height: 80px" class="mb-3">
			<h4 class="login-title mt-5" style="margin-bottom: 20px">Login</h4>
		</div>
		<form novalidate="novalidate" method="POST" action="<?= site_url('auth/login') ?>">
			<div class="mb-3">
				<label for="username" class="form-label" style="color: #0f4c89;">Username</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Username" style="border: 1px solid #8fc240;">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label" style="color: #0f4c89;">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password" style="border: 1px solid #8fc240;">
			</div>
			<button type="submit" class="btn btn-login w-100 text-white">Login</button>
		</form>
		<?php if ($this->session->flashdata('error')): ?>
			<span class="badge badge-danger fs-7 fw-bold mt-10">
				<?= $this->session->flashdata('error') ?>
			</span>
		<?php endif; ?>
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