<?php
	include "controllers/check_admin.php";
	include "connect.php";

	$sql = "SELECT * FROM `products` WHERE `product_id`=".$_GET["id"];
	$product = $connect->query($sql)->fetch_assoc();

	$result = $connect->query("SELECT * FROM `categories`");
	$categories = "";
	while($row = $result->fetch_assoc()) {
		$selected = ($product["category"] == $row["category"]) ? "selected" : "";
		$categories .= sprintf('<option value="%s" %s>%s</option>', $row["category"], $selected, $row["category"]);
	}

	include "header.php";
?>

	<main>
		<div class="content">
			
			<div class="head">Изменить товара</div>
			<form enctype="multipart/form-data" action="controllers/update_product.php" method="POST">
				<input type="hidden" name="id" value="<?= $product["product_id"] ?>">
				<input type="hidden" name="path" value="<?= $product["path"] ?>">
				<input type="text" placeholder="Название" name="name" value="<?= $product["name"] ?>" required>
				<input type="number" placeholder="Цена" name="price" value="<?= $product["price"] ?>" required>
				<input type="text" placeholder="Страна производитель" name="country" value="<?= $product["country"] ?>" required>
				<input type="number" placeholder="Год выпуска" name="year" value="<?= $product["year"] ?>" required>
				<input type="text" placeholder="Модель" name="model" value="<?= $product["model"] ?>" required>
				<select name="category" required>
					<option value selected disabled>Категория</option>
					<?= $categories ?>
				</select>
				<input type="number" placeholder="Количество на складе" name="count" value="<?= $product["count"] ?>" required>
				<p class="text-left">Фотография товара</p>
				<input type="file" name="image">
				<button>Изменить</button>
			</form>

		</div>
	</main>



<?php include "footer.php" ?>