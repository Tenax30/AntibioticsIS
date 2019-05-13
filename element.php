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
	<meta charset="UTF-8">
	<title><?php echo $_GET['name'] . " - Информационный портал"; ?></title>
	<link rel="stylesheet" href="public/css/reset.css">
	<link rel="stylesheet" href="public/css/search-result.css">
	<link rel="stylesheet" href="public/css/element.css">
	<link rel="stylesheet" href="public/css/user-menu.css">
</head>
<body>
	<menu class="user-menu">
		<ul>
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
				<input type="text" id="search-field" name="search-field">
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
			<?php
			require_once "connection.php";

			$link = mysqli_connect($host, $user, $password, $database);

				// $name = $_GET['name'];

			$query = "SELECT * FROM elements WHERE name='" . $_GET['name'] . "'";
			$result = mysqli_query($link, $query) or die("Элемент не найден");
			$element = mysqli_fetch_array($result);

			$elem_names = array();
			$query = "SELECT name FROM chem_names WHERE element_id=" . $element['id'];
			$result = mysqli_query($link, $query) or die("Элемент не найден");
			while($row = mysqli_fetch_array($result)) {
				$elem_names[] = $row['name'];
			}

			$description = explode("\n", $element['description']);

			echo "
				<h1>" . $element['name'] . "</h1>
				<div class='structure'>
					<iframe class='_3D' src='https://embed.molview.org/v1/?mode=balls&cid=" . 
					$element['model'] . "'></iframe>
					<img class='_2D' src='public/images/elements/full/" . $element['id'] . ".png' alt='" . $element['name'] . "'>
					<p class='name'>"  . $element['name'] . "</p>
				</div>
				<div class='formula'>
					<h2>Молекулярная формула</h2>
					<p>"; 

					$formula = $element['formula'];
					$addSub = false;
					for($i = 0; $i < strlen($formula); $i++) {
						if(is_numeric($formula[$i]) && !$addSub) {
							$formula = substr_replace($formula, "<sub>", $i, 0);
							$addSub = true;
							$i += strlen("<sub>");
						}
						elseif(!is_numeric($formula[$i]) && $addSub) {
							$formula = substr_replace($formula, "</sub>", $i, 0);
							$addSub = false;
							$i += strlen("</sub>");
						}

					} 
			echo $formula . "</p>
			</div>
			<div class='smiles'>
			<h2>Smiles</h2>
			<p>" . wordwrap($element['smiles'], 45, "<br>", true) . "</p>
			</div>
			<div class='type'>
			<h2>Тип</h2>
			<p>" . $element['type'] . "</p>
			</div>
			<div class='names'>
			<h2>Химические названия</h2>
			<ol>";

			for($i = 0; $i < count($elem_names); $i++)
				echo "<li>" . $elem_names[$i] . "</li>";
			echo "
			</ol>
			<p></p>
			</div>						
			<div class='toxity'>
			<h2>Прогнозируемая токсичность</h2>
			<p>" . $element['toxity'] . "</p>
			</div>
			<div class='activity'>
			<h2>Прогнозируемая противогрибковая активность</h2>
			<p>" . $element['activity'] . "</p>
			</div>
			<div class='description'>
			<h2>Описание</h2>";

			for($i = 0; $i < count($description); $i++)
				echo "<p>" . $description[$i] . "</p>";

			echo "
			</div>
			";
			?>
		</main>
		<footer>
			<div class="copyright">
				<p>&copy Copyright 2019</p>
			</div>
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