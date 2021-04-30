<?php
	// Файл проверки пользователя на роль администратора
	require("../middleware/admin.php");
	// Подключение к базе
	require("../connect.php");

	// Если данные отправлены методом POST
	if(isset($_POST["app_id"])) {

		// Проверка является ли файл изображением
		if(!getimagesize($_FILES["image"]["tmp_name"])) {
			header("Location: /admin?&message=Файл должен быть изображением");
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
			header("Location: /admin?message=Поддерживаемые форматы изображения: jpeg, jpg, png и bmp");
			exit;
		}

		// Получение размер изображения
		$filesize = filesize($_FILES["image"]["tmp_name"]);
		// Перевод размера в мб
		$filesize = $filesize / (1024 * 1024);
		// Проверка на размер изображения
		if($filesize > 10) {
			header("Location: /admin?message=Изображение не должно превышать 10мб");
		}

		// Имя изображения
		$image_name = "1_". time() ."_". rand() . $end;
		// Путь до изображения
		$path = "../images/after/". $image_name;
		// Перемещение изображения в папку
		if(!move_uploaded_file($_FILES["image"]["tmp_name"], $path)) {
			header("Location: /admin?&message=Произошла ошибка с сохранением вашего изображения");
			exit();
		}
		// Путь для добавления в базу данных
		$path = "images/after/". $image_name;

		// Запись полученных данных в переменные
		$app_id = $link->real_escape_string(trim($_POST["app_id"]));
		$status = $link->real_escape_string(trim($_POST["change"]));

		// Запрос на обновление данных заявки
		$update_app_sql = sprintf("UPDATE `applications` SET `status` = '%s', `path_to_image_after`='%s' WHERE `application_id`='%d'",
			$status, $path, $app_id
		);

		// Проверка выполнения запроса
		if (!$link->query($update_app_sql)) {
			header("Location: /admin?message=Ошибка изменения данных. ". $link->error);
			exit;
		}

		// В случае успеха выполнения запроса
		header("Location: /admin?message=Статус заявки изменён на \"Решена\"");
		exit;
	}

	// Если данные отправлены методом GET
	elseif(isset($_GET["app_id"])) {
		// Запись полученных данных в переменные
		$app_id = $link->real_escape_string(trim($_GET["app_id"]));
		$status = $link->real_escape_string(trim($_GET["change"]));
		$rejection_reason = $link->real_escape_string(trim($_GET["rejection_reason"]));

		// Запрос на обновление данных заявки
		$update_app_sql = sprintf("UPDATE `applications` SET `status` = '%s', `rejection_reason`='%s' WHERE `application_id`='%d'",
			$status, $rejection_reason, $app_id
		);

		// Проверка выполнения запроса
		if (!$link->query($update_app_sql)) {
			header("Location: /admin?message=Ошибка изменения данных. ". $link->error);
			exit;
		}

		// В случае успеха выполнения запроса
		header("Location: /admin?message=Статус заявки изменён на \"Отклонена\"");
		exit;
	}
?>