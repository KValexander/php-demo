<?php
	// Старт сессии
	session_start();
	// Файл проверки авторизации
	require("../middleware/auth.php");

	// Проверка является ли файл изображением
	if(!getimagesize($_FILES["image"]["tmp_name"])) {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Файл должен быть изображением");
		exit;
	}

	// Получение данных изображения
	$size = getimagesize($_FILES["image"]["tmp_name"]);
	// Проверка на расширение изображения
	if($size["mime"] == "image/png") { // png
		$end = ".png";
	} elseif ($size["mime"] == "image/jpeg") { // jpeg, jpg
		$end = ".jpg";
	} elseif ($size["mime"] == "image/bmp") { // bmp
		$end = ".bmp";
	} else { // в случае иных расширений
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Поддерживаемые форматы изображения: jpeg, jpg, png и bmp");
		exit;
	}

	// Получение размер изображения
	$filesize = filesize($_FILES["image"]["tmp_name"]);
	// Перевод размера в мб
	$filesize = $filesize / (1024 * 1024);
	// Проверка на размер изображения
	if($filesize > 10) {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Изображение не должно превышать 10мб");
	}

	// Имя изображения
	$image_name = "1_". time() ."_". rand() . $end;
	// Путь до изображения
	$path = "../images/before/". $image_name;
	// Перемещение изображения в папку
	if(!move_uploaded_file($_FILES["image"]["tmp_name"], $path)) {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Произошла ошибка с сохранением вашего изображения");
		exit();
	}
	// Путь для добавления в базу данных
	$path = "images/before/". $image_name;

	// Подключение к базе
	require("../connect.php");

	// Запись полученных данных в переменные
	$title = $link->real_escape_string(trim($_REQUEST["title"]));
	$description = $link->real_escape_string(trim($_REQUEST["description"]));
	$category = $link->real_escape_string(trim($_REQUEST["category"]));

	// Запрос на добавление данных в базу
	$insert_sql = sprintf("INSERT INTO `applications`(`user_id`, `title`, `description`, `category`, `path_to_image_before`, `status`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
		$_SESSION["user_id"],
		$title,
		$description,
		$category,
		$path,
		"Новая"
	);

	// Проверка выполнения запроса
	if (!$link->query($insert_sql)) {
		header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Ошибка вставки данных. ". $link->error);
		exit;
	}

	header("Location: ../user_page.php?user_id=". $_SESSION['user_id'] ."&message=Заявка создана");
	exit();

?>