<?php
// Проверка авторизации
include "controllers/check.php";

// Подключение подключения к базе
include "connect.php";

$user_id = $_SESSION["user_id"];

// Запрос на получение запросов ползователя
$sql = sprintf("SELECT * FROM `applications` WHERE `user_id`='%s' ORDER BY `created_at` DESC", $user_id);
// Отправка запроса в базу
$result = $connect->query($sql);
// Проверка на наличие ошибок в исполнении запроса
if(!$result) die("Error: ". $connect->error);
// Получение данных из результата запроса
$app = "";
while($row = $result->fetch_assoc()) {
	$do = ($row["status"] == "Новая") ? '<p class="small"><a>Удалить заявку</a></p>' : "";
	$refusal = ($row["status"] == "Отклонена") ? '<p></p>' : "";
	$app .= sprintf('
		<div class="col">
			<h3>%s</h3>
			<p class="center">Статус заявки: <b>%s</b></p>
			<p>Категория заявки: <b>%s</b></p>
			<p class="center"><b>Описание:</b></p>
			<p>%s</p>
			%s
			<p class="small">%s</p>
		</div>
	', $row["title"], $row["status"], $row["category"], $row["description"], $do, $row["created_at"]);
}

// Запрос на получение категорий
$sql = "SELECT * FROM `categories`";
$result = $connect->query($sql);
$categories = "";
while($row = $result->fetch_assoc())
	$categories .= sprintf('<option value="%s">%s</option>', $row["category"], $row["category"]);

// Подключение хедера
include "header.php";
?>

	<main>
		<div class="content">
			
			<div class="head">Ваши заявки</div>
			<p class="small">Все | Новые | Решённые | Отклонённые</p>
			<!-- Вывод данных запросов -->
			<div class="row"><?= $app ?></div>

			<div class="head">Добавить заявку</div>
			<form action="controllers/app_add.php" enctype="multipart/form-data" method="POST">
				<input type="text" name="title" placeholder="Название (до 64 символов)" required pattern=".{1,64}">
				<textarea name="description" placeholder="Описание (до 256 символов)" required pattern=".{1,256}"></textarea>
				<select required name="category">
					<option value selected disabled>Категория заявки</option>
					<!-- Вывод категорий -->
					<?= $categories  ?>
				</select>
				<p class="left">Фотография заявки</p>
				<input type="file" required name="image">
				<button>Создать заявку</button>
			</form>

		</div>
	</main>

</body>
</html>