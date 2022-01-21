<?php 
	// Файл хедера
	require("header.php");
	// Файл проверки пользователя на роль администратора
	require("middleware/admin.php");

	// Запрос на получение всех существующих категорий
	$cat_sql = "SELECT * FROM `category` ORDER BY `category_id` DESC";
	// Выполнение запроса
	$result = $link->query($cat_sql);

	// Если запрос успешен
	if($result) {
		// Количество записей
		$num = $result->num_rows;
		// Очистка переменной $cat
		$cat = '';

		// Если записей нет
		if($num == 0) {
			$cat = "<option>Заявки отсутствуют</option>";
		// Если записи есть
		} else {
			// Цикл записи данных в переменную
			while($row = $result->fetch_array()) {
				// Запись данных в переменную
				$cat .= '<option value="'. $row["category_id"] .'">'. $row["category"] .'</option>';
			}
		}
	// В случае некорректности выполнения запроса
	} else {
		$cat = "<option>Проблема вывода данных</option>";
	}
?>

<main>
	<div class="content">
		
		<div class="heading">Добавить категорию</div>
		<!-- Добавление категории -->
		<form action="scripts/category_add.php" method="GET">
			<!-- Название категории -->
			<input type="text" placeholder="Название категории" name="category">
			<!-- Кнопка отправления данных формы серверу -->
			<input type="submit" value="Добавить категорию">
		</form>

		<div class="heading">Удалить категорию</div>
		<!-- Удаление категории -->
		<form action="scripts/category_delete.php" method="GET">
			<!-- Список существующих категорий -->
			<select name="cat_id">
				<!-- Вывод пунктов списка категорий -->
				<?php print($cat) ?>
			</select>
			<!-- Кнопка отправления данных формы серверу -->
			<input type="submit" value="Удалить категорию">
		</form>
	</div>
</main>

<!-- Подключение файла Футера -->
<?php require("footer.php") ?>