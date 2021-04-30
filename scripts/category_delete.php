<?php
	// Файл проверки пользователя на роль администратора
	require("../middleware/admin.php");
	// Подключение к базе
	require("../connect.php");

	// Запись полученных данных в переменные
	$cat_id = $link->real_escape_string(trim($_GET["cat_id"]));

	// Запрос для получения данных категории на проверку её существования
	$check_cat_sql = "SELECT * FROM `category` WHERE `category_id`='$cat_id'";
	// Выполнение запроса
	$result = $link->query($check_cat_sql);
	// В случае неудачи вывод сообщения об ошибке
	if(!$result) {
		header("Location: ../category_page.php?message=Ошибка проверки");
		exit;
	}
	// Получение данных запроса
	$row = $result->fetch_array();
	// Запись категории в переменную
	$category = $row["category"];

	// Запрос на удаление всех записей с этой категорией
	$del_app_sql = "DELETE FROM `applications` WHERE `category`='$category'";
	// Выполнение запроса, в случае неудачи вывод сообщения об ошибке
	if(!$link->query($del_app_sql)) {
		header("Location: ../category_page.php?message=Ошибка удаления заявок");
		exit;
	}

	// Запрос на удаление самой категории
	$del_cat_sql = "DELETE FROM `category` WHERE `category_id`='$cat_id'";
	// Выполнение запроса,  в случае неудачи вывод сообщения об ошибке
	if(!$link->query($del_cat_sql)) {
		header("Location: ../category_page.php?message=Ошибка удаления категории");
		exit;
	}

	// В случае успеха
	header("Location: ../category_page.php?message=Категория удалена");
	exit;

?>