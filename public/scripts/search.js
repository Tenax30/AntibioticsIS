$(document).ready(function() {
	var search_btn = $("#search-btn");
	var search_field = $("#search-field");
	var login = $("#login").val();
	search_btn.click(function(event) {
		// $.ajax {
		// 	// url: 'req_handler.php',
		// 	// method: 'get',
		// 	// dataType: 'html',
		// 	// data: "value=" + search_field.val(),
		// 	// success: function(response) {

		// 	// },
		// 	// error: function(XMLHttpRequest, textStatus, errorThrown) {
		// 	// 	alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
		// 	// 	throw "error";
		// 	// }
		// }
		// event.preventDefault();
		window.location.href = "/search_result.php?value=" + search_field.val();
	});
	search_field.keyup(function(event) {
		if(event.keyCode == 13)
			window.location.href = "/search_result.php?value=" + search_field.val();
	})
});