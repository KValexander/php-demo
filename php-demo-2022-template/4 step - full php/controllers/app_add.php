<?php
	// Проверка авторизации
	include "check.php";

	// Подключение подключения к базе
	include "../connect.php";
	
	// Получение id пользователя
	$user_id = $_SESSION["user_id"];

	// Получение данных
	$title = trim($_POST["title"]);
	$description = trim($_POST["description"]);
	$category = trim($_POST["category"]);

	// Получение данных изображения
	$size = getimagesize($_FILES["image"]["tmp_name"]);
	$end = "";
	// Проверка на расширение изображения
	if($size["mime"] == "image/png") $end = ".png";
	elseif ($size["mime"] == "image/jpeg") $end = ".jpg";
	elseif ($size["mime"] == "image/bmp") $end = ".bmp";
	else return header("Location:../profile.php?message=Файл не является изображением");
	
	// Получение размер изображения
	$filesize = filesize($_FILES["image"]["tmp_name"]);
	// Перевод размера в мб
	$filesize = $filesize / (1024 * 1024);
	// Проверка на размер изображения
	if($filesize > 2)
		return header("Location:../profile.php?message=Изображение не должно превышать 2мб");

	// Имя изображения
	$image_name = "1_". time() ."_". rand() . $end;
	// Путь до изображения
	$path = "../images/before/". $image_name;
	// Перемещение изображения в папку
	if(!move_uploaded_file($_FILES["image"]["tmp_name"], $path))
		return header("Location:../profile.php?message=Ошибка сохранения изображения");

	// Путь для добавления в базу данных
	$path = "images/before/". $image_name;

	// Добавление данных в базу
	$sql = sprintf("INSERT INTO `applications`(`user_id`, `title`, `description`, `category`, `path_image_before`, `status`) VALUES('%s', '%s', '%s', '%s', '%s', 'Новая')",
		$user_id,
		$connect->real_escape_string($title),
		$connect->real_escape_string($description),
		$connect->real_escape_string($category),
		$path
	);

	// В случае ошибки исполнения запроса
	if(!$connect->query($sql)) die("Error: ". $connect->error);

	// В случае успеха
	return header("Location:../profile.php?message=Заявка создана");
