$(document).ready(function() {
	const FAIL_LOGIN = -2;
	const FAIL_EMAIL = -1;

	var pressed_btn;
	var field_signIn_pass = $('#pass-field-sign-in');
	var field_signUp_pass = $('#pass-field-sign-up');
	var field_signUp_login = $('#login-field-sign-up');
	var field_signUp_email = $('#email-field');
	var field_signIn_login = $('#login-field-sign-in');

	$("input[type=submit]").click(function(event) {
		pressed_btn = $(this);
	});

	$('form').submit(function(event) {
		event.preventDefault();
		if($(pressed_btn).attr('id') == 'enter-btn') {
			var salt = signIn_checkLogin();
			signIn_checkLogin(function(output) {
				var salt = output;
				signIn_checkPassword(salt, function(output) {
					var accessIsAllowed = output;
					if(accessIsAllowed) 
						window.location.href = "";
					else {
						showMessage("Неверный логин или пароль");
						field_signIn_pass.val('');
						field_signIn_pass.focus();
					}
				});
			});
		}
		else if($(pressed_btn).attr('id') == 'create-acc-btn') {
			signUp_CheckData(function(output) {
				var checkResult = output;
				if(checkResult == FAIL_LOGIN) {
					showMessage("Веденный логин уже используется");
					field_signUp_login.val('');
					field_signUp_login.focus();
				}
				else if(checkResult == FAIL_EMAIL) {
					showMessage("Введенный email уже используется");
					field_signUp_email.val('');
					field_signUp_email.focus();
				}

				//checkResult хранит соль
				else {
					addUser(checkResult, function(output) {
						var isAdded = output;
						if(isAdded)
							window.location.href = "";
						else {
							alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
							throw "error";
						}
					});
				}
			});
		}
	});

	function addUser(salt, callback) {
		var hash = SHA256(field_signUp_pass.val() 
			+ salt) + salt;
		var data = $('#main-form').not('[name="pass"]').serialize() +
		"&hash=" + hash + "&salt=" + salt +
		"&addUser=" + true;
		$.ajax({
			url: 'auth_handler.php',
			method: 'post',
			dataType: 'html',
			data: data,
			success: function(response) {
				// response = response.slice(1); //костыль - сервер возвращает строку с ' в начале
				var obj = $.parseJSON(response);
				if(obj.isAdded) 
					if(callback) callback(true);
				else
					if(callback) callback(false);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
				throw "error";
			}
		});
	}

	//Sign-in
	//Проверяет существует ли логин введенного пользователя
	//в системе
	//Возвращает соль, если пользователь существует или null
	//если пользователь не найден
	function signIn_checkLogin(callback) {
		var data = $('#main-form').not('[name="pass"]').serialize() + 
		"&" + $(pressed_btn).attr('name') +
		"=" + $(pressed_btn).val();
		$.ajax({
			url: 'auth_handler.php',
			method: 'post',
			dataType: 'html',
			data: data,
			success: function(response) {
				// response = response.slice(1); //костыль - сервер возвращает строку с ' в начале
				console.log(response);
				var obj = $.parseJSON(response);
				if(callback) callback(obj.salt);
			},
			error: function() {
				alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
				throw "error";
			}
		});
	}

	function signIn_checkPassword(salt, callback) {
		if(salt == null)
			if(callback) callback(false);
		var hash = SHA256(field_signIn_pass.val() 
			+ salt) + salt;
		var data = $('#main-form').not('[name="pass"]').serialize() +
		"&hash=" + hash + "&checkPass=" + true; 
		$.ajax({
			url: 'auth_handler.php',
			method: 'post',
			dataType: 'html',
			data: data,
			success: function(response) {
				// response = response.slice(1); //костыль - сервер возвращает строку с ' в начале
				var obj = $.parseJSON(response);
				//Доступ разрешен
				if(obj.access) {
					if(callback) callback(true);
				}
				else {
					if(callback) callback(false);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
				throw "error";
			}
		});
	}

	function signUp_CheckData(callback) {
		var result;
		var data = $('#main-form').not('[name="pass"]').serialize() + 
		"&" + $(pressed_btn).attr('name') +
		"=" + $(pressed_btn).val();
		$.ajax({
			url: 'auth_handler.php',
			method: 'post',
			dataType: 'html',
			data: data,
			success: function(response) {
				// response = response.slice(1); //костыль - сервер возвращает строку с ' в начале
				console.log(response);
				var obj = $.parseJSON(response);
				if(obj.loginExist) {
					if(callback) callback(FAIL_LOGIN);
				}
				else if(obj.emailExist) {
					if(callback) callback(FAIL_EMAIL);
				}
				else {
					if(callback) callback(obj.salt);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("Возникла ошибка при выполнении запроса. Попытайтесь еще раз.");
				throw "error";
			}
		});
	}

	function showMessage(text) {
		var message = $('.message');
		$(message).html(text);
		message.addClass("is-selected");
	}
});