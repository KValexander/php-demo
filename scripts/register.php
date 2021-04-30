<?php
	// Если пользователь авторизован
	if($_SESSION["auth"] == true) {
		// Перенаправление пользователя в личный кабинет с сообщением об ошибке
		header("Location: ../user_page.php?user_id=". $_SESSION["user_id"] ."&message=Вы уже авторизованы");
		exit;
	}
	
	// Подключение файла соединения с базой данной
	require("../connect.php");

	// Запись полученных данных в переменные с обработкой
	$fio = $link->real_escape_string(trim($_REQUEST["fio"]));
	$login = $link->real_escape_string(trim($_REQUEST["login"]));
	$email = $link->real_escape_string(trim($_REQUEST["email"]));
	$password = $link->real_escape_string(trim($_REQUEST["password"]));
	$password_check = $link->real_escape_string(trim($_REQUEST["password_check"]));
	$privacy = $link->real_escape_string(trim($_REQUEST["privacy"]));

	// Проверка наличия логина в базе
	$register_sql = "SELECT * FROM `users` WHERE `login`=". $login;
	$result = $link->query($register_sql);
	// Если логин есть
	if ($result->num_rows != 0) {
		header("location: ../index.php?message='Логин занят'");
		exit;
	}

	// Запрос на добавление данных в базу
	$insert_sql = sprintf("
		INSERT INTO `users`(`fio`, `login`, `email`, `password`, `role`) VALUES ('%s', '%s', '%s', '%s', '%s')",
		$fio, $login, $email, $password, "user"
	);

	// Выполнение запроса, в случае неудачи вывод сообщения об ошибке
	if(!$link->query($insert_sql)) {
		header("Location: ../index.php?message=Ошибка вставки данных");
		exit;
	}

	// Перенаправление на страницу входа в случае успеха
	header("Location: ../index.php?message=Вы зарегистрировались");
	exit;

?>