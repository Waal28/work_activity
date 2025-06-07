document.addEventListener("DOMContentLoaded", function () {
	const ciToast = document.getElementById("ciToast");
	if (ciToast) {
		const toast = new bootstrap.Toast(ciToast);
		toast.show();
	}
});
