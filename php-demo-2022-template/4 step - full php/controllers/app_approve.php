<?php
	// Проверка авторизации
	include "admin_check.php";

	// Подключение подключения к базе
	include "../connect.php";

	// Получение данных
	$app_id = $_POST["app_id"];

	// Получение данных изображения
	$size = getimagesize($_FILES["image"]["tmp_name"]);
	$end = "";
	// Проверка на расширение изображения
	if($size["mime"] == "image/png") $end = ".png";
	elseif ($size["mime"] == "image/jpeg") $end = ".jpg";
	elseif ($size["mime"] == "image/bmp") $end = ".bmp";
	else return header("Location:../admin.php?message=Файл не является изображением");

	// Получение размер изображения
	$filesize = filesize($_FILES["image"]["tmp_name"]);
	// Перевод размера в мб
	$filesize = $filesize / (1024 * 1024);
	// Проверка на размер изображения
	if($filesize > 2)
		return header("Location:../admin.php?message=Изображение не должно превышать 2мб");

	// Имя изображения
	$image_name = "1_". time() ."_". rand() . $end;
	// Путь до изображения
	$path = "../images/after/". $image_name;
	// Перемещение изображения в папку
	if(!move_uploaded_file($_FILES["image"]["tmp_name"], $path))
		return header("Location:../admin.php?message=Ошибка сохранения изображения");

	// Путь для добавления в базу данных
	$path = "images/after/". $image_name;

	// Изменени заявки
	$sql = sprintf("UPDATE `applications` SET `status`='Одобрена', `path_image_after`='%s' WHERE `application_id`='%s'", $path, $app_id);

	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успеха
	return header("Location:../admin.php?message=Заявка одобрена");