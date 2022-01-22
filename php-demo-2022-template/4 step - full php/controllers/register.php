<?php
	include "../connect.php";

	// Получение отправленных данных
	$fio = trim($_POST["fio"]);
	$login = trim($_POST["login"]);
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
	$password_check = trim($_POST["password_check"]);

	// Проверка совпадений паролей
	if($password != $password_check)
		return header("Location:../index.php?message=Пароли не совпадают");

	// Проверка поля login на уникальность
	$sql = sprintf("SELECT EXISTS(SELECT * FROM `users` WHERE `login`='%s')", $login);
	if($connect->query($sql)->fetch_array()[0] == "1")
		return header("Location:../index.php?message=Логин занят");

	// Добавление данных в базу
	$sql = sprintf("INSERT INTO `users` VALUES(NULL, '%s', '%s', '%s', '%s', 'user')",
		$connect->real_escape_string($fio),
		$connect->real_escape_string($login),
		$connect->real_escape_string($email),
		$connect->real_escape_string($password)
	);
	
	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успешного добавления
	return header("Location:../index.php?message=Вы успешно зарегистровались");