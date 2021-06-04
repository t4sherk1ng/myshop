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
					cards_html += get_card(item[1]);
				});
				$("#cards").append(cards_html);
			},
			error: (error) => {
				console.log(error);
			},
			async: true
		});

	$("#trash").click(() => {
		console.log("Trash");
	});
});

function get_card(name, description="Описание") {
	return `<div class="card" style="width: 18rem; display: inline-block" >
				<div class="card-body">
					<h5 class="card-title">${name}</h5>
					<p class="card-text">${description}</p>
					<a href="#" class="btn btn-primary">Купить</a>
				</div>
			</div>`;
}