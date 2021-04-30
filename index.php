<?php
	// Подключение файла Хедера
	require("header.php");

	// Запрос на получение последних 4 решённых заявок
	$applications_sql = "SELECT * FROM `applications` WHERE `status`='Решена' ORDER BY `created_at` DESC LIMIT 4";
	// Выполнение запроса
	$result = $link->query($applications_sql);

	// Если запрос выполнен успешно
	if($result) {
		// Количество записей
		$num = $result->num_rows;
		// Очистка переменной $app
		$app = '';

		// Если записей нет
		if($num == 0) {
			$app = "<h3>Решённые проблемы отсутствуют</h3>";
		// Если записи есть
		} else {
			// Цикл записи данных в переменную
			while ($row = $result->fetch_array()) {
				$app .= sprintf('
					<div class="wrap">
						<div class="image">
							<div class="before"><img src="%s" /></div>
							<div class="after"><img src="%s" /></div>
						</div>
						<h3>%s</h3>
						<p class="justify">Категория заявки: <b>%s</b></p>
						<p class="date">%s</p>
					</div>',
					$row["path_to_image_before"], $row["path_to_image_after"], $row["title"],
					$row["category"], $row["created_at"]
				);
			}
		}

	// В случае некорректности выполнения запроса
	} else {
		$app = "<h3>Ошибка вывода заявок</h3>";
	}

	// Функция получения количества текущих решёных заявок
	function count_app() {
		// Подключение к базе данных
		require("connect.php");
		// Запрос на получение числа решённых заявок
		$count_sql = "SELECT COUNT(*) FROM `applications` WHERE `status`='Решена'";
		// Выполнение запроса
		$result = $link->query($count_sql);
		// Если запрос выполнен успешно
		if($result) {
			// Получение данных из запроса
			$row = $result->fetch_array();
			// Возвращение числа решённых заявок
			return print($row['COUNT(*)']);
		} else {
			print_r("Возникли проблемы");
		}
	}
?>

<script>
	$(function() {
		// Скрытие одного из изображений
		$(".image div.before").css("display", "none");

		// Событие отображения старого изображения при наведении
		$(".image").mouseenter(function() {
			$(this.lastElementChild).fadeOut(0);
			$(this.firstElementChild).fadeIn(200);
		});

		// Событие отображения текущего изображения при отведении
		$(".image").mouseleave(function() {
			$(this.firstElementChild).fadeOut(0);
			$(this.lastElementChild).fadeIn(200);
		});

		// Функция обновления счётчика количества заявок
		let count_app = function() {
			// Получаю число заявок от php функции
			let count = "<?php count_app() ?>";
			// Вывод числа
			$(".count b").html(count);
			// Постоянный вызов функции самой себя раз в 5 секунд
			setTimeout(arguments.callee, 5000);
		}

		// Первый вызов функции
		count_app();
	});

	// Запрос на регистрацию
	function register() {
		// Получение данных формы
		let form = document.forms[0];
		// Переменные обработки ошибок
		let validator = {};
		let error = '';
		// Переменная с элементами формы для заполнения ошибок валидации
		let p_err = $("p.error");

		// Регулярные выражения для проверки валидации
		let fio_reg = /^[а-яА-ЯёЁ\-\ ]+$/;
		let login_reg = /^[a-zA-Z]+$/;
		let email_reg = /@/;

		// Валидация поля ФИО
		if(!fio_reg.test(form.elements["fio"].value)) {
			error = "ФИО должен содержать только кириллические буквы, дефис и пробелы";
			validator.fio = error;
		}

		// Валидация поля Логин
		if(!login_reg.test(form.elements["login"].value)) {
			error = "Логин должен содержать только латиницу";
			validator.login = error;
		}

		// Валидация поля Email
		if(!email_reg.test(form.elements["email"].value)) {
			error = "Email должно содержать валидный email формат";
			validator.email = error;
		}

		// Валидация поля Пароль
		if(form.elements["password"].value == "" ) {
			error = "Поле Пароль должно быть заполнено";
			validator.password = error;
		}

		// Подтверждение пароля
		if(form.elements["password_check"].value == "") {
			error = "Поле Подтверждение пароля должно быть заполнено";
			validator.password_check = error;
		}

		// Валидация совпадения полей Пароль и Подтверждение пароля
		if(form.elements["password"].value != form.elements["password_check"].value) {
			error = "Пароли не совпадают";
			validator.password_match = error;
		}

		// Валидация Согласия на обработку данных
		if(!document.querySelector("input[name=privacy]").checked) {
			error = "Согласие обязательно";
			validator.privacy = error;
		}

		// Проверка наличия ошибок в валидации
		if(Object.keys(validator).length != 0) {
			// Вывод ошибок валидации
			for (let i = 0; i < p_err.length; i++) {
				// Проверка на пустоту валидации
				if(validator[p_err[i].id] == undefined) validator[p_err[i].id] = "";
				// Добавление сообщения об ошибке
				p_err[i].innerHTML = validator[p_err[i].id];
				// Добавление или удаление класса ошибки
				if(p_err[i].innerHTML != "") $("form#reg input[name="+ p_err[i].id +"]").addClass('error');
				else $("form#reg input[name="+ p_err[i].id +"]").removeClass('error');
			}
			// Отмена отправки данных серверу
			return false;
		}

		// Отправка данных серверу
		return true;
	}
</script>

<main onload="image_display()">
	<div class="content">
		
		<div class="heading">Последние решённые проблемы</div>
		<!-- Счётчик количества решённых заявок -->
		<nav class="count">
			<p>Количество решённых заявок: <b></b></p>
		</nav>
		<!-- Последние решённый проблемы -->
		<div class="container">
			<?php print($app) ?>
		</div>

		<div class="heading" id="register">Регистрация</div>

		<!-- Форма регистрации, метод POST -->
		<form action="scripts/register.php" method="POST" onsubmit="return register();" id="reg">

			<!-- ФИО -->
			<p class="error" id="fio"></p>
			<input type="text" placeholder="ФИО" name="fio">

			<!-- Логин -->
			<p class="error" id="login"></p>
			<input type="text" placeholder="Логин" name="login">

			<!-- Email -->
			<p class="error" id="email"></p>
			<input type="text" placeholder="Email" name="email">

			<!-- Пароль -->
			<p class="error" id="password_match"></p>
			<p class="error" id="password"></p>
			<input type="password" placeholder="Пароль" name="password">

			<!-- Подтверждение пароля -->
			<p class="error" id="password_check"></p>
			<input type="password" placeholder="Повтор пароля" name="password_check">

			<!-- Согласие на обработку персональных данных -->
			<div class="left">
				<p class="error" id="privacy"></p>
				<input type="checkbox" name="privacy"> Согласие на обработку персональных данных
			</div>

			<!-- Отправка данных файлу регистрации -->
			<input type="submit" value="Зарегистрироваться">
		</form>

		<div class="heading" id="login">Вход</div>

		<!-- Форма авторизации, метод GET -->
		<form action="scripts/login.php" method="GET">

			<!-- Логин -->
			<input type="text" placeholder="Логин" name="login">

			<!-- Пароль -->
			<input type="password" placeholder="Пароль" name="password">

			<!-- Кнопка входа -->
			<input type="submit" value="Войти">
			
		</form>

	</div>
</main>

<!-- Подключение файла Футера -->
<?php require("footer.php") ?>