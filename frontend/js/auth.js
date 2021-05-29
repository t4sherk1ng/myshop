$(document).ready(()=> {
	$("#sign_in").click(()=>{
		let form_data = {
			login: $('input[name="login"]').val(),
			password: $('input[name="password"]').val(),
			method: "sign_in"
		};
		$.ajax({
			method: "POST",
			url: "api/api.php",
			data: form_data,
			dataType: "JSON",
			success: (response) => {
				
				if (response[0]=='ok') {
					document.cookie = 'user='+response[1];
					document.location.reload();
				}
			},
			error: (error) => {
				console.log(error);
			},
			async: true
		});
	});
	$("#sign_up").click(() => {
		let form_data = {
			login: $('input[name="login"]').val(),
			password: $('input[name="password"]').val(),
			method: "sign_up"
		};
		$.ajax({
			method: "POST",
			url: "api/api.php",
			data: form_data,
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
	$("#guest").click(() => {
		$.ajax({
			method: "POST",
			url: "api/api.php",
			data: {method: "guest"},
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