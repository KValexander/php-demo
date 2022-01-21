<?php
	// Подключение проверки авторизации
	include "check.php";

	// Удаление сессий
	unset($_SESSION["user_id"]);
	unset($_SESSION["role"]);
	
	return header("Location:../index.php?message=Вы вышли");
