<?php
	// Подключение файла с переменными для подключения к БД
	require("config.php");
	// Подключение к базе данных
	$link = @new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
	// Установка кодировки
	@$link->set_charset("utf8");

	// Проверка на установку соединения
	if($link->connect_errno) {
		die("Ошибка соединения: ". $link->connect_errno);
	}
?>