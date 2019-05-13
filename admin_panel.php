<?php
session_start();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Информационная система</title>
	<link rel="stylesheet" href="public/css/reset.css">
	<link rel="stylesheet" href="public/css/admin-panel.css">
</head>
<body>
	<header>
		<img class="logo" src="public/images/search.png" alt="Лого">
		<img class="project-name" src="public/images/project_name.png" alt="Название">
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
		<div class="info-label">Панель администратора</div>
	</header>
	<main>
		<section class="instruments">
			<nav>
				<ul>
					<li>
						<a onclick="loadDatabase('usersDB')">
							<img class="icon" src="public/images/admin/users-icon.png">
							<span class="instrument-label">Пользователи</span>
						</a>
					</li>
					<li>
						<a onclick="loadDatabase('antibioticsDB')">
							<img class="icon" src="public/images/admin/antibiotics-icon.png">
							<span class="instrument-label">Антибиотики</span>
						</a>
					</li>
					<li>
						<a onclick="exit()">
							<img class="icon" src="public/images/admin/exit-icon.png">
							<span class="instrument-label">Выход</span>
						</a>
					</li>
				</ul>
			</nav>
		</section>
		<section class="setting">
			
		</section>
	</main>

	<!-- Scriptrs -->

	<script type="text/javascript" src="public/scripts/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="public/scripts/admin_panel.js"></script>
</body>
</html>