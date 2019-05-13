<?php
session_start();
if(isset($_GET['exit'])) 
	unset($_SESSION['user']);
if(!isset($_SESSION['user']))
	header('Location: /');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="text/html" charset="utf-8">
	<title><?php echo $_GET['value'] . " - Информационный портал"; ?></title>
	<link rel="stylesheet" href="public/css/reset.css">
	<link rel="stylesheet" href="public/css/search-result.css">
	<link rel="stylesheet" href="public/css/user-menu.css">
</head>
<body>
	<menu class="user-menu">
		<ul>
			<!-- <li class="menu-separator"></li> -->
			<li class="menu-item">
				<a class="exit-btn" href="?exit">
					Выйти
				</a>
			</li>
		</ul>
	</menu>
	<div class="wrapper">
		<header>
			<div class="search-form">
				<a href="/"><img src="public/images/search.png" alt="Лого"></a>
				<input type="text" id="search-field" name="search-field" value="<?php echo $_GET['value'] ?>">
				<input type="button" id="search-btn" name="search-btn" value="Найти">
			</div>
			<div class="avatar">
				<p>
					<?php
					if(isset($_SESSION['user']))
						echo substr($_SESSION['user'], 0, 1);
					else
						echo "?";
					?>
				</p>
			</div>
		</header>
		<main>
			<h1>Результаты поиска</h1>
			<p>Найдено элементов: 
				<?php
				require_once "connection.php";

				// header('Content-Type:text/html; charset=utf-8');

				$name = $_GET['value'];
				// if($name == NULL)
				// {}
				// else {
				$link = mysqli_connect($host, $user, $password, $database);
					// mysqli_set_charset($link, 'utf8');
					// mysqli_query($link, "SET NAMES 'utf8'");
					// mysqli_query($link, "SET CHARACTER SET 'utf8'");
					// mysqli_query($link, "set SESSION collation_connection='utf8_general_ci'");
				$query = "SELECT * FROM elements WHERE name LIKE '%$name%'";

				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
				$num_items = mysqli_num_rows($result);


				echo $num_items . "</p>";
				if(mysqli_num_rows($result) != 0) {
					echo "<form class='result-blocks'>";
					echo 
					"<table class='result'>
					<tr>
					<th>№</th>
					<th>Название</th>
					<th>Тип</th>
					<th>Токсичность</th>
					<th>Противогрибковая<br> активность</th>
					<th>Структура</th>
					</tr>";
					for($i = 1; $row = mysqli_fetch_array($result); $i++) {
						echo 
						"<tr>
						<td>" . $i . "</td>
						<td><a href='element.php?name=" . $row['name'] . "'>". $row['name'] . "</a></td>
						<td>" . $row['type'] . "</td>
						<td>" . $row['toxity'] . "</td>
						<td>" . $row['activity'] . "</td>
						<td><img src='public/images/elements/mini/" . $row['id'] . ".png' alt='Структура'></img></td>
						</tr>
						";
					}
					echo "</table></form>";
				}
				?>
				<!-- <img class="logo" src="public/images/logo.jpg"> -->
			</main>
			<footer class="copyright">
				<p>&copy Copyright 2019</p>
			</footer>
		</div>

	<!-- Insert this line above script imports  -->
	<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>

	<script type="text/javascript" src="public/scripts/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="public/scripts/search.js"></script>
	<script type="text/javascript" src="public/scripts/user-menu.js"></script>

	<!-- Insert this line after script imports -->
	<script>if (window.module) module = window.module;</script>

	</body>
	</html>