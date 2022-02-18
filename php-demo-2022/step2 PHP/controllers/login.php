<?php
	session_start();
	include "../connect.php";

	$sql = sprintf("SELECT * FROM `users` WHERE `login`='%s'", $_POST["login"]);
	if(!$result = $connect->query($sql))
		return die("Ошибка получения данных: ". $connect->query);

	if($user = $result->fetch_assoc()) {
		if($user["password"] == $_POST["password"]) {

			$_SESSION["user_id"] = $user["user_id"];
			$_SESSION["role"] = $user["role"];

			return header("Location:../cart.php");
		}
	}

	return header("Location:../index.php?message=Ошибка логина или пароля");