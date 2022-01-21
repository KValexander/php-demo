<?php
	session_start();
	include "../connect.php";

	// Получение данных
	$login = $_POST["login"];
	$password = $_POST["password"];

	// Авторизация
	$sql = sprintf("SELECT * FROM `users` WHERE `login`='%s'", $login);
	$result = $connect->query($sql);
	if(!$result) die("Error: ". $connect->error);
	if($user = $result->fetch_assoc()) {
		if($user["password"] == $password) {
			$_SESSION["user_id"] = $user["user_id"];
			$_SESSION["role"] = $user["role"];
			return header("Location:../profile.php");
		} else return header("Location:../index.php?message=Пароли не совпадают");
	} else return header("Location:../index.php?message=Пользователь не найден");
