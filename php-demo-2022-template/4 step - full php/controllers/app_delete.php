<?php
	// Проверка авторизации пользователя
	include "check.php";

	// Подключение подключения к базе
	include "../connect.php";

	// Получение id пользователя
	$user_id = $_SESSION["user_id"];

	// Проверка на наличие id заявки
	if(!isset($_GET["app_id"]))
		return header("Location:../profile.php?message=Передайте id заявки");

	// Получение id заявки
	$app_id = $_GET["app_id"];

	// Получение заявки
	$sql = sprintf("SELECT `user_id`, `status`, `path_image_before` FROM `applications` WHERE `application_id`='%s'", $app_id);
	$result = $connect->query($sql);
	if(!$result) die("Error: ". $connect->error);
	if(!$app = $result->fetch_assoc())
		return header("Location:../profile.php?message=Заявки не существует");

	// Проверка на статус
	if($app["status"] != "Новая")
		return header("Location:../profile.php?message=Удалять можно только заявки со статусом \"Новая\"");

	// Проверка на пользователя
	if($app["user_id"] != $user_id)
		return header("Location:../profile.php?message=Заявка вам не принадлежит");

	// Удаление изображения
	unlink("../".$app["path_image_before"]);

	// Запрос на удаление
	$sql = sprintf("DELETE FROM `applications` WHERE `application_id`='%s'", $app_id);

	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успеха
	return header("Location:../profile.php?message=Заявка удалена");