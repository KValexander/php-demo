<!DOCTYPE html>
<html lang=en>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Demo</title>

		<!-- Подключение стилей -->
		<link rel="stylesheet" href="css/style.css">
		<!-- Подключение библиотеки jquery -->
		<script src="js/jquery-3.6.0.min.js"></script>

		<!-- Подключение файла соединения с базой данной -->
		<?php require("connect.php"); ?>

		<!-- Подключение файла проверки авторизации пользователя -->
		<?php require("middleware/session.php"); ?>
	</head>
	<body>

		<!-- Logo сайта -->
		<div class="logo">
			<div class="content">
				<div class="img">
					<img src="logo/logo.png" alt="">
				</div>
				<div class="text">
					<h1>Сделаем лучше вместе!</h1>
					<h3>Тут какой-то текст как дополнение</h3>
				</div>
			</div>
		</div>

		<header>
			<div class="content">
				<!-- Подключение файла меню -->
				<?php require("menu.php") ?>
			</div>
		</header>

		<div class="message">
			<!-- Вывод сообщения в случае его наличия -->
			<?php if(isset($_GET["message"])) print($_GET["message"]); ?>
		</div>
