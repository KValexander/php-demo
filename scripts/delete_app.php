<?php
	// Старт сессии
	session_start();
	// Файл проверки авторизации
	require("../middleware/auth.php");
	// Подключение к базе
	require("../connect.php");

	// Получение id заявки
	$app_id = $_GET["app_id"];
	// Запрос на получение данных заявки для проверок и удаления изображения
	$app_sql = "SELECT `user_id`, `status`, `path_to_image_before` FROM `applications` WHERE `application_id`='$app_id'";
	// Выполнение запроса
	$result = $link->query($app_sql);

	// Если запрос успешен
	if($result) {
		// Получение данных запроса
		$row = $result->fetch_array();
		// Проверка пользователя желающего удалить заявку
		if($row["user_id"] != $_SESSION["user_id"]) {
			header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Это не ваша заявка");
			exit;
		}
		// Проверка статуса заявки
		if($row["status"] != "Новая") {
			header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Удалять можно только заявки со статусом \"Новая\"");
			exit;
		}

		// Удаление изображения с сервера
		$path = "../". $row["path_to_image_before"];
		$unlink = @unlink($path);

	// В случае некорректности выполнения запроса
	} else {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Ошибка проверки");
		exit;
	}

	// Запрос на удаление записи из базы данных
	$delete_app_sql = "DELETE FROM `applications` WHERE `application_id`='$app_id'";
	// Выполнение запроса
	$result = $link->query($delete_app_sql);

	// Проверка на успешность выполнения запроса
	if(!$link->query($delete_app_sql)) {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Ошибка удаления");
		exit;
	}
	
	// В случае успеха запроса
	header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Заявка удалена");
	exit;
?>