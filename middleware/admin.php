<?php
	// Старт сессии
	session_start();
	// Файл проверки авторизации
	require("auth.php");
	
	// Если пользователь не администратор
	if($_SESSION["role"] != "admin") {
		// Перенаправление на страницу пользователя с сообщением об ошибке
		header("Location: ../scripts/user_page.php?user_id=". $_SESSION["user_id"] ."&message=Вы не авторизованы");
		exit;
	}
?>