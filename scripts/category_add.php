<?php
	// Файл проверки пользователя на роль администратора
	require("../middleware/admin.php");
	// Подключение к базе
	require("../connect.php");

	// Запись полученных данных в переменные
	$category = $link->real_escape_string(trim($_GET["category"]));

	// Запрос на добавление категории в базу
	$insert_cat_sql = sprintf("INSERT INTO `category`(`category`) VALUES ('%s')", $category );

	// Выполнение запроса, в случае неудачи вывод сообщения об ошибке
	if(!$link->query($insert_cat_sql)) {
		header("Location: ../category_page.php?message=Ошибка вставки данных");
		exit;
	}

	// В случае успеха
	header("Location: ../category_page.php?message=Категория добавлена");
	exit;
?>