<?php
// Проверка авторизации
include "controllers/admin_check.php";

// Подключение подключения к базе
include "connect.php";

// Запрос на получение категорий
$sql = "SELECT * FROM `categories`";
$result = $connect->query($sql);
$categories = "";
while($row = $result->fetch_assoc())
	$categories .= sprintf('<option value="%s">%s</option>', $row["category_id"], $row["category"]);

// Запрос на получение новых заявок
$sql = "SELECT * FROM `applications` WHERE `status`='Новая' ORDER BY `created_at` DESC";
$result = $connect->query($sql);
if(!$result) die("Error: ". $connect->error);
$new = "";
while($row = $result->fetch_assoc())
	$new .= sprintf('
		<div class="col">
			<img src="%s">
			<h3>%s</h3>
			<p class="center">Статус заявки: <b>%s</b></p>
			<p>Категория заявки: <b>%s</b></p>
			<p class="center"><b>Описание:</b></p>
			<p>%s</p>
			<h3>Одобрение заявки</h3>
			<form action="controllers/app_approve.php" enctype="multipart/form-data" method="POST">
				<input type="file" required name="image">
				<button value="%s" name="app_id">Одобрить</button>
			</form>
			<h3>Отклонение заявки</h3>
			<form action="controllers/app_reject.php" method="POST">
				<textarea name="rejection_reason" placeholder="Причина отклонения (до 256 символов)" required pattern=".{1,256}"></textarea>
				<button value="%s" name="app_id">Отклонить</button>
			</form>
			<p class="small">%s</p>
		</div>
	',
	$row["path_image_before"],
	$row["title"],
	$row["status"],
	$row["category"],
	$row["description"],
	$row["application_id"],
	$row["application_id"],
	$row["created_at"]);

// Запрос на получение одобренных заявок
$sql = "SELECT * FROM `applications` WHERE `status`='Одобрена' ORDER BY `created_at` DESC";
$result = $connect->query($sql);
if(!$result) die("Error: ". $connect->error);
$approved = "";
while($row = $result->fetch_assoc())
	$approved .= sprintf('
		<div class="col">
			<img src="%s">
			<h3>%s</h3>
			<p class="center">Статус заявки: <b>%s</b></p>
			<p>Категория заявки: <b>%s</b></p>
			<p class="center"><b>Описание:</b></p>
			<p>%s</p>
			<p class="small">%s</p>
		</div>
	', $row["path_image_after"], $row["title"], $row["status"], $row["category"], $row["description"], $row["created_at"]);

// Запрос на получение отклоненных заявок
$sql = "SELECT * FROM `applications` WHERE `status`='Отклонена' ORDER BY `created_at` DESC";
$result = $connect->query($sql);
if(!$result) die("Error: ". $connect->error);
$rejected = "";
while($row = $result->fetch_assoc())
	$rejected .= sprintf('
		<div class="col">
			<img src="%s">
			<h3>%s</h3>
			<p class="center">Статус заявки: <b>%s</b></p>
			<p>Категория заявки: <b>%s</b></p>
			<p class="center"><b>Описание:</b></p>
			<p>%s</p>
			<p class="center"><b>Причина отклонения:</b></p>
			<p>%s</p>
			<p class="small">%s</p>
		</div>
	', $row["path_image_before"], $row["title"], $row["status"], $row["category"], $row["description"], $row["rejection_reason"], $row["created_at"]);

// Подключение хедера
include "header.php";
?>

	<main>
		<div class="content">

			<div class="head">Категории</div>
			<form action="controllers/category_add.php" method="POST">
				<div class="line">
					<input type="text" name="category" placeholder="Категория (до 64 символов)" required pattern=".{1,64}">
					<button>Добавить</button>
				</div>
			</form>
			<form action="controllers/category_delete.php">
				<div class="line">
					<select required name="category_id">
						<option value selected disabled>Категории</option>
						<!-- Вывод категорий -->
						<?= $categories ?>
					</select>
					<button>Удалить</button>
				</div>
			</form>
			
			<div class="head">Новые заявки</div>
			<!-- Вывод новых заявок -->
			<div class="row"><?= $new ?></div>

			<div class="head">Одобренные заявки</div>
			<!-- Вывод одобренных заявок -->
			<div class="row"><?= $approved ?></div>

			<div class="head">Отклоненные заявки</div>
			<!-- Вывод отклоненных заявок -->
			<div class="row"><?= $rejected ?></div>

		</div>
	</main>

</body>
</html>