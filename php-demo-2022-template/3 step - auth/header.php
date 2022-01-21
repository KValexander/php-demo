<?php
	// Вывод сообщения в случае наличия get параметра message
	$message = "";
	if(isset($_GET["message"]))
		$message = sprintf('<div class="message">%s</div>', $_GET["message"]);

	// Получение роли
	$role = "guest";
	if(isset($_SESSION["role"]))
		$role = $_SESSION["role"];

	// Составление меню
	$menu = "";
	switch($role) {
		case "guest":
			$menu = '
				<p><a href="index.php#register">Регистрация</a></p>
				<p><a href="index.php"><img src="logo/logo.png" alt=""></a></p>
				<p><a href="index.php#login">Войти</a></p>
			';
		break;
		case "user":
			$menu = '
				<p><a href="profile.php">Личный кабинет</a></p>
				<p><a href="index.php"><img src="logo/logo.png" alt=""></a></p>
				<p><a href="controllers/logout.php">Выход</a></p>
			';
		break;
		case "admin":
			$menu = '
				<p><a href="index.php"><img src="logo/logo.png" alt=""></a></p>
				<p><a href="profile.php">Личный кабинет</a></p>
				<p><a href="admin.php">Заявки</a></p>
				<p><a href="controllers/logout.php">Выход</a></p>
			';
		break;
	};
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Demoexam2022</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<header>
		<div class="top">
			<h1>Заголовок</h1>
			<h2>Дополнительный текст</h2>
		</div>
		<div class="content">
			<nav><?= $menu ?></nav>
		</div>
	</header>

	<?= $message ?>