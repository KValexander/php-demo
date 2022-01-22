<?php
	// Проверка авторизации
	include "admin_check.php";

	// Подключение подключения к базе
	include "../connect.php";

	// Получение данных
	$category = trim($_POST["category"]);

	// Добавление данных в базу
	$sql = sprintf("INSERT INTO `categories` VALUES(NULL, '%s')", $connect->real_escape_string($category));
	// В случае ошибки исполнения запроса
	if(!$connect->query($sql))
		return header("Location:../admin.php?message=Ошибка добавления категории");

	// В случае успеха
	return header("Location:../admin.php?message=Категория добавлена");