class MZLDR_Update_Notice {
    constructor() {
		this.load();
	}
	
	load() {
		const data = {
			nonce: document.querySelector('#mazloader-admin > input[type="hidden"][name="_wpnonce"]').value,
			action: 'mzldr_show_update_notice',
		};

		let query = Object.keys(data)
			.map(k => encodeURIComponent(k) + '=' + encodeURIComponent(data[k]))
			.join('&');

		// do ajax call
		fetch(mzldr_js_object.ajax_url + '?' + query)
		.then(function(response) {
			return response.json();
		})
		.then(function (data) {
			if (!data.html) {
				return;
			}

			var tmpElem = document.createElement("div");
			tmpElem.innerHTML = data.html;

			document.querySelector('#mazloader-admin .mazloader-content').insertBefore(tmpElem.firstChild, document.querySelector('#mazloader-admin .mazloader-content').firstChild);
		});
	}
}
document.addEventListener(
	'DOMContentLoaded',
	function(event) {
	new MZLDR_Update_Notice();
});