<?php
	// Подключение файла соединения с базой данной
	require("../connect.php");
	// Старт сессии
	session_start();

	// Если пользователь не авторизован
	if($_SESSION["auth"] != true) {
		// Запись полученных данных в переменные с обработкой
		$login = $link->real_escape_string(trim($_GET["login"]));
		$password = $link->real_escape_string(trim($_GET["password"]));

		// Составление sql запроса на получение данных пользователя
		$user_sql = sprintf("
			SELECT `user_id`, `role` FROM `users` WHERE `login` = '%s' AND `password` = '%s'",
			$login, $password
		);

		// Выполнение запроса
		$result = $link->query($user_sql);

		// Если пользователь найден
		if($link->affected_rows == 1) {
			// Получение данных из запроса
			$row = $result->fetch_array();

			// Запись данных в сессии
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["role"] = $row["role"];
			$_SESSION["auth"] = true;

			// Перенаправление пользователя в личный кабинет
			header("Location: ../user_page.php?user_id=". $row["user_id"]);
			exit;

		// Если пользователь не найден
		} else {
			// Перенаправление пользователя на страницу авторизации с сообщением об ошибке
			header("Location: ../index.php#login?message=Ошибка логина или пароля");
			exit;
		}
	// Если пользователь авторизован
	} else {
		// Перенаправление пользователя в личный кабинет с сообщением об ошибке
		header("Location: ../user_page.php?user_id=". $_SESSION["user_id"] ."&message=Вы уже авторизованы");
		exit;
	}
?>