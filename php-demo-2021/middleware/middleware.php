<?php
	// Старт сессии
	session_start();

	// Класс проверок авторизации и роли
	class Middleware {
		// Проверка на вход
		public function session() {
			// Если пользователь не авторизован
			if($_SESSION["auth"] != true) {
				// Присваивание сессии роли значение гостя
				$_SESSION["role"] = "guest";
			}
		}
		
		// Проверка на авторизацию
		public function auth() {
			// Если пользователь не авторизован
			if($_SESSION["auth"] != true) {
				// Перенаправление на главную страницу с сообщением об ошибке
				header("Location: ../index.php?message=Вы не авторизованы");
				exit;
			}
		}

		// Проверка на роль пользователя
		public function admin() {
			// Вызов функции проверки авторизации
			$this->auth();
			// Если пользователь не администратор
			if($_SESSION["role"] != "admin") {
				// Перенаправление на страницу пользователя с сообщением об ошибке
				header("Location: ../scripts/user_page.php?user_id=". $_SESSION["user_id"] ."&message=Вы не авторизованы");
				exit;
			}
		}
	}
?>