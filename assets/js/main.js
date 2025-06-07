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

document.addEventListener("DOMContentLoaded", function () {
	const ciToast = document.getElementById("ciToast");
	if (ciToast) {
		const toast = new bootstrap.Toast(ciToast);
		toast.show();
	}
});
