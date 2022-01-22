<?php
	// Проверка авторизации
	include "admin_check.php";

	// Подключение подключения к базе
	include "../connect.php";

	// Получение данных
	$app_id = $_POST["app_id"];
	$rejection_reason = trim($_POST["rejection_reason"]);

	// Изменени заявки
	$sql = sprintf("UPDATE `applications` SET `status`='Отклонена', `rejection_reason`='%s' WHERE `application_id`='%s'",
		$connect->real_escape_string($rejection_reason), $app_id);

	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успеха
	return header("Location:../admin.php?message=Заявка отклонена");