function formHandler({ form, formErrorAlert } = {}) {
	if (!form.element) {
		console.error("Elemen form tidak ditemukan");
		return;
	}

	function setValue(el, value = "") {
		if (!el) return;
		el.value = value;
		if ($(el).hasClass("select2-hidden-accessible")) {
			$(el).trigger("change");
		}
	}

	const openForm = ({ data = {}, formTitle, actionUrl } = {}) => {
		form.title.innerText = formTitle;
		form.element.action = BASE_URL + actionUrl;

		for (const [key, el] of Object.entries(form.fields)) {
			setValue(el, data?.[key] ?? "");
		}
	};

	const clearErrorForm = ({ isClickEdit = false } = {}) => {
		if (formErrorAlert) formErrorAlert.innerHTML = "";

		if (!isClickEdit) {
			for (const el of Object.values(form.fields)) {
				setValue(el, "");
			}
		}
	};

	return {
		openForm,
		clearErrorForm,
	};
}

const modalKonfirmasi = document.getElementById("modalKonfirmasiHapus");
modalKonfirmasi.addEventListener("show.bs.modal", function (event) {
	const button = event.relatedTarget;
	const actionUrl = button.getAttribute("data-href");

	const form = modalKonfirmasi.querySelector("#formHapus");
	form.action = actionUrl;
});
