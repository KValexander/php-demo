<?php
	include "../connect.php";

	// Получение отправленных данных
	$fio = $_POST["fio"];
	$login = $_POST["login"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$password_check = $_POST["password_check"];

	// Проверка совпадений паролей
	if($password != $password_check)
		return header("Location:../index.php?message=Пароли не совпадают");

	// Проверка поля login на уникальность
	$sql = sprintf("SELECT EXISTS(SELECT * FROM `users` WHERE `login`='%s')", $login);
	if($connect->query($sql)->fetch_array()[0] == "1")
		return header("Location:../index.php?message=Логин занят");

	// Добавление данных в базу
	$sql = sprintf("INSERT INTO `users` VALUES(NULL, '%s', '%s', '%s', '%s', 'user')",
		$fio, $login, $email, $password
	);
	// В случае ошибок
	if(!$connect->query($sql)) die("Error: ". $connect->error);
	// В случае успешного добавления
	return header("Location:../index.php?message=Вы успешно зарегистровались");