<?php
	session_start();
	if(isset($_GET['exit']))
		unset($_SESSION['user']);
	
	if(isset($_SESSION['user'])) {
		if($_SESSION['user'] == 'User')
			readfile('search.html');
		elseif($_SESSION['user'] == 'Admin')
			header("Location: http://localhost:8080/admin_panel.php");
	}
	else
		readfile('authorization.html');
?>