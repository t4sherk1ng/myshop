$(document).ready(() => {
	$("#exit").click(() => {
		document.cookie = "user= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
		document.location.reload();
	});

	$.ajax({
			method: "POST",
			url: "api/api.php",
			data: {method: "get_all_products"},
			dataType: "JSON",
			success: (response) => {
				console.log(response);
				let cards_html = "";
				response.forEach((item) => {
					cards_html += get_card(item[1], item[0]);
				});
				$("#cards").append(cards_html);
			},
			error: (error) => {
				console.log(error);
			},
			async: true
		});

	$("#trash").click(() => {
		$.ajax({
			method: "POST",
			url: "api/api.php",
			data: {method: "get_trash", login: document.cookie.match("user\=(.+?)\;")[1]},
			dataType: "JSON",
			success: (response) => {
				console.log(response);
			},
			error: (error) => {
				console.log(error);
			},
			async: true
		});
	});


});

function get_card(name, good_id, description="Описание") {
	return `<div class="card" style="width: 18rem; display: inline-block" >
				<div class="card-body">
					<h5 class="card-title">${name}</h5>
					<p class="card-text">${description}</p>
					<a href="#" id="buy" class="btn btn-primary" onclick="buy(this)" value="${good_id}">Купить</a>
				</div>
			</div>`;
}

function buy(el) {
	$.ajax({
		method: "POST",
		url: "api/api.php",
		data: {method: "buy", login: document.cookie.match("user\=(.+?)\;")[1], good_id: el.getAttribute("value")},
		dataType: "JSON",
		success: (response) => {
			console.log(response);
		},
		error: (error) => {
			console.log(error);
		},
		async: true
	});
	console.log(el.getAttribute("value"));

}