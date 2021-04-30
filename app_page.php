<?php
	// Файл хедера
	require("header.php");
	// Файл проверки пользователя на роль администратора
	require("middleware/admin.php");

	// Функция возвращения html в зависимости от статуса заявки
	function application_out($status) {
		//Подключение файла соединения с базой данной
		require("connect.php");
		// Запрос на получение всех заявок со статутом "Новая"
		$new_sql = "SELECT * FROM `applications` WHERE `status`='Новая' ORDER BY `created_at` DESC";
		// Запрос на получение всех заявок со статутом "Решена"
		$solved_sql = "SELECT * FROM `applications` WHERE `status`='Решена' ORDER BY `created_at` DESC";
		// Запрос на получение всех заявок со статутом "Отклонена"
		$rejected_sql = "SELECT * FROM `applications` WHERE `status`='Отклонена' ORDER BY `created_at` DESC";

		// Проверка на статус
		if($status == "new") {
			// Выполнение первого запроса
			$result = $link->query($new_sql);
		} elseif ($status == "solved") {
			// Выполнение второго запроса
			$result = $link->query($solved_sql);
		} elseif($status == "rejected") {
			// Выполнение третьего запроса
			$result = $link->query($rejected_sql);
		}

		// Если запрос выполнен успешно
		if($result) {
			// Количество записей
			$num = $result->num_rows;
			// Очистка переменной $app
			$app = '';
			// Если записей нет
			if($num == 0) {
				$app = "<h3>Заявки отсутствуют</h3>";
			// Если записи есть
			} else {
				// Цикл записи данных в переменную
				while ($row = $result->fetch_array()) {
					// Проверка на состояние заявки для выбора нужного изображения
					if($status == "new") $image = $row["path_to_image_before"];
					if($status == "rejected") $image = $row["path_to_image_before"];
					if($status == "solved") $image = $row["path_to_image_after"];
					// Запись данных в переменную
					$app .= '
						<div class="wrap">
							<div class="image">
								<div class="before"><img src="'. $image .'" /></div>
							</div>
							<h3>'. $row["title"] .'</h3>
							<p id="status">Статус заявки: <b>'. $row["status"] .'</b></p>
							<p class="justify">Категория заявки: <b>'. $row["category"] .'</b></p>
							<h4>Описание:</h4>
							<p class="justify">'. $row["description"] .'</p>';
							if($status == "new") {
								$app .= '
									<p>
										<select onchange="change_app(event)" id="'. $row["application_id"] .'">
											<option disabled selected>Выберите тип действий</option>
											<option value="Решена">Решить</option>
											<option value="Отклонена">Отклонить</option>
										</select>
									</p>
									<div id="change_'. $row["application_id"] .'"></div>';
							} else if($status == "rejected") {
								$app .= '
									<h4>Причина отказа:</h4>
									<p class="justify">'. $row["rejection_reason"] .'</p>
								';
							}
							$app .= '<p class="date">'. $row["created_at"] .'</p>
						</div>
					';
				}
			}
		// В случае некорректности выполнения запроса
		} else {
			$app = "<h3>Ошибка вывода заявок</h3>";
		}

		// Возвращение данных
		return print($app);
	}
?>

<script>
	// Функция вывода полей в зависимости от выбора действия для заявки
	function change_app(e) {
		// Переменная вывода данных
		let out;
		// Проверка выбора пункта из списка
		if(e.target.value == "Решена") {
			// Запись данных в переменную
			out = `
				<form enctype="multipart/form-data" action="scripts/change_status_app.php" method="POST" onsubmit="return validation_app()">
					<p><b>Доказательство решения проблемы:</b></p>
					<input type="hidden" value="${e.target.value}" name="change">
					<input type="hidden" value="${e.target.id}" name="app_id">
					<input type="file" name="image"> <br>
					<input type="submit" value="Отправить">
				</form>
			`;
		} else if (e.target.value == "Отклонена") {
			// Запись данных в переменную
			out = `
				<form action="scripts/change_status_app.php" method="GET" onsubmit="return validation_app()">
					<input type="hidden" value="${e.target.value}" name="change">
					<input type="hidden" value="${e.target.id}" name="app_id">
					<p class="error" id="rejection_reason"></p>
					<textarea name="rejection_reason" placeholder="Причина отказа"></textarea>
					<input type="submit" value="Отправить">
				</form>
			`;
		}

		// Вывод данных в форму
		$("#change_"+e.target.id).html(out);
	}

	// Функция валидация данных формы перед отправкой серверу
	function validation_app() {
		// Получение данных формы
		let form = document.forms[0];
		// Переменные обработки ошибок
		let validator = {};
		let error = '';
		// Переменная с элементами формы для заполнения ошибок валидации
		let p_err = $("p.error");

		// Валидация поля причин отказа выполнения заявки на пустоту
		if(form.elements['rejection_reason'].value == "") {
			error = "Причина отказа должна быть заполнена";
			validator.rejection_reason = error;
		}


		// Валидация поля причин отказа выполнения заявки на количество символов
		if(form.elements['rejection_reason'].value.length > 500) {
			error = "Причина отказа не должна превышать 500 символов";
			validator.rejection_reason = error;
		}

		// Проверка наличия ошибок в валидации
		if(Object.keys(validator).length != 0) {
			// Вывод ошибок валидации
			for (let i = 0; i < p_err.length; i++) {
				// Проверка на пустоту валидации
				if(validator[p_err[i].id] == undefined) validator[p_err[i].id] = "";
				// Добавление сообщения об ошибке
				p_err[i].innerHTML = validator[p_err[i].id];
			}
			// Отмена отправки данных серверу
			return false;
		}

		// Отправка данных серверу
		return true;
	}
</script>

<main>
	<div class="content">
		
		<div class="heading">Новые заявки</div>
		<!-- Меню для перехода на страницу создания и удаления категорий -->
		<nav class="category"> <a href="category_page.php">Категории</a> </nav>
		<!-- Новые заявки -->
		<div class="container">
			<?php application_out('new'); ?>
		</div>

		<div class="heading">Решённые заявки</div>
		<!-- Решённые заявки -->
		<div class="container">
			<?php application_out('solved'); ?>
		</div>

		<div class="heading">Отклонённые заявки</div>
		<!-- Отклонённые заявки -->
		<div class="container">
			<?php application_out('rejected'); ?>
		</div>

	</div>
</main>

<!-- Подключение файла Футера -->
<?php require("footer.php") ?>