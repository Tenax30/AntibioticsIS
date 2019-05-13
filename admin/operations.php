<?php

require_once "../connection.php";

$link = mysqli_connect($host, $user, $password, $database);

$operation = $_GET['operation'];
$database = $_GET['database'];
$id = $_GET['id'];

const NULL_ID = -1;

//Удаление записей из баз данных
if($operation == 'delete') {
	if($database == 'usersDB') {
		$query = "DELETE FROM users WHERE id=$id";

		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

		echo $result;;
	}

	elseif($database == 'antibioticsDB') {
		$query = "DELETE FROM elements WHERE id=$id";

		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

		echo $result;
	}
} 

//Редактирование и добавление записей в базы данных
elseif($operation == 'addEdit') {

	if($database == 'usersDB') {
		//Редактирование записи
		if($id != NULL_ID) {
			$query = "
			UPDATE users 
			SET 
				login='" . $_POST['login'] . "', 
				email='" . $_POST['email'] . "', 
				type='" . $_POST['type'] . "'
			WHERE id=" . $id;

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			echo $result;
		}

		//Добавление записи
		/*
			РЕАЛИЗОВАТЬ!!!
		*/
		else {

		}
	}

	elseif($database == 'antibioticsDB') {

		//Редактирование записи
		if($id != NULL_ID) {
			$query = "
			UPDATE elements 
			SET 
				name='" . $_POST['name'] . "', 
				type='" . $_POST['type'] . "', 
				formula='" . $_POST['formula'] . "', 
				smiles='" . $_POST['smiles'] . "', 
				model='" . $_POST['model'] . "',
				description='" . $_POST['description'] . "'
			WHERE id=" . $id;

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			/*
				РЕАЛИЗОВАТЬ ОБНОВЛЕНИЕ КАРТИНКИ!!!
			*/

			echo $result;
		}

		//Добавление записи
		else {
			$query = "INSERT INTO elements VALUES(" . "
				NULL" . ",'" . //id (auto_increment)
				$_POST['name'] . "','" .
				$_POST['type'] . "'," .
				0 . "," .  //toxity
				0 . ",'" . //activity
				$_POST['formula'] . "','" .
				$_POST['description'] . "','" .
				$_POST['smiles'] . "','" . 
				$_POST['model'] . "')";

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			/*
				РЕАЛИЗОВАТЬ ДОБАВЛЕНИЕ КАРТИНКИ!!!
			*/

			echo $result;
		}
	}
}
?>