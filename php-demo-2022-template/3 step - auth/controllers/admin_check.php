<?php
	// Проверка на авторизацию
	include "check.php";

	// Проверка на роль администратора
	if($_SESSION["role"] != "admin")
		return header("Location:../profile.php?message=Недостаточный уровень доступа");
