<?php 
	// Файл хедера
	require("header.php");
	// Файл проверки авторизации
	require("middleware/auth.php");

	// Если пользователь пытается зайти не на свою страницу
	if($_GET["user_id"] != $_SESSION["user_id"]) {
		// Перенаправление в личный кабинет с сообщением об ошибке
		header("Location: ../user_page.php?user_id=". $_SESSION["user_id"] ."&message=Вы не являетесь владельцем этой страницы");
		exit;
	}

	// Получение id пользователя
	$user_id = $_GET["user_id"];

	// Запрос на получение всех категорий
	$category_sql = "SELECT * FROM `category`";
	// Выполнение запроса
	$result = $link->query($category_sql);

	// Если запрос выполнился корректно
	if($result) {
		// Очистка переменной $cat
		$cat = '';
		// Цикл записи данных в переменную
		while($row = $result->fetch_array()) {
			$cat .= sprintf('<option value="%s">%s</option>',
				$row["category"], $row["category"]
			);
		}
	// В случае некорректности выполнения запроса
	} else {
		$cat = "<h3>Проблема вывода категорий</h3>";
	}

	// Запрос на получение всех заявок пользователя
	$applications_sql = "SELECT * FROM `applications` WHERE `user_id`='$user_id' ORDER BY `created_at` DESC";
	// Выполнение запроса
	$result = $link->query($applications_sql);

	// Если запрос выполнился корректно
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
				$app .= sprintf('
					<div class="wrap">
						<h3>%s</h3>
						<p id="status">Статус заявки: <b>%s</b></p>
						<p class="justify">Категория заявки: <b>%s</b></p>
						<h4>Описание:</h4>
						<p class="justify">%s</p>
						<p class="del"><a href="scripts/delete_app.php?app_id=%s">Удалить заявку</a></p>
						<p class="date">%s</p>
					</div>',
					$row["title"], $row["status"], $row["category"],
					$row["description"], $row["application_id"], $row["created_at"]
				);
			}
		}
	// В случае некорректности выполнения запроса
	} else {
		$app = "<h3>Ошибка вывода заявок</h3>";
	}
?>

<script>
	// Функция валидации данных формы
	function app_add() {
		// Получение данных формы
		let form = document.forms[0];
		// Переменные обработки ошибок
		let validator = {};
		let error = '';
		// Переменная с элементами формы для заполнения ошибок валидации
		let p_err = $("p.error");

		// Проверка поля Название заявки
		if(form.elements["title"].value == "") {
			error = "Введите Название заявки";
			validator.title = error;
		}

		// Проверка поля Название заявки по символам
		if(form.elements["title"].value.length >= 50) {
			error = "Название не должно превышать 50 символов";
			validator.title = error;
		}

		// Проверка поля Описание заявки
		if(form.elements["description"].value == "") {
			error = "Описание должно быть заполнено";
			validator.description = error;
		}

		// Проверка поля Описание заявки по символам
		if(form.elements["description"].value.length >= 500) {
			error = "Описание не должно превышать 500 символов";
			validator.description = error;
		}

		// Проверка списка Категория заявки
		if(form.elements["category"].value == "") {
			error = "Категория должна быть выбрана";
			validator.category = error;
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

	// Функция фильтрации заявок по статусу
	function app_filtration(status) {
		// Получение всех заявок
		let app = $(".wrap");

		// Если заявки отсутствуют
		if(app.length == 0) return;

		// Если переданный статус отсутствует
		if(status == undefined) {
			// Отображение всех заявок
			for(let i = 0; i < app.length; i++) {
				// Отображение заявки
				app[i].style.display = "block";
			}
			// Очищение блока сообщения
			$("#mess").html("");
			// Завершение выполнения функции
			return;
		}

		// Получение текста статуса у всех заявок
		let stat = $(".wrap #status b");
		// Фильтрация по статусу
		for(let i = 0; i < stat.length; i++) {
			// Проверка на статус
			if(stat[i].innerHTML == status) {
				// Отображение нужного блока
				app[i].style.display = "block";
				// Переход на следующую итерацию цикла
				continue;
			}
			// Скрытие заявки в случае несоответствия фильтрации
			app[i].style.display = "none";
		}

		// Счётчик
		let count = 0;
		// Смотрим сколько блоков скрыто
		$(".wrap").each(function(index) {
			if($(this).css('display') == "none") {
				count++;
			}
		});

		// Если все блоки скрыты, значит фильтрация не нашла заявок
		if(app.length == count) {
			// Выводим сообщение об отсутствии заявок фильтрации
			$("#mess").html("<h3 id='filtr'>Фильтрация ничего не нашла</h3>");
		// В ином случае удалем сообщение
		} else {
			$("#mess").html("");
		}
	}
</script>

<main>
	<div class="content">
		
		<div class="heading">Ваши заявки</div>
		<!-- Вызов фильтрации заявок по статусу -->
		<nav class="filtration">
			<a onclick="app_filtration('Новая')">Новые</a> |
			<a onclick="app_filtration('Решена')">Решённые</a> |
			<a onclick="app_filtration('Отклонена')">Отклонённые</a> |
			<a onclick="app_filtration()">Все</a>
		</nav>
		<!-- Заявки пользователя -->
		<div class="container">
			<?php print($app) ?>
			<!-- Блок вывода сообщения об отсутствии заявок фильтрации -->
			<div id="mess"></div>
		</div>

		<div class="heading">Создать заявку</div>

		<!-- Форма создания заявки -->
		<form enctype="multipart/form-data" action="scripts/application.php" method="POST" onsubmit="return app_add();">
			
			<!-- Название заявки -->
			<p class="error" id="title"></p>
			<input type="text" placeholder="Название" name="title">

			<!-- Описание заявки -->
			<p class="error" id="description"></p>
			<textarea name="description" placeholder="Описание"></textarea>

			<!-- Категория заявки -->
			<p class="error" id="category"></p>
			<select name="category">
				<!-- Будет выводится с помощью php из базы-->
				<option value="" disabled selected>Категория заявки</option>
				<?php print($cat) ?>
			</select>

			<!-- Фотография заявки -->
			<div class="left">
				<p>Фотография проблемы</p>
				<input type="file" name="image">
			</div>

			<!-- Кнопка отправки данных скрипту -->
			<input type="submit" value="Создать заявку">
		</form>

	</div>
</main>

<!-- Подключение файла Футера -->
<?php require("footer.php"); ?>