<?php
	// Старт сессии
	session_start();
	// Если пользователь не авторизован
	if($_SESSION["auth"] != true) {
		// Присваивание сессии роли значение гостя
		$_SESSION["role"] = "guest";
	}

?>