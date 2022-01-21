<?php
	// Старт сессии
	session_start();

	// Очистка переменной str
	$str = '';

	// Если посетитель является гостем, т.е не авторизован
	if($_SESSION["auth"] != true) {
		// Пункты меню Регистрация и Вход
		$str .= '
			<a href="index.php#register">Регистрация</a> |
			<a href="index.php#login">Вход</a>
		';
	}

	// Если пользователь авторизован
	if($_SESSION["auth"] == true) {
		// Пункт меню Главная
		$str = '<a href="/">Главная</a> | ';
		// Если пользователь является администратором
		if($_SESSION["role"] == "admin") {
			// Пункт меню Заявки
			$str .= '<a href="/admin">Заявки</a> |';
		}
		// Пункты меню Личный кабинет и Выход
		$str .= '
			<a href="user_page.php?user_id='. $_SESSION["user_id"] .'">Личный кабинет</a> |
			<a href="scripts/logout.php">Выход</a>';
	}

	// Вывод пунктов меню
	print($str);

?>