<?php
require_once "connection.php";

//Sign-up
if(isset($_POST['create-acc-btn'])) {
	$link = mysqli_connect($host, $user, $password, $database) 
	or die("Ошибка " . mysqli_error($link));

	$login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
	$email =  htmlentities(mysqli_real_escape_string($link, $_POST['email']));

	echo checkAccount($link, $login, $email);

	mysqli_close($link);
}

//Sign-in - проверка логина
elseif (isset($_POST['login-btn'])) {
	$link = mysqli_connect($host, $user, $password, $database) 
	or die("Ошибка " . mysqli_error($link));

	$login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));

	echo authUser($link, $login);
	

	mysqli_close($link);
}

//Добавление нового пользователя в базу данных
elseif (isset($_POST['addUser']) && $_POST['addUser'] == true) {
	$link = mysqli_connect($host, $user, $password, $database) 
	or die("Ошибка " . mysqli_error($link));

	$login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));
	$email =  htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	$hash = $_POST['hash'];
	$salt = $_POST['salt'];
	$type = 'User';

	echo addUser($link, $login, $email, $hash, $salt, $type);

	mysqli_close($link);
}

//Sign-in - проверка правильности введенного пароля
elseif (isset($_POST['checkPass']) && $_POST['checkPass'] == true) {
	$link = mysqli_connect($host, $user, $password, $database) 
	or die("Ошибка " . mysqli_error($link));

	$login = htmlentities(mysqli_real_escape_string($link, $_POST['login']));

	$hash = $_POST['hash'];

	echo checkPassword($link, $login, $hash);

	mysqli_close($link);
}

else {
	echo "Ошибка";
}

//Sign-up
//Проверяет, зарегистрированы ли уже введенный email и логин
//возвращает массив, в котором указано что именно совпадает
//если совпадений нет, генерирует соль для нового пользователя и
//добавляет ее в массив
function checkAccount($link, $login, $email) {
	// $response = array('loginExist' => NULL, 'emailExist' => NULL, 'salt' => NULL);

	$response = array('loginExist' => NULL);

	$query = "SELECT * FROM users WHERE login='$login'";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	$response['loginExist'] = (mysqli_num_rows($result) == 0) ? false : true;

	//Проверка существования логина
	if(!$response['loginExist']) {

		$query = "SELECT * FROM users WHERE email='$email'";

		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

		$response['emailExist'] = (mysqli_num_rows($result) == 0) ? false : true;

		//Проверка существования e-mail
		if(!$response['emailExist']) {
			$response['salt'] = generate_salt();
		}
	}

	return json_encode($response);
}

//Sign-up
//Функция пытается добавить нового пользователя в базу данных
//Возвращает true, если добавление прошло успешно, иначе - false
function addUser($link, $login, $email, $hash, $salt, $type) {
	$response = array('isAdded' => false);

	$query = "INSERT INTO users VALUES(NULL, '$login', '$email', '$hash', '$salt', '$type')";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	if($result)
		$response['isAdded'] = true;
	else
		$response['isAdded'] = false;

	if($response['isAdded'])
		startSession($type);

	return json_encode($response);
}

//Sign-in
//Проверка существования пользователя в БД,
//при авторизации
//Возвращает соль, если пользователь существует,
//иначе возвращает NULL
function authUser($link, $login) {
	$response = array('salt' => NULL);

	$query = "SELECT salt FROM users WHERE login='$login'";	

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	//Пользователь существует
	if(mysqli_num_rows($result) != 0) {
		$row = mysqli_fetch_row($result);
		$response['salt'] = $row[0];
	}

	return json_encode($response);
}

//Sign-in проверка пароля
function checkPassword($link, $login, $hash) {
	$response = array('access' => NULL);

	$query = "SELECT * FROM users WHERE login='$login'
	 AND hash='$hash'";	

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	if($result) {
		$response['access'] = (mysqli_num_rows($result) == 0) ? false : true;
	}

	if($response['access']) {
		$user = mysqli_fetch_array($result);
		startSession($user['type']);
	}
	return json_encode($response);
}

//Генерирует соль для нового пользователя
function generate_salt() {
	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
		.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
		.'0123456789!@#$%^&*()-=+');
	shuffle($seed);
	$salt = '';
	$size = rand(5, 10);
	foreach (array_rand($seed, $size) as $k) {
		$salt .= $seed[$k];
	}
	return $salt;
}

function startSession($type) {
	session_start();
	$_SESSION['user'] = $type;
}
?>