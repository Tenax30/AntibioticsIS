// const Databases = Object.freeze({
// 	USERS:   0,
// 	ANTIBIOTICS:  1
// });

// const Operations = Object.freeze({
// 	ADD_EDIT:   0,
// 	DELETE: 1
// });

$(document).ready(function() {
	var users_btn = $('.users-btn');
	var antibiotics_btn = $('.antibiotics-btn');
	var exit_btn = $('.exit-btn');

	//Отображение БД пользователей при начальной загрузке страницы
	loadDatabase('antibioticsDB');
});


// //Загрузка базы данных пользователей
// function loadUsers() {
// 	$.ajax({
// 		type: 'GET',
// 		url: 'admin/data.php?instrument=users',
// 		cache: false,
// 		success: function(html) {
// 			$('.setting').html(html);
// 		}
// 	});
// }

// //Загрузка базы данных антибиотиков
// function loadAntibiotics() {
// 	$.ajax({
// 		type: 'GET',
// 		url: 'admin/data.php?instrument=antibiotics',
// 		cache: false,
// 		success: function(html) {
// 			$('.setting').html(html);
// 		}
// 	});
// }

function loadDatabase(database) {
	$.ajax({
		type: 'GET',
		url: 'admin/data.php?instrument=' + database,
		cache: false,
		success: function(html) {
			$('.setting').html(html);
		}
	});
}

function loadEditForm(form, id) {
	$.ajax({
		type: 'GET',
		url: 'admin/data.php?instrument=' + form + '&id=' + id,
		cache: false,
		success: function(html) {
			$('.setting').html(html);
		}
	});
}

function addEditElement(database, id) {
	var data = $('.edit-form').serialize();
	$.ajax({
		type: 'POST',
		url: 'admin/operations.php?operation=addEdit' +
		'&database=' + database + '&id=' + id,
		datatype: 'html',
		data: data,
		success: function(isSuccessfully) {
			alert(isSuccessfully);
		}
	});
}

function deleteElement(database, id) {
	$.ajax({
		type: 'GET',
		url: 'admin/operations.php?operation=delete' + 
		'&database=' + database + '&id=' + id,
		success: function(isDeleted) {
			if(isDeleted)
				loadDatabase(database);
			else
				alert("Ошибка при выполнении запроса. Попробуйте снова");
		}
	});
}

function exit() {
	var xhr = new XMLHttpRequest();

	xhr.open('GET', 'localhost:8080?exit', false);

	xhr.send();

	if (xhr.status != 200) {
		alert( xhr.status + ': ' + xhr.statusText ); 
	} else {
		window.location.href = "localhost:8080";
	}
}