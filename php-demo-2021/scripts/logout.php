<?php
	// Старт сессии
	session_start();
	// Файл проверки авторизации
	require("../middleware/auth.php");
	// Очищение сессий
	unset($_SESSION["user_id"]);
	unset($_SESSION["auth"]);
	unset($_SESSION["role"]);
	// Перенаправление на главную страницу
	header("Location: ../index.php");
	exit;
?>