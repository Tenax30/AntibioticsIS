<?php

const NULL_ID = -1;

require_once "../connection.php";

$link = mysqli_connect($host, $user, $password, $database);

if(isset($_GET['id']))
	$id = $_GET['id'];

switch ($_GET['instrument']) {

	//Отображение базы данных пользователей
	case 'usersDB':

		$query = "SELECT * FROM users";

		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

		$num_records = mysqli_num_rows($result);

		echo "<h2>Пользователи</h2>
		<span>Количесвто записей: " . $num_records . "</span>
		<a class='add-button' onclick=loadEditForm('usersEditForm'," . NULL_ID . ")><img class='icon' src='public/images/admin/add_icon.png'  alt='Добавить'></a>";

		echo 
		"<div class='main-table'><table>
		<tr>
		<th>ID</th>
		<th>Логин</th>
		<th>Пароль</th>
		<th>Тип</th>
		<th>Действия</th>
		</tr>";

		for($i = 1; $row = mysqli_fetch_array($result); $i++) {
			echo 
			"<tr>
			<td>" . $row['id'] . "</td>
			<td>" . $row['login'] . "</td>
			<td>" . "*****" . "</td>
			<td>" . $row['type'] . "</td>
			<td>" . 
			"<a class='edit-button' onclick=loadEditForm('usersEditForm',". $row["id"] . ")><img class='icon' src='public/images/admin/edit_icon.png' alt='Редактировать'></a>" .
			"<a class='delete-button' onclick=deleteElement('usersDB'," . $row['id'] . ")><img class='icon' src='public/images/admin/delete_icon.png'  alt='Редактирвать'></a>" .  
			"</td>" .
			"</tr>";
		}

		echo "</table></div>";

		break;

	//Отображение базы данных антибиотиков
	case 'antibioticsDB':
		$query = "SELECT * FROM elements";

		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

		$num_records = mysqli_num_rows($result);

		echo "<h2>Противогрибковые антибиотики</h2>
		<span>Количесвто записей: " . $num_records . "</span>
		<a class='add-button' onclick=loadEditForm('antibioticsEditForm'," .NULL_ID . ")><img class='icon' src='public/images/admin/add_icon.png'  alt='Добавить'></a>";

		echo 
		"<div class='main-table'><table>
		<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Молекулярная формула</th>
		<th>Тип</th>
		<th>Токсичность</th>
		<th>Противогрибковая активность</th>
		<th>Действия</td>
		</tr>";

		for($i = 1; $row = mysqli_fetch_array($result); $i++) {
			echo 
			"<tr>
			<td>" . $row['id'] . "</td>
			<td>" . $row['name'] . "</td>
			<td>" . $row['formula'] . "</td>
			<td>" . $row['type'] . "</td>
			<td>" . $row['toxity'] . "</td>
			<td>" . $row['activity'] . "</td>
			<td>" . 
			"<a class='edit-button' onclick=loadEditForm('antibioticsEditForm'," . $row["id"] . ")><img class='icon' src='public/images/admin/edit_icon.png' alt='Редактировать'></a>" .
			"<a class='delete-button' onclick=deleteElement('antibioticsDB'," . $row['id'] . ")><img class='icon' src='public/images/admin/delete_icon.png'  alt='Редактирвать'></a>" . 
			"</td>" .
			"</tr>";
		}

		echo "</table></div>";
		break;

	//Отображение формы редактирования элемента БД пользователей
	case 'usersEditForm':
		$setting = file_get_contents('add_edit_users_form.html');

		if($id != NULL_ID) {

			$query = "SELECT login, email, type FROM users WHERE id=$id";

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			$user = mysqli_fetch_array($result);

			$setting = str_replace('%login%', $user['login'], $setting);
			$setting = str_replace('%email%', $user['email'], $setting);
		}
		else {
			$setting = str_replace('%login%', '', $setting);
			$setting = str_replace('%email%', '', $setting);
		}

		$setting = str_replace('%database%', '"usersDB"', $setting);
		$setting = str_replace('%id%', $id, $setting);

		echo $setting;

		break;

	//Отображение формы редактирования элемента БД антибиотиков
	case 'antibioticsEditForm':

		$setting = file_get_contents('add_edit_antibiotics_form.html');

		if($id != NULL_ID) {
			$query = "SELECT name, formula, type, smiles, model, description FROM elements WHERE id=$id";

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			$element = mysqli_fetch_array($result);

			$setting = str_replace('%name%', $element['name'], $setting);
			$setting = str_replace('%formula%', $element['formula'], $setting);
			$setting = str_replace('%smiles%', $element['smiles'], $setting);
			$setting = str_replace('%model%', $element['model'], $setting);
			$setting = str_replace('%description%', $element['description'], $setting);
		}

		else {
			$setting = str_replace('%name%', '', $setting);
			$setting = str_replace('%formula%', '', $setting);
			$setting = str_replace('%smiles%', '', $setting);
			$setting = str_replace('%model%', '', $setting);
			$setting = str_replace('%description%', '', $setting);
		}

		$setting = str_replace('%database%', '"antibioticsDB"', $setting);
		$setting = str_replace('%id%', $id, $setting);

		echo $setting;

		break;
}

?>